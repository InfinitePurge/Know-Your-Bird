<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pauksciai;
use Illuminate\Support\Facades\Log;

class BirdsListController extends Controller
{
    public function index(Request $request)
    {
        $birdsQuery = Pauksciai::query();

        // Check if a continent is selected
        if ($request->has('continent')) {
            $selectedContinent = $request->input('continent');
            $birdsQuery->where('kilme', $selectedContinent);
        }

        // Log the SQL query to see what's being executed
        Log::info($birdsQuery->toSql());

        // Paginate the results
        $birds = $birdsQuery->paginate(15);

        if ($request->ajax()) {
            return view('partials.bird_cards', compact('birds'));
        }

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


    public function fetchContinents()
    {
        $continents = Pauksciai::select('kilme')->distinct()->pluck('kilme');
        return response()->json($continents);
    }
}
