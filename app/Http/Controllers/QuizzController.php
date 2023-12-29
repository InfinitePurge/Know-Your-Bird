<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\UserQuestionAnswers;
use Illuminate\Support\Str;
use App\Models\Answer;
use Illuminate\Support\Facades\Log;

class QuizzController extends Controller
{
    /**
     * Display the quiz page for a specific theme.
     */
    public function index($title)
    {
        $theme = Quiz::where('title', $title)->with('questions.answers')->firstOrFail();
        $questionIndex = session('questionIndex', 1);

        if ($questionIndex > $theme->questions->count()) {
            return $this->quiz_completed($title);
        }

        Log::info('Index method - Question Index: ' . $questionIndex);

        // Set the start time only if it's the first question and there's no timeStart in the session
        if ($questionIndex === 1 && !session()->has('timeStart')) {
            session(['timeStart' => now()]);
        }

        // Redirect the user to the quiz completed page if they try to access a question that doesn't exist
        if ($questionIndex > $theme->questions->count()) {
            return $this->quiz_completed($title);
        }

        return view('quizz', [
            'theme' => $theme,
            'question' => $theme->questions[$questionIndex - 1]
        ]);
    }

    /**
     * Process the user's answer for a quiz question.
     * Includes input validation and error handling.
     */
    public function answerQuestion(Request $request, $title)
    {
        $request->validate([
            'chosen_answer_id' => 'required|integer'
        ]);

        $theme = Quiz::where('title', $title)->with('questions.answers')->firstOrFail();
        $questionIndex = session('questionIndex', 1);
        $question = $theme->questions[$questionIndex - 1];

        $attemptId = $request->session()->get('attempt_id', (string) Str::uuid());
        $request->session()->put('attempt_id', $attemptId);

        try {
            $isCorrect = $this->processAnswer($request, $question);
            $this->saveAnswer($request, $theme, $question, $isCorrect, $attemptId);
        } catch (\Exception $e) {
            Log::error('Error processing answer: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Please try again.');
        }

        $currentQuestionIndex = $request->session()->get('questionIndex', 1);
        $request->session()->put('questionIndex', $currentQuestionIndex + 1);

        return $this->prepareRedirect($request, $theme, $title);
    }

    // Process the user's answer for a quiz question.
    // Includes input validation and error handling.
    private function processAnswer($request, $question)
    {
        $submittedAnswerId = (int) $request->input('chosen_answer_id');
        $correctAnswer = $question->answers->where('isCorrect', true)->first();

        return $submittedAnswerId === optional($correctAnswer)->AnswerID;
    }

    // Save the user's answer for a quiz question.
    private function saveAnswer($request, $theme, $question, $isCorrect, $attemptId)
    {
        if (auth()->check()) {
            $this->saveUserAnswer($request->user(), $theme, $question, $request->input('chosen_answer_id'), $isCorrect, $attemptId);
        } else {
            $this->saveGuestAnswer($request, $question, $isCorrect);
        }
    }

    // Save the guest's answer for a quiz question.
    private function saveGuestAnswer($request, $question, $isCorrect)
    {
        $guestAnswers = $request->session()->get('guest_answers', []);
        $guestAnswers[] = [
            'question_id' => $question->id,
            'chosen_answer_id' => (int) $request->input('chosen_answer_id'),
            'is_correct' => $isCorrect
        ];
        $request->session()->put('guest_answers', $guestAnswers);
    }

    // Prepare the redirect to the next question or the quiz completed page.
    private function prepareRedirect($request, $theme, $title)
    {
        // Redirect to the next question or the quiz completion page
        return $request->session()->get('questionIndex') <= $theme->questions->count()
            ? redirect()->route('quiz', ['title' => $title])
            : redirect()->route('quiz_completed', ['title' => $title]);
    }

    // Save the user's answer for a quiz question.
    private function saveUserAnswer($user, $theme, $question, $submittedAnswerId, $isCorrect, $attemptId)
    {
        UserQuestionAnswers::create([
            'user_id' => $user->id,
            'question_id' => $question->id,
            'quiz_id' => $theme->id,
            'chosen_answer_id' => $submittedAnswerId,
            'is_correct' => $isCorrect,
            'attempt_id' => $attemptId,
        ]);
    }

    // Display the quiz theme selection page.
    public function theme()
    {
        $quizzes = Quiz::all();
        $this->resetQuizSession();
        return view('theme', compact('quizzes'));
    }

    // Display the quiz completed page.
    public function quiz_completed($title)
    {
        $theme = Quiz::where('title', $title)->firstOrFail();

        $timeSpend = $this->countTimeSpend();

        $userAnswers = auth()->check()
            ? $this->getUserAnswers($theme)
            : $this->getGuestAnswers();

        $score = $this->calculateScore($userAnswers);

        $this->resetQuizSession();

        return view('quiz_completed', compact('theme', 'userAnswers', 'score', 'timeSpend'));
    }

    /**
     * Retrieve user answers for a quiz.
     * Fetches only necessary data for calculation.
     */
    private function getUserAnswers($theme)
    {
        $attemptId = session('attempt_id');

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
     * Retrieve guest answers for a quiz.
     * Fetches only necessary data for calculation.
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
     * Calculate the user's score for a quiz.
     * Returns a percentage rounded to 2 decimal places.
     */
    private function calculateScore($userAnswers)
    {
        $totalQuestions = $userAnswers->count();
        $correctAnswers = $userAnswers->filter(fn ($answer) => $answer->isCorrect)->count();

        return $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;
    }

    /**
     * Count the time spend on a quiz.
     * Returns the time in seconds.
     */
    private function countTimeSpend()
    {
        $timeStart = session('timeStart');
        $timeEnd = now();
        $timeSpend = $timeEnd->diffInSeconds($timeStart) + 1;
        return $timeSpend;
    }

    // Reset the quiz session.
    private function resetQuizSession()
    {
        session()->forget(['questionIndex', 'attempt_id', 'guest_answers', 'timeStart']);
    }
}
