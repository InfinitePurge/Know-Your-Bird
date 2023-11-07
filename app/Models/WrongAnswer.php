<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WrongAnswer extends Model
{
    protected $table = 'wrong_answers';
    protected $primaryKey = 'WrongAnswerID';
    protected $fillable = ['QuestionID', 'AnswerText'];

    public function question()
    {
        return $this->belongsTo(Question::class, 'QuestionID');
    }
}
