<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuestionAnswers extends Model
{
    use HasFactory;

    protected $table = 'user_question_answers';

    protected $fillable = [
        'user_id',
        'question_id',
        'quiz_id',
        'chosen_answer_id',
        'attempt_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'chosen_answer_id', 'AnswerID');
    }
}
