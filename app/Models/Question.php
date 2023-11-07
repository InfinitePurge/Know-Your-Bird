<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $fillable = ['question', 'CorrectAnswerID', 'image', 'created_by', 'edited_by'];

    public function correctAnswer()
    {
        return $this->belongsTo(CorrectAnswer::class, 'CorrectAnswerID');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }

    public function wrongAnswers()
    {
        return $this->hasMany(WrongAnswer::class, 'QuestionID');
    }
}
