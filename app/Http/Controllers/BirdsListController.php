<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pauksciai;
use Illuminate\Support\Facades\Log;
use App\Countries;
use App\Models\Tag;

class BirdsListController extends Controller
{
    private function sortTags($tags)
    {
        return $tags->sort(function ($a, $b) {
            $aPrefixIsNull = is_null($a->prefix);
            $bPrefixIsNull = is_null($b->prefix);

            if ($aPrefixIsNull && $bPrefixIsNull) {
                return $a->name <=> $b->name;
            } elseif ($aPrefixIsNull || $bPrefixIsNull) {
                return $aPrefixIsNull ? 1 : -1;
            } else {
                $prefixComparison = $a->prefix->prefix <=> $b->prefix->prefix;
                return $prefixComparison == 0 ? $a->name <=> $b->name : $prefixComparison;
            }
        });
    }

    public function index()
    {
        $countries = Countries::$countries;
        sort($countries);

        $bird_card = Pauksciai::with(['tags.prefix'])->orderBy('pavadinimas', 'asc')->get();

        $birds = Pauksciai::with(['tags.prefix'])->get()->each(function ($bird) {
            $bird->tags = $this->sortTags($bird->tags);
        });

        $tags = $this->sortTags(Tag::with('prefix')->get());
        $kilmeValues = Pauksciai::select('kilme')->distinct()->pluck('kilme')->sort();

        return view('birdlist', [
            'bird_card' => $bird_card,
            'birds' => $birds,
            'kilmeValues' => $kilmeValues,
            'countries' => $countries,
            'tags' => $tags
        ]);
    }

    public function view($pavadinimas)
    {
        $bird = Pauksciai::with(['tags.prefix'])->where('pavadinimas', $pavadinimas)->firstOrFail();

        $sortedTags = $bird->tags->sort(function ($a, $b) {
            return [$a->prefix ? 0 : 1, $a->prefix->prefix ?? ''] <=> [$b->prefix ? 0 : 1, $b->prefix->prefix ?? ''];
        });

        $kilmeValues = Pauksciai::select('kilme')->distinct()->pluck('kilme')->sort();

        return view('bird', compact('bird', 'kilmeValues', 'sortedTags'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $tags = Tag::with('prefix')->get();
        $countries = Countries::$countries;

        $bird_card = Pauksciai::with(['tags.prefix'])
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($subquery) use ($search) {
                    $subquery->where('pavadinimas', 'like', '%' . $search . '%')
                        ->orWhere('kilme', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('pavadinimas', 'asc')
            ->get();

        $kilmeValues = Pauksciai::select('kilme')->distinct()->pluck('kilme')->sort();

        // Pass variables with their keys
        return view('birdlist', ['kilmeValues' => $kilmeValues, 'countries' => $countries, 'bird_card' => $bird_card, 'tags' => $tags]);
    }

    public function fetchContinents()
    {
        $continents = Pauksciai::select('kilme')->distinct()->pluck('kilme')->sort();
        return response()->json($continents);
    }
}
