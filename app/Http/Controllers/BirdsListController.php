<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pauksciai;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class BirdsListController extends Controller
{
    public function index()
    {
        
        // Check if the countries data is cached
        $countries = Cache::remember('countries', 60 * 60, function () {
            // Define the API endpoint for countries
            $api_url = 'https://restcountries.com/v3.1/independent?status=true&fields=name';

            // Fetch the list of countries from the API
            $response = Http::get($api_url);
            $countries_data = $response->json();

            // Extract the names of the countries
            return array_map(function ($country) {
                return $country['name']['common'];
            }, $countries_data);
        });

        $birds = Pauksciai::all();
        $kilmeValues = Pauksciai::select('kilme')->distinct()->pluck('kilme');

        return view('birdlist', compact('birds', 'kilmeValues', 'countries'));
    }

    public function view($pavadinimas)
    {
        $bird = Pauksciai::where('pavadinimas', $pavadinimas)->first();

        if (!$bird) {
            abort(404);
        }

        $kilmeValues = Pauksciai::select('kilme')->distinct()->pluck('kilme');

        return view('bird', compact('bird', 'kilmeValues'));
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
