<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pauksciai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function deleteBird($id)
    {
        // Find the bird with the given ID
        $bird = Pauksciai::find($id);

        if (!$bird) {
            // Handle the case where the bird is not found (optional)
            return redirect()->back()->with('error', 'Bird not found.');
        }

        // Delete the associated image from storage
        Storage::disk('bird_images')->delete($bird->image);

        // Delete the bird from the database
        $bird->delete();

        // Redirect back to the previous page
        return redirect()->back()->with('success', 'Bird deleted successfully.');
    }

    public function addBird(Request $request)
    {
        // Validate the form data
        $request->validate([
            'birdName' => 'required|string',
            'birdImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'birdContinent' => 'required|string',
            'birdMiniText' => 'required|string',
        ]);

        // Store the uploaded image with a unique name using the 'bird_images' disk
        $imageName = $request->birdName . '_' . time() . '.' . $request->birdImage->extension();
        $request->birdImage->storeAs('', $imageName, 'bird_images');

        // Create a new bird instance
        $bird = new Pauksciai([
            'pavadinimas' => $request->birdName,
            'aprasymas' => $request->birdMiniText,
            'kilme' => $request->birdContinent,
            'image' => $imageName,
            'created_by' => Auth::id(),
        ]);

        // Save the bird to the database
        $bird->save();

        // Redirect back to the previous page
        return redirect()->back()->with('success', 'Bird added successfully.');
    }
}
