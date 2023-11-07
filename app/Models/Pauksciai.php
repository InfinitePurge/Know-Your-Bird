<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pauksciai extends Model
{
    protected $table = 'pauksciai';
    protected $fillable = ['pavadinimas', 'aprasymas', 'kilme', 'image', 'created_by', 'edited_by'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
}
