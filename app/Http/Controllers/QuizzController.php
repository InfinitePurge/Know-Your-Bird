<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;

class QuizzController extends Controller
{
    public function index($title)
    {
        $theme = Quiz::where('title', $title)->firstOrFail();
        $questions = $theme->questions()->with('answers')->get();

        $questionIndex = session('questionIndex', 0);

        if ($questionIndex >= count($questions)) {
            return view('quiz_completed', compact('theme'));
        }

        $question = $questions[$questionIndex];
        return view('quizz', compact('theme', 'question'));
    }

    public function answerQuestion(Request $request, $title)
    {
        $theme = Quiz::where('title', $title)->firstOrFail();
        $questions = $theme->questions()->with('answers')->get();

        $questionIndex = $request->session()->get('questionIndex', 0);

        if ($questionIndex >= count($questions)) {
            return view('quiz_completed', compact('theme'));
        }

        $question = $questions[$questionIndex];

        $submittedAnswerId = $request->input('answer_id');
        $correctAnswer = optional($question->correctAnswer);
        $correctAnswerId = $correctAnswer->id ?? null;

        $isCorrect = ($submittedAnswerId == $correctAnswerId);

        $questionIndex++;
        $request->session()->put('questionIndex', $questionIndex);

        return view('quizz', compact('theme', 'question', 'isCorrect'));
    }

    public function resetTheme(Request $request, $title)
    {
        $theme = Quiz::where('title', $title)->firstOrFail();

        $request->session()->forget('questionIndex');

        return redirect()->route('theme', ['title' => $theme->title]);
    }

    public function theme()
    {
        $quizzes = Quiz::all();
        return view('theme', compact('quizzes'));
    }
}