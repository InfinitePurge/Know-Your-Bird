<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'quiz_id', 'attempt_id', 'time_spend', 'score', 'answers'
    ];

    protected $casts = [
        'answers' => 'array',
    ];
}
