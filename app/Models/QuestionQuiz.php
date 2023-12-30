<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class QuestionQuiz extends Pivot
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'question_quiz';

    protected $fillable = ['question_id', 'quiz_id'];
}
