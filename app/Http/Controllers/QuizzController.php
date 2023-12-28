<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\UserQuestionAnswers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class QuizzController extends Controller
{
    public function index($title)
    {
        $theme = Quiz::where('title', $title)->firstOrFail();

        $questions = $theme->questions()->with('answers')->get();
        $questionIndex = session('questionIndex', 1);

        if ($questionIndex >= count($questions)) {
            return $this->quiz_completed($title);
        }

        $question = $questions[$questionIndex - 1];
        return view('quizz', compact('theme', 'question'));
    }



    public function answerQuestion(Request $request, $title)
    {
        $theme = Quiz::where('title', $title)->firstOrFail();
        $questions = $theme->questions()->with('answers')->get();

        $questionIndex = $request->session()->get('questionIndex', 1);
        $question = $questions[$questionIndex - 1];

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
        $this->saveUserAnswer($request->user(), $theme, $question, $submittedAnswerId, $isCorrect, $attemptId);

        // Increment the question index for the next question
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

    public function quiz_completed($title)
    {
        $theme = Quiz::where('title', $title)->firstOrFail();
        $quiz = Quiz::where('title', $title)->firstOrFail();
        $user = auth()->user();
        $attemptId = session('attempt_id');

        $userAnswers = UserQuestionAnswers::with('answer', 'question')
            ->where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->where('attempt_id', $attemptId)
            ->get();

        // Reset the session for this quiz
        session()->forget('questionIndex');
        session()->forget('attempt_id');

        return view('quiz_completed', compact('quiz', 'theme', 'userAnswers'));
    }
}
