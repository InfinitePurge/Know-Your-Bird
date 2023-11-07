<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorrectAnswer extends Model
{
    protected $table = 'correct_answers';
    protected $primaryKey = 'CorrectAnswerID';
    protected $fillable = ['AnswerText'];

    // Define relationships as needed
    public function question()
    {
        return $this->hasOne(Question::class, 'CorrectAnswerID');
    }
}
