<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    
    protected $fillable = ['name'];

    public function pauksciai()
    {
        return $this->belongsToMany(Pauksciai::class, 'pauksciai_tags');
    }
}
