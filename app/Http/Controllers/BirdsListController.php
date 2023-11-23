<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pauksciai;
use Illuminate\Support\Facades\Log;

class BirdsListController extends Controller
{
    public function index()
    {
        $birds = Pauksciai::all();
        $kilmeValues = Pauksciai::select('kilme')->distinct()->pluck('kilme');
        return view('birdlist', compact('birds', 'kilmeValues'));
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

    public function search(Request $request)
    {
        $search = $request->input('search');

        $birds = Pauksciai::where('pavadinimas', 'like', '%' . $search . '%')
            ->orWhere('kilme', 'like', '%' . $search . '%')
            ->paginate(15);

        return view('birdlist', compact('birds'));
    }

    public function fetchContinents()
    {
        $continents = Pauksciai::select('kilme')->distinct()->pluck('kilme');
        return response()->json($continents);
    }
}
