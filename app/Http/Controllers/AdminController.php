<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bird;
use App\Models\Pauksciai;

class AdminController extends Controller
{
    //delete bird
    public function deleteBird($id)
    {
        Pauksciai::find($id)->delete();

        return redirect('/birdlist')->with('success', 'Bird deleted successfully.');
    }

    //add bird
    public function addBird(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'birdName' => 'required|string|max:255',
            'birdImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'birdContinent' => 'required|string|max:255',
            'birdMiniText' => 'required|string',
        ]);

        // Handle the file upload
        $imagePath = $request->file('birdImage')->storeAs('images/birds', $validatedData['birdName'] . '.' . $request->file('birdImage')->getClientOriginalExtension(), 'public');

        // Create a new bird record
        Pauksciai::create([
            'pavadinimas' => $validatedData['birdName'],
            'aprasymas' => $validatedData['birdMiniText'],
            'kilme' => $validatedData['birdContinent'],
            'image' => $imagePath,
            'created_by' => auth()->id(),
        ]);

        // Redirect back to the birdlist page
        return redirect('/birdlist')->with('success', 'Bird added successfully.');
    }
}
