<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    
    protected $table = 'tags';
    protected $fillable = ['name'];

    public function pauksciai()
    {
        return $this->belongsToMany(Pauksciai::class, 'pauksciai_tags');
    }

    public function prefix()
    {
        return $this->belongsTo(Prefix::class);
    }
}
