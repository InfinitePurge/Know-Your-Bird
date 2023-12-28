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
            'search' => ['regex:/^[a-zA-Z0-9\s]+$/', 'max:100'],
        ], [
            'search.regex' => 'The search term contains invalid characters.',
            'search.max' => 'The search term must not exceed 100 characters.',
        ]);

        $search = $validatedData['search'] ?? '';
        $searchTerms = array_filter(explode(' ', trim($search)));

        $prefixFilter = $request->input('prefix');
        $tagFilter = $request->input('tag');

        // Construct the query for bird cards
        $bird_card_query = Pauksciai::with(['tags.prefix']);

        $bird_card_query->where(function ($query) use ($searchTerms, $request) {
            // Apply search terms
            if (!empty($searchTerms)) {
                $query->where(function ($subquery) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $subquery->orWhere('pavadinimas', 'like', '%' . $term . '%')
                            ->orWhere('kilme', 'like', '%' . $term . '%')
                            ->orWhereHas('tags', function ($subquery) use ($term) {
                                $subquery->where('name', 'like', '%' . $term . '%');
                            })
                            ->orWhereHas('tags.prefix', function ($subquery) use ($term) {
                                $subquery->where('prefix', 'like', '%' . $term . '%');
                            });
                    }
                });
            }

            // Apply filters
            if ($request->filled('countries')) {
                $countryValues = explode(',', $request->input('countries'));
                $query->whereIn('kilme', $countryValues);
            }

            if ($request->filled('prefixes')) {
                $prefixValues = explode(',', $request->input('prefixes'));
                $query->whereHas('tags.prefix', function ($subquery) use ($prefixValues) {
                    $subquery->whereIn('prefix', $prefixValues);
                });
            }

            if ($request->filled('tags')) {
                $tagValues = explode(',', $request->input('tags'));
                $query->whereHas('tags', function ($subquery) use ($tagValues) {
                    $subquery->whereIn('name', $tagValues);
                });
            }

            if ($request->filled('tagNulls')) {
                $tagNullValues = explode(',', $request->input('tagNulls'));
                $query->whereHas('tags', function ($subquery) use ($tagNullValues) {
                    $subquery->whereIn('name', $tagNullValues)->whereNull('prefix_id');
                });
            }
        });

        $bird_card = $bird_card_query->orderBy('pavadinimas', 'asc')->paginate(15);

        // Get prefixes that are used by at least one bird
        $usedPrefixes = Prefix::whereHas('tags', function ($query) {
            $query->whereHas('pauksciai', function ($subquery) {
                $subquery->where('pauksciai.id', '>', 0);
            });
        })->distinct()->get();

        $usedTagsWithPrefix = Tag::whereNotNull('prefix_id')
            ->whereHas('pauksciai', function ($query) {
                $query->where('pauksciai.id', '>', 0);
            })->get();

        $usedTagsWithNullPrefix = Tag::whereNull('prefix_id')
            ->whereHas('pauksciai', function ($query) {
                $query->where('pauksciai.id', '>', 0);
            })->get();

        $countriesWithBirds = Pauksciai::select('kilme')->distinct()->pluck('kilme')->filter()->sort();

        // Other data for the view
        $birds = Pauksciai::with(['tags.prefix'])->get()->each(function ($bird) {
            $bird->tags = $this->sortTags($bird->tags);
        });

        $tags = $this->sortTags(Tag::with('prefix')->get());
        $kilmeValues = Pauksciai::select('kilme')->distinct()->pluck('kilme')->sort();

        return view('birdlist', [
            'bird_card' => $bird_card,
            'birds' => $birds,
            'kilmeValues' => $kilmeValues,
            'usedPrefixes' => $usedPrefixes,
            'countries' => $countries,
            'countriesWithBirds' => $countriesWithBirds,
            'usedTagsWithPrefix' => $usedTagsWithPrefix,
            'usedTagsWithNullPrefix' => $usedTagsWithNullPrefix,
            'tags' => $tags,
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
