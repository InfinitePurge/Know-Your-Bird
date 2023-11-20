<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BirdFormsController extends Controller
{
    public function index()
    {
        return view('birdforms');
    }
}
