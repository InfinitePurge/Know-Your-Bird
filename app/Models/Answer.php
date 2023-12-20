<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answers';
    protected $primaryKey = 'AnswerID';

    protected $fillable = ['QuestionID', 'AnswerText', 'isCorrect'];

    public function question()
    {
        return $this->belongsTo(Question::class, 'QuestionID');
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'AnswerID');
    }
}
