<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class AdminQuizzController extends Controller
{
    public function index()
    {
        $quizThemes = Quiz::all()->map(function ($quiz) {
            $quiz->encrypted_id = Crypt::encryptString($quiz->id);
            return $quiz;
        });
        return view('addquiz', ['quizThemes' => $quizThemes]);
    }

    public function deleteTheme($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Invalid ID');
        }

        $quiz = Quiz::with('questions.answers')->findOrFail($id);

        foreach ($quiz->questions as $question) {
            $question->answers()->delete();
            $question->delete();
        }

        $quiz->delete();

        return redirect()->back()->with('success', 'Quiz and all related questions and answers deleted successfully.');
    }

    public function editThemeTitle(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'title' => 'required|string',
        ]);

        try {
            $id = Crypt::decryptString($validatedData['id']);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Invalid ID');
        }

        $quiz = Quiz::findOrFail($id);
        $quiz->title = $validatedData['title'];
        $quiz->edited_by = auth()->id();
        $quiz->save();

        return redirect()->back()->with('success', 'Quiz title updated successfully.');
    }

    public function addTheme(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255', // Validation rules
        ]);

        $quiz = new Quiz;
        $quiz->title = $validatedData['title'];
        $quiz->created_by = auth()->id(); // Assuming you're tracking who created the theme
        $quiz->save();

        return redirect()->back()->with('success', 'New theme added successfully.');
    }
}
