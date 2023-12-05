<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prefix extends Model
{
    use HasFactory;

    protected $table = 'prefix'; // Specify the table name
    protected $fillable = ['prefix'];

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}
