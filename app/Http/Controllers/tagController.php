<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prefix;
use App\Models\Tag;

class tagController extends Controller
{

    public function index(Request $request)
    {
        $prefix = Prefix::all();
        $tags = Tag::with('prefix')->get();
        return view('tagview', ['prefix' => $prefix, 'tags' => $tags]);
    }
}