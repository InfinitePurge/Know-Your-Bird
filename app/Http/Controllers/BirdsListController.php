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
        $bird = Pauksciai::where('pavadinimas', $pavadinimas)->first();

        // Check if the bird is not found
        if (!$bird) {
            abort(404); // or redirect to a 404 page
        }

        // Get distinct kilme values
        $kilmeValues = Pauksciai::select('kilme')->distinct()->pluck('kilme');

        // Pass bird and kilmeValues data to the view
        return view('birdlist', compact('bird', 'kilmeValues'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $birds = Pauksciai::where('pavadinimas', 'like', '%' . $search . '%')
            ->orWhere('kilme', 'like', '%' . $search . '%')
            ->paginate(15);

        $kilmeValues = Pauksciai::select('kilme')->distinct()->pluck('kilme');

        return view('birdlist', compact('birds', 'kilmeValues'));
    }

    public function fetchContinents()
    {
        $continents = Pauksciai::select('kilme')->distinct()->pluck('kilme');
        return response()->json($continents);
    }
}
