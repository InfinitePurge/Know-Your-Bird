<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pauksciai;
use Illuminate\Support\Facades\Log;
use App\Countries;
use App\Models\Tag;
use App\Models\Prefix;

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

    public function index(Request $request)
    {
        $search = $request->input('search');
        $countries = Countries::$countries;
        sort($countries);

        $validatedData = $request->validate([
            'search' => ['regex:/^[a-zA-Z0-9\s]+$/', 'max:50'],
        ], [
            'search.regex' => 'The search term contains invalid characters.',
            'search.max' => 'The search term must not exceed 50 characters.',
        ]);

        $search = $validatedData['search'] ?? '';
        $searchTerms = array_filter(explode(' ', trim($search)));

        $bird_card = Pauksciai::with(['tags.prefix'])
            ->when($searchTerms, function ($query) use ($searchTerms) {
                return $query->where(function ($subquery) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $subquery->where('pavadinimas', 'like', '%' . $term . '%')
                            ->orWhere('kilme', 'like', '%' . $term . '%')
                            ->orWhereHas('tags', function ($subquery) use ($term) {
                                $subquery->where('name', 'like', '%' . $term . '%');
                            })
                            ->orWhereHas('tags.prefix', function ($subquery) use ($term) {
                                $subquery->where('prefix', 'like', '%' . $term . '%');
                            });
                    }
                });
            })
            ->orderBy('pavadinimas', 'asc')
            ->get();

        $birds = Pauksciai::with(['tags.prefix'])->get()->each(function ($bird) {
            $bird->tags = $this->sortTags($bird->tags);
        });

        $prefixes = Prefix::distinct()->orderBy('prefix')->get();
        $tagies = Tag::whereNotNull('prefix_id')->distinct()->orderBy('name')->get();
        $tagiesNull = Tag::whereNull('prefix_id')->distinct()->orderBy('name')->get();


        $tags = $this->sortTags(Tag::with('prefix')->get());
        $kilmeValues = Pauksciai::select('kilme')->distinct()->pluck('kilme')->sort();

        return view('birdlist', [
            'bird_card' => $bird_card,
            'birds' => $birds,
            'kilmeValues' => $kilmeValues,
            'countries' => $countries,
            'tags' => $tags,
            'tagies' => $tagies,
            'tagiesNull' => $tagiesNull,
            'prefixes' => $prefixes,
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

    public function fetchContinents()
    {
        $continents = Pauksciai::select('kilme')->distinct()->pluck('kilme')->sort();
        return response()->json($continents);
    }
}
