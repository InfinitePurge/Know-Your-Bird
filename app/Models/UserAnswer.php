<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    protected $table = 'user_answers';
    protected $fillable = ['UserID', 'QuestionID', 'SelectedAnswerID', 'IsCorrect'];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'QuestionID');
    }
}
