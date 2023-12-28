<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\UserQuestionAnswers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class QuizzController extends Controller
{
    /**
     * Display the quiz page for a specific theme.
     *
     * @param string $title The title of the quiz theme.
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse The quiz view or a redirect to the quiz completion page.
     */
    public function index($title)
    {
        $theme = Quiz::where('title', $title)->firstOrFail();

        $questions = $theme->questions()->with('answers')->get();
        $questionIndex = session('questionIndex', 1);

        if ($questionIndex >= count($questions)) {
            // If all questions have been answered, redirect to quiz completion page
            return $this->quiz_completed($title);
        }

        $question = $questions[$questionIndex - 1];
        return view('quizz', compact('theme', 'question'));
    }

    /**
     * Process the user's answer for a quiz question.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     * @param string $title The title of the quiz.
     * @return \Illuminate\Http\RedirectResponse The redirect response to the next question or the quiz completion page.
     */
    public function answerQuestion(Request $request, $title)
    {
        // Retrieve the quiz theme based on the title
        $theme = Quiz::where('title', $title)->firstOrFail();
        $questions = $theme->questions()->with('answers')->get();

        // Retrieve the current question index from the session
        $questionIndex = $request->session()->get('questionIndex', 1);
        $question = $questions[$questionIndex - 1];

        // Generate or retrieve the attempt ID for the quiz
        if ($questionIndex === 1 && !session()->has('attempt_id')) {
            $attemptId = Str::uuid()->toString();
            $request->session()->put('attempt_id', $attemptId);
        } else {
            $attemptId = $request->session()->get('attempt_id');
        }

        // Process the submitted answer
        $submittedAnswerId = (int) $request->input('chosen_answer_id');
        $correctAnswer = $question->answers->where('isCorrect', true)->first();
        $correctAnswerId = $correctAnswer ? (int) $correctAnswer->AnswerID : null;
        $isCorrect = $submittedAnswerId === $correctAnswerId;

        // Save the user's answer
        if (auth()->check()) {
            // Save the user's answer for logged in users
            $this->saveUserAnswer($request->user(), $theme, $question, $submittedAnswerId, $isCorrect, $attemptId);
        } else {
            // Store the answer in session for guest users
            $guestAnswers = $request->session()->get('guest_answers', []);
            $guestAnswers[] = [
                'question_id' => $question->id,
                'chosen_answer_id' => $submittedAnswerId,
                'is_correct' => $isCorrect
            ];
            $request->session()->put('guest_answers', $guestAnswers);
        }

        // Update the question index in the session
        $questionIndex++;
        $request->session()->put('questionIndex', $questionIndex);

        // Redirect to the next question or the quiz completion page
        if ($questionIndex <= count($questions)) {
            return redirect()->route('quiz', ['title' => $title]);
        } else {
            return redirect()->route('quiz_completed', ['title' => $title]);
        }
    }

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

    public function theme()
    {
        $quizzes = Quiz::all();
        return view('theme', compact('quizzes'));
    }

    /**
     * Handles the completion of a quiz.
     *
     * @param string $title The title of the quiz.
     * @return \Illuminate\View\View The view for the quiz completion page.
     */
    public function quiz_completed($title)
    {
        // Retrieve the theme and quiz based on the provided title
        $theme = Quiz::where('title', $title)->firstOrFail();
        $quiz = Quiz::where('title', $title)->firstOrFail();

        if (auth()->check()) {
            // If the user is authenticated, retrieve the user and attempt ID from the session
            $user = auth()->user();
            $attemptId = session('attempt_id');

            // Retrieve the user's answers for the quiz
            $userAnswers = UserQuestionAnswers::with('answer', 'question')
                ->where('user_id', $user->id)
                ->where('quiz_id', $quiz->id)
                ->where('attempt_id', $attemptId)
                ->get();
        } else {
            // If the user is a guest, retrieve the guest answers from the session
            $guestAnswers = session('guest_answers', []);

            // Transform each guest answer into a more structured format
            $userAnswers = collect($guestAnswers)->map(function ($answer) {
                // Retrieve the question ID from the answer, with a fallback to null if not set
                $questionId = $answer['question_id'] ?? null;

                // If a question ID exists, find the question and include its answers, else null
                $question = $questionId ? Question::with('answers')->find($questionId) : null;

                // Retrieve the chosen answer ID from the answer, with a fallback to null if not set
                $chosenAnswerId = $answer['chosen_answer_id'] ?? null;

                // If a question is found, find the specific chosen answer, else null
                $chosenAnswer = $question ? $question->answers->find($chosenAnswerId) : null;

                // Return a structured object containing the question, chosen answer, and correctness status
                return (object)[
                    'question' => $question,
                    'answer' => $chosenAnswer,
                    'isCorrect' => $answer['is_correct'] ?? false
                ];
            });
        }

        // Reset the session for this quiz
        session()->forget('questionIndex');
        session()->forget('attempt_id');
        session()->forget('guest_answers');

        return view('quiz_completed', compact('quiz', 'theme', 'userAnswers'));
    }
}
