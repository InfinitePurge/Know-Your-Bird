<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pauksciai;
use Illuminate\Support\Facades\Log;
use App\Countries;
use App\Models\Tag;

class BirdsListController extends Controller
{
    public function index()
    {
        $countries = Countries::$countries;
        $birds = Pauksciai::all();
        $tags = Tag::with('prefix')->get();
        $kilmeValues = Pauksciai::select('kilme')->distinct()->pluck('kilme')->sort();

        // Pass variables with their keys
        return view('birdlist', ['birds' => $birds, 'kilmeValues' => $kilmeValues, 'countries' => $countries, 'tags' => $tags]);
    }

    public function view($pavadinimas)
    {
        $bird = Pauksciai::where('pavadinimas', $pavadinimas)->first();

        if (!$bird) {
            abort(404);
        }

        $kilmeValues = Pauksciai::select('kilme')->distinct()->pluck('kilme')->sort();
        
        return view('bird', compact('bird', 'kilmeValues'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $tags = Tag::with('prefix')->get();
        $countries = Countries::$countries;

        $birds = Pauksciai::where('pavadinimas', 'like', '%' . $search . '%')
            ->orWhere('kilme', 'like', '%' . $search . '%')
            ->paginate(15);

            $kilmeValues = Pauksciai::select('kilme')->distinct()->pluck('kilme')->sort();

        // Pass variables with their keys
        return view('birdlist', ['birds' => $birds, 'kilmeValues' => $kilmeValues, 'countries' => $countries, 'tags' => $tags]);
    }

    public function fetchContinents()
    {
        $continents = Pauksciai::select('kilme')->distinct()->pluck('kilme')->sort();
        return response()->json($continents);
    }
}
