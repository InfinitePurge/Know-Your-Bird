<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class AdminQuizzController extends Controller
{
    /**
     * Display the index page of the AdminQuizzController.
     *
     * This method retrieves all the quiz themes from the database, encrypts their IDs,
     * and passes them to the 'addquiz' view for rendering.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Retrieve all quiz themes from the database sorted by title and encrypt their IDs
        $quizThemes = Quiz::orderBy('title')->get()->map(function ($quiz) {
            $quiz->encrypted_id = Crypt::encryptString($quiz->id);
            return $quiz;
        });
        return view('addquiz', ['quizThemes' => $quizThemes]);
    }

    /**
     * Delete a theme and all related questions and answers.
     *
     * @param string $encryptedId The encrypted ID of the theme to be deleted.
     * @return \Illuminate\Http\RedirectResponse Redirects back with success or error message.
     */
    public function deleteTheme($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Invalid ID');
        }

        // Retrieve the theme and all related questions and answers
        $quiz = Quiz::with('questions.answers')->findOrFail($id);

        // Delete all related questions and answers
        foreach ($quiz->questions as $question) {
            $question->answers()->delete();
            $question->delete();
        }

        $quiz->delete();

        return redirect()->back()->with('success', 'Quiz and all related questions and answers deleted successfully.');
    }

    /**
     * Update the title of a quiz theme.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Add a new theme to the quiz.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addTheme(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $quiz = new Quiz;
        $quiz->title = $validatedData['title'];
        $quiz->created_by = auth()->id();
        $quiz->save();

        return redirect()->back()->with('success', 'New theme added successfully.');
    }
}
