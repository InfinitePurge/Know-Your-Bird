<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class contact_usController extends Controller
{
    public function index()
    {
        return view('contact_us');
    }
}