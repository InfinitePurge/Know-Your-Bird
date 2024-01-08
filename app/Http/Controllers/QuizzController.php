<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizAttempt;
use Illuminate\Support\Str;
use App\Models\Answer;
use Illuminate\Support\Facades\Log;

class QuizzController extends Controller
{
    /**
     * Display the quiz page for a specific theme.
     *
     * @param string $title The title of the quiz theme.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse The quiz view or a redirect to the quiz completed page.
     */
    public function index($title)
    {
        // Retrieve the quiz theme with its questions and answers
        $theme = Quiz::where('title', $title)->with('questions.answers')->firstOrFail();

        // Get the current question index from the session
        $questionIndex = session('questionIndex', 1);

        // Check if the quiz is already completed
        if ($questionIndex > $theme->questions->count()) {
            return $this->quiz_completed($title);
        }

        // Set the start time only if it's the first question and there's no timeStart in the session
        if ($questionIndex === 1 && !session()->has('timeStart')) {
            session(['timeStart' => now()]);
        }

        // Redirect the user to the quiz completed page if they try to access a question that doesn't exist
        if ($questionIndex > $theme->questions->count()) {
            return $this->quiz_completed($title);
        }

        // Get the current question
        $currentQuestion = $theme->questions[$questionIndex - 1];

        // Encrypt the AnswerID for each answer in the current question
        foreach ($currentQuestion->answers as $answer) {
            $answer->encrypted_id = encrypt($answer->AnswerID);
        }

        // Render the quiz view with the theme and current question
        return view('quizz', [
            'theme' => $theme,
            'question' => $currentQuestion
        ]);
    }

    
    /**
     * Process the user's answer to a quiz question.
     *
     * @param Request $request The HTTP request object.
     * @param string $title The title of the quiz.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the next question or completion status.
     */
    public function answerQuestion(Request $request, $title)
    {
        // Validate the encrypted chosen_answer_id (it will no longer be an integer)
        $request->validate([
            'chosen_answer_id' => 'required'
        ]);

        // Retrieve the theme, questions, and answers.
        $theme = Quiz::where('title', $title)->with('questions.answers')->firstOrFail();
        $questionIndex = session('questionIndex', 1);
        $question = $theme->questions[$questionIndex - 1];

        // Generate or retrieve an attempt ID.
        $attemptId = $request->session()->get('attempt_id');
        if (!$attemptId) {
            $attemptId = $this->generateUniqueAttemptId();
            $request->session()->put('attempt_id', $attemptId);
        }

        try {
            // Decrypt the chosen answer ID from the request.
            $submittedAnswerId = decrypt($request->input('chosen_answer_id'));

            // Check if the answer is correct.
            $isCorrect = $this->processAnswer($submittedAnswerId, $question);

            // Save the user's answer.
            $this->saveAnswer($request, $theme, $question, $isCorrect, $attemptId, $submittedAnswerId);

            // Update the question index in the session.
            $currentQuestionIndex = session('questionIndex', 1);
            session(['questionIndex' => $currentQuestionIndex + 1]);

            // Prepare the next question or finish the quiz
            if ($currentQuestionIndex < $theme->questions->count()) {
                // Fetch the next question
                $nextQuestion = $theme->questions[$currentQuestionIndex];

                // Shuffle the answers for the next question
                $shuffledAnswers = $nextQuestion->answers->shuffle();

                // Encrypt the AnswerID for each shuffled answer and append to a new collection
                $shuffledAnswersWithEncryptedId = $shuffledAnswers->map(function ($answer) {
                    return [
                        'AnswerID' => $answer->AnswerID,
                        'AnswerText' => $answer->AnswerText,
                        'isCorrect' => $answer->isCorrect, // Be cautious with sending this to the client side
                        'encrypted_id' => encrypt($answer->AnswerID)
                    ];
                });

                // Return the next question and shuffled answers
                return response()->json([
                    'status' => 'continue',
                    'nextQuestion' => [
                        'question' => $nextQuestion->question,
                        'image_url' => $nextQuestion->image_url,
                        'answers' => $shuffledAnswersWithEncryptedId
                    ],
                ]);
            } else {
                // Quiz is completed
                return response()->json(['status' => 'completed']);
            }
        } catch (\Exception $e) {
            Log::error('Error processing quiz answer: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again.']);
        }
    }

    /**
     * Generates a unique attempt ID.
     * 
     * @return string The unique attempt ID.
     */
    private function generateUniqueAttemptId()
    {
        $attemptId = Str::random(20);
        // Check if the attempt ID already exists in the database.
        $exists = QuizAttempt::where('attempt_id', $attemptId)->exists();
        // If it exists, generate a new one.
        if ($exists) {
            return $this->generateUniqueAttemptId();
        }
        return $attemptId;
    }

    /**
     * Compares the submitted answer ID with the correct answer.
     * 
     * @param int $submittedAnswerId The ID of the submitted answer.
     * @param Question $question The current question object.
     * @return bool Returns true if the submitted answer is correct, false otherwise.
     */
    private function processAnswer($submittedAnswerId, $question)
    {
        // Fetch the correct answer for the question.
        $correctAnswer = $question->answers->where('isCorrect', true)->first();
        return $submittedAnswerId === optional($correctAnswer)->AnswerID;
    }

    /**
     * Saves the user's or guest's answer to the database.
     * 
     * @param \Illuminate\Http\Request $request The current request object.
     * @param Quiz $theme The current quiz object.
     * @param Question $question The current question object.
     * @param bool $isCorrect Indicates whether the submitted answer is correct.
     * @param string $attemptId The unique ID for the quiz attempt.
     * @param int $submittedAnswerId The ID of the submitted answer.
     */
    private function saveAnswer($request, $theme, $question, $isCorrect, $attemptId, $submittedAnswerId)
    {
        $userAnswers = session()->get('user_answers', []);
        $userAnswers[] = [
            'question_id' => $question->id,
            'chosen_answer_id' => $submittedAnswerId,
            'isCorrect' => $isCorrect
        ];
        session()->put('user_answers', $userAnswers);
    }

    /**
     * Displays the theme selection page for the quiz.
     * 
     * @return \Illuminate\View\View
     */
    public function theme()
    {
        $quizzes = Quiz::select('title')->get();
        // Reset any existing quiz session data.
        $this->resetQuizSession();
        return view('theme', compact('quizzes'));
    }

    /**
     * Handles the completion of a quiz, calculating and displaying the results.
     * 
     * @param string $title The title of the quiz.
     * @return \Illuminate\View\View
     */
    public function quiz_completed($title)
    {
        $theme = Quiz::where('title', $title)->firstOrFail();
        $timeSpend = $this->countTimeSpend();

        // Retrieve answers and calculate the score
        $userAnswers = collect(session('user_answers', []));

        // Retrieve answers from the session
        $sessionAnswers = session('user_answers', []);

        // Format the session answers for display
        $userAnswers = collect($sessionAnswers)->map(function ($answer) {
            $question = Question::with('answers')->find($answer['question_id']);
            $chosenAnswer = Answer::find($answer['chosen_answer_id']);
            return (object)[
                'question' => $question,
                'answer' => $chosenAnswer,
                'isCorrect' => $answer['isCorrect']
            ];
        });

        $score = $this->calculateScore($userAnswers);

        // Save the quiz attempt for authenticated users
        $quizId = $theme->id;
        $this->saveQuizAttempt($quizId, $score, $timeSpend);

        // Reset the quiz session.
        $this->resetQuizSession();

        return view('quiz_completed', compact('theme', 'userAnswers', 'score', 'timeSpend'));
    }

    /**
     * Calculates the score based on the user's answers.
     *
     * @param Collection $userAnswers The collection of user's answers.
     * @return float The calculated score as a percentage.
     */
    private function calculateScore($userAnswers)
    {
        $totalQuestions = $userAnswers->count();
        $correctAnswers = $userAnswers->filter(function ($answer) {
            return $answer->isCorrect; // Accessing isCorrect as a property of the object
        })->count();

        return $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;
    }

    /**
     * Counts the time spent on a quiz.
     * 
     * @return int The time spent in seconds.
     */
    private function countTimeSpend()
    {
        // Retrieve the start time from the session.
        $timeStart = session('timeStart');
        // Retrieve the end time.
        $timeEnd = now();

        // Calculate and return the time spent in seconds.
        return $timeEnd->diffInSeconds($timeStart) + 1;
    }

    /**
     * Resets the quiz-related session data.
     */
    private function resetQuizSession()
    {
        session()->forget(['questionIndex', 'attempt_id', 'guest_answers', 'timeStart', 'user_answers']);
    }


    /**
     * Saves the quiz attempt to the database.
     *
     * @param int $quizId The ID of the quiz.
     * @param int $score The score achieved in the quiz.
     * @param int $timeSpend The time spent on the quiz.
     * @return void
     */
    private function saveQuizAttempt($quizId, $score, $timeSpend)
    {
        if (auth()->check()) {
            $attemptId = session('attempt_id');
            $userId = auth()->id();
            $userAnswers = session()->get('user_answers', []);

            QuizAttempt::create([
                'user_id' => $userId,
                'quiz_id' => $quizId,
                'attempt_id' => $attemptId,
                'time_spend' => $timeSpend,
                'score' => $score,
                'answers' => $userAnswers
            ]);

            // Clear the answers from the session after saving
            session()->forget('user_answers');
        }
    }
}
