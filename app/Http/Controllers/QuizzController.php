<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;

class QuizzController extends Controller
{
    public function index()
    {
        return view('quizz');
    }

    public function theme()
    {
        $quizzes = Quiz::all();
        return view('theme', compact('quizzes'));
    }
}