<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Decrypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Log;


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
        $quizThemes = Quiz::with('questions')->orderBy('title')->get()->map(function ($quiz) {
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

    public function addQuestion(Request $request)
    {
        $validatedData = $request->validate([
            'quiz_id' => 'required',
            'question' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s!?]+$/|unique:answers,AnswerText',
        ]);

        try {
            $quizId = Crypt::decryptString($validatedData['quiz_id']);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Invalid encrypted quiz ID');
        }

        $question = new Question;
        $question->question = $validatedData['question'];
        $question->created_by = auth()->id();
        $question->save();

        // Attach the question to the quiz
        $quiz = Quiz::find($quizId);
        $quiz->questions()->attach($question->id);

        return redirect()->back()->with('success', 'New question added successfully.');
    }

    public function addAnswer(Request $request)
    {
        $validatedData = $request->validate([
            'question_id' => 'required',
            'answer' => 'required|string|max:255',
            'isCorrect' => 'required|in:true,false'
        ]);

        try {
            $questionId = Crypt::decryptString($validatedData['question_id']);
        } catch (DecryptException $e) {
            Log::error('Invalid encrypted question ID: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Invalid encrypted question ID');
        }

        $answer = new Answer;
        $answer->QuestionID = $questionId;
        $answer->AnswerText = $validatedData['answer'];
        $answer->isCorrect = $validatedData['isCorrect'] === 'true' ? true : false;
        Log::info('Answer created: ' . $answer);
        $answer->save();

        Log::info('New answer added successfully.');

        return redirect()->back()->with('success', 'New answer added successfully.');
    }

    public function getQuestionsByTheme($themeId)
    {
        $quiz = Quiz::with('questions')->find($themeId);

        if (!$quiz) {
            return response()->json(['error' => 'Quiz not found'], 404);
        }

        // Assuming each question has a 'question' field and you need to create an encrypted ID
        $questions = $quiz->questions->map(function ($question) {
            return [
                'text' => $question->question,
                'encrypted_id' => Crypt::encryptString($question->id)
            ];
        });

        return response()->json($questions);
    }

    public function getAnswersByQuestion($encryptedQuestionId)
    {
        try {
            $questionId = Crypt::decryptString($encryptedQuestionId);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json(['error' => 'Invalid encrypted question ID'], 400);
        }
        $question = Question::with('answers')->find($questionId);

        if (!$question) {
            return response()->json(['error' => 'Question not found'], 404);
        }

        $answers = $question->answers->map(function ($answer) {
            return [
                'text' => $answer->AnswerText,
                'isCorrect' => $answer->isCorrect,
                'encrypted_id' => Crypt::encryptString($answer->id)
            ];
        });

        return response()->json($answers);
    }

    public function changeAnswerCorrectness(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'isCorrect' => 'required|in:true,false'
        ]);

        try {
            $id = Crypt::decryptString($validatedData['id']);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Invalid ID');
        }

        $answer = Answer::findOrFail($id);
        $answer->isCorrect = $validatedData['isCorrect'] === 'true' ? true : false;
        $answer->save();

        return response()->json(['success' => 'Answer updated successfully.']);
    }

    public function deleteQuestion($encryptedQuestionId)
    {
        try {
            $questionId = Crypt::decryptString($encryptedQuestionId);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json(['error' => 'Invalid encrypted question ID'], 400);
        }
        $question = Question::with('answers')->find($questionId);

        if (!$question) {
            return response()->json(['error' => 'Question not found'], 404);
        }

        $question->answers()->delete();
        $question->delete();

        return response()->json(['success' => 'Question and all related answers deleted successfully.']);
    }

    public function deleteAnswer($encryptedAnswerId)
    {
        try {
            $answerId = Crypt::decryptString($encryptedAnswerId);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json(['error' => 'Invalid encrypted answer ID'], 400);
        }
        $answer = Answer::find($answerId);

        if (!$answer) {
            return response()->json(['error' => 'Answer not found'], 404);
        }

        $answer->delete();

        return response()->json(['success' => 'Answer deleted successfully.']);
    }

    public function editQuestionTitle(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'question' => 'required|string',
        ]);

        try {
            $id = Crypt::decryptString($validatedData['id']);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Invalid ID');
        }

        $question = Question::findOrFail($id);
        $question->question = $validatedData['question'];
        $question->edited_by = auth()->id();
        $question->save();

        return response()->json(['success' => 'Question updated successfully.']);
    }

    public function editAnswerTitle(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'answer' => 'required|string',
        ]);

        try {
            $id = Crypt::decryptString($validatedData['id']);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Invalid ID');
        }

        $answer = Answer::findOrFail($id);
        $answer->AnswerText = $validatedData['answer'];
        $answer->save();

        return response()->json(['success' => 'Answer updated successfully.']);
    }
}
