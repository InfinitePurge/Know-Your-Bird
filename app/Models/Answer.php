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

    protected $casts = [
        'isCorrect' => 'boolean',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'QuestionID');
    }
}
