<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pauksciai;

class BirdsListController extends Controller
{
    public function index()
    {
        // Fetch all birds from the database
        $birds = Pauksciai::all();

        // Pass the data to the view
        return view('birdlist', ['birds' => $birds]);
    }
}
