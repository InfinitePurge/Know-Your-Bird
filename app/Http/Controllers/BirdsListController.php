<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pauksciai;

class BirdsListController extends Controller
{
    public function index()
    {
        $birds = Pauksciai::paginate(15);
        return view('birdlist', compact('birds'));
    }

    public function view($pavadinimas)
    {
        // For now, let's assume you have a Bird model with a `find` method
        $bird = Pauksciai::find($pavadinimas);

        $bird = Pauksciai::where('pavadinimas', $pavadinimas)->first();

        // Check if the bird is not found
        if (!$bird) {
            abort(404); // or redirect to a 404 page
        }
    
        // Pass bird data to the view
        return view('bird', compact('bird'));
    }
}
