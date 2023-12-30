<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\UserQuestionAnswers;
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
     * Process the user's answer for a quiz question and save the response.
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $title The title of the quiz.
     * @return \Illuminate\Http\RedirectResponse
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
        } catch (\Exception $e) {
            return back()->with('error', 'An unexpected error occurred. Please try again.');
        }

        // Update the question index in the session.
        $currentQuestionIndex = $request->session()->get('questionIndex', 1);
        $request->session()->put('questionIndex', $currentQuestionIndex + 1);

        return $this->prepareRedirect($request, $theme, $title);
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
        if (auth()->check()) {
            // Save the answer for authenticated users.
            $this->saveUserAnswer($request->user(), $theme, $question, $submittedAnswerId, $isCorrect, $attemptId);
        } else {
            // Save the answer for guests.
            $this->saveGuestAnswer($request, $question, $isCorrect);
        }
    }


    /**
     * Saves the guest user's answer in the session.
     * 
     * @param \Illuminate\Http\Request $request The current request object.
     * @param Question $question The current question object.
     * @param bool $isCorrect Indicates whether the submitted answer is correct.
     */
    private function saveGuestAnswer($request, $question, $isCorrect)
    {
        // Retrieve the guest answers from the session.
        $guestAnswers = $request->session()->get('guest_answers', []);
        // Add the current answer to the guest answers.
        $guestAnswers[] = [
            'question_id' => $question->id,
            'chosen_answer_id' => decrypt($request->input('chosen_answer_id')), // Decrypt the ID
            'is_correct' => $isCorrect
        ];
        // Save the guest answers in the session.
        $request->session()->put('guest_answers', $guestAnswers);
    }

    /**
     * Redirects the user to the next question or to the quiz completion page.
     * 
     * @param \Illuminate\Http\Request $request The current request object.
     * @param Quiz $theme The current quiz object.
     * @param string $title The title of the quiz.
     * @return \Illuminate\Http\RedirectResponse
     */
    private function prepareRedirect($request, $theme, $title)
    {
        // Redirect the user to the next question or to the quiz completion page.
        return $request->session()->get('questionIndex') <= $theme->questions->count()
            ? redirect()->route('quiz', ['title' => $title])
            : redirect()->route('quiz_completed', ['title' => $title]);
    }

    /**
     * Saves the authenticated user's answer to the database.
     * 
     * @param User $user The authenticated user object.
     * @param Quiz $theme The current quiz object.
     * @param Question $question The current question object.
     * @param int $submittedAnswerId The ID of the submitted answer.
     * @param bool $isCorrect Indicates whether the submitted answer is correct.
     * @param string $attemptId The unique ID for the quiz attempt.
     */
    private function saveUserAnswer($user, $theme, $question, $submittedAnswerId, $isCorrect, $attemptId)
    {
        // Save the answer to the database.
        UserQuestionAnswers::create([
            'user_id' => $user->id,
            'question_id' => $question->id,
            'quiz_id' => $theme->id,
            'chosen_answer_id' => $submittedAnswerId,
            'is_correct' => $isCorrect,
            'attempt_id' => $attemptId,
        ]);
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

        // Calculate the time spent on the quiz
        $timeSpend = $this->countTimeSpend();

        // Retrieve answers based on whether the user is authenticated or a guest.
        $userAnswers = auth()->check()
            ? $this->getUserAnswers($theme)
            : $this->getGuestAnswers();

        // Calculate the user's score
        $score = $this->calculateScore($userAnswers);

        // Save the quiz attempt for authenticated users.
        $this->saveQuizAttempt($theme->id, $score, $timeSpend);

        // Reset the quiz session.
        $this->resetQuizSession();

        return view('quiz_completed', compact('theme', 'userAnswers', 'score', 'timeSpend'));
    }

    /**
     * Retrieves the answers submitted by an authenticated user for a quiz.
     * 
     * @param Quiz $theme The current quiz object.
     * @return \Illuminate\Support\Collection A collection of user answers.
     */
    private function getUserAnswers($theme)
    {
        // Retrieve the attempt ID from the session.
        $attemptId = session('attempt_id');

        // Fetch answers linked to the user, quiz, and attempt ID.
        return UserQuestionAnswers::with(['answer:AnswerID,AnswerText,isCorrect', 'question:id,question'])
            ->where('user_id', auth()->id())
            ->where('quiz_id', $theme->id)
            ->where('attempt_id', $attemptId)
            ->get()
            ->map(function ($item) {
                return (object)[
                    'question' => $item->question,
                    'answer' => $item->answer,
                    'isCorrect' => $item->answer->isCorrect
                ];
            });
    }

    /**
     * Retrieves the answers submitted by a guest user for a quiz.
     * 
     * @return \Illuminate\Support\Collection A collection of guest answers.
     */
    private function getGuestAnswers()
    {
        return collect(session('guest_answers', []))->map(function ($answer) {
            return (object)[
                'question' => Question::with('answers')->find($answer['question_id']),
                'answer' => Answer::find($answer['chosen_answer_id']),
                'isCorrect' => $answer['is_correct']
            ];
        });
    }

    /**
     * Calculates the user's score for a quiz.
     * 
     * @param \Illuminate\Support\Collection $userAnswers A collection of user answers.
     * @return float The score as a percentage, rounded to 2 decimal places.
     */
    private function calculateScore($userAnswers)
    {
        // Calculate the user's score.
        $totalQuestions = $userAnswers->count();
        // Filter the correct answers and count them.
        $correctAnswers = $userAnswers->filter(fn ($answer) => $answer->isCorrect)->count();

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
        // Clear specific session keys related to the quiz.
        session()->forget(['questionIndex', 'attempt_id', 'guest_answers', 'timeStart']);
    }

    /**
     * Saves the quiz attempt data for authenticated users.
     * 
     * @param int $quizId The ID of the quiz.
     * @param float $score The score obtained in the quiz.
     * @param int $timeSpend The time spent on the quiz in seconds.
     */
    private function saveQuizAttempt($quizId, $score, $timeSpend)
    {
        // Checks if the user is authenticated.
        if (auth()->check()) {
            $attemptId = session('attempt_id');
            $userId = auth()->id();

            // Create a new quiz attempt record.
            QuizAttempt::create([
                'user_id' => $userId,
                'quiz_id' => $quizId,
                'attempt_id' => $attemptId,
                'time_spent' => $timeSpend,
                'score' => $score
            ]);
        }
    }
}
