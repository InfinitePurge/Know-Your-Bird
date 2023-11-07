<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'isAdmin',
        'isMod',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Eloquent Relationships
     */

    public function createdBirds()
    {
        return $this->hasMany(Pauksciai::class, 'created_by', 'id');
    }

    public function editedBirds()
    {
        return $this->hasMany(Pauksciai::class, 'edited_by', 'id');
    }

    public function createdQuestions()
    {
        return $this->hasMany(Question::class, 'created_by', 'id');
    }

    public function editedQuestions()
    {
        return $this->hasMany(Question::class, 'edited_by', 'id');
    }

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class, 'UserID', 'id');
    }
}
