<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pauksciai;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    public function deleteBird($id)
    {
        $bird = Pauksciai::find($id);

        if (!$bird) {
            // Handle the case where the bird is not found (optional)
            return redirect()->back()->with('error', 'Bird not found.');
        }

        Storage::disk('bird_images')->delete($bird->image);

        $bird->delete();

        return redirect()->back()->with('success', 'Bird deleted successfully.');
    }

    public function addBird(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'birdName' => 'required|string|unique:pauksciai,pavadinimas',
            'birdImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'birdContinent' => 'required|string',
            'birdMiniText' => 'required|string',
        ], [
            'birdName.unique' => 'The bird name must be unique.',
            'birdContinent.required' => 'The continent field is required.',
            'birdMiniText.required' => 'The mini text field is required.',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->to('/birdlist')
                ->withErrors($validator)
                ->withInput()
                ->with('scrollToForm', true);
        }

        $imageName = $request->birdName . '_' . time() . '.' . $request->birdImage->extension();
        $request->birdImage->storeAs('', $imageName, 'bird_images');

        $bird = new Pauksciai([
            'pavadinimas' => $request->birdName,
            'aprasymas' => $request->birdMiniText,
            'kilme' => $request->birdContinent,
            'image' => $imageName,
            'created_by' => Auth::id(),
        ]);

        $bird->save();

        $tags = $request->input('tags');
        if (!empty($tags)) {
            $bird->tags()->sync($tags);
        }

        return redirect()->back()->with('success', 'Bird added successfully.');
    }

    public function editBird(Request $request, $birdId)
    {
        $bird = Pauksciai::findOrFail($birdId);
        $tags = Tag::with('prefix')->get();

        $validator = Validator::make($request->all(), [
            'birdName' => 'required|string',
            'birdContinent' => 'required|string',
            'birdMiniText' => 'required|string',
            'birdImage' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->to('/birdlist')
                ->withErrors($validator)
                ->withInput()
                ->with('scrollToForm', true);
        }

        $birdData = [
            'pavadinimas' => $request->input('birdName'),
            'kilme' => $request->input('birdContinent'),
            'aprasymas' => $request->input('birdMiniText'),
            'edited_by' => Auth::id(),
        ];

        // Handle image upload
        if ($request->hasFile('birdImage')) {
            // Delete the existing image if it exists
            Storage::disk('bird_images')->delete($bird->image);

            // Upload the new image
            $uploadedImage = $request->file('birdImage');
            $imageName = $bird->pavadinimas . '_' . time() . '.' . $uploadedImage->extension();
            $uploadedImage->storeAs('', $imageName, 'bird_images');

            // Set the new image path in the database
            $birdData['image'] = $imageName;
        }

        // Sync tags
        $tagsInput = $request->has('tags') ? $request->input('tags') : [];
        $bird->tags()->sync($tagsInput);

        return redirect()->back()->with('success', 'Bird information updated successfully');
    }

    public function addTag(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'tagName' => 'required|string|unique:tags,name',
        ]);

        // Create a new tag
        $tag = new Tag(['name' => $validatedData['tagName']]);
        $tag->save();

        return redirect()->back()->with('success', 'Tag added successfully.');
    }
}
