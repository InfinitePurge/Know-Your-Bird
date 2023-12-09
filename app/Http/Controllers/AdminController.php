<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pauksciai;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Prefix;
use Illuminate\Support\Facades\Log;


class AdminController extends Controller
{
    // Delete bird in Birdlist page
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

    // Add bird in Birdlist page
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

    // Edit bird in Birdlist page
    public function editBird(Request $request, $birdId)
    {
        $bird = Pauksciai::findOrFail($birdId);
        $tags = Tag::with('prefix')->get();

        $validator = Validator::make($request->all(), [
            'birdName' => 'required|unique:pauksciai,pavadinimas|string',
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

        $bird->update($birdData);
        $bird->save();
        
        $tagsInput = $request->has('tags') ? $request->input('tags') : [];
        $bird->tags()->sync($tagsInput);


        return redirect()->back()->with('success', 'Bird information updated successfully');
    }

    // Add tag in Tagview page
    public function addTag(Request $request)
    {
        $validatedData = $request->validate([
            'tagName' => 'required|string|unique:tags,name',
        ]);

        $tag = new Tag(['name' => $validatedData['tagName']]);
        $tag->save();

        return redirect()->back()->with('success', 'Tag added successfully.');
    }

    public function addTagWithPrefix(Request $request)
    {
        $validatedData = $request->validate([
            'tagName' => 'required|string|unique:tags,name',
            'prefixId' => 'required|exists:prefix,id'
        ]);

        $tag = new Tag(['name' => $validatedData['tagName'], 'prefix_id' => $validatedData['prefixId']]);
        $tag->save();

        return redirect()->back()->with('success', 'Tag added successfully.');
    }

    // Add prefix with tag in Tagview page
    public function addPrefix(Request $request)
    {
        $validatedData = $request->validate([
            'prefixName' => 'required|string|unique:prefix,prefix',
        ]);

        $prefix = new Prefix(['prefix' => $validatedData['prefixName']]);
        $prefix->save();

        return redirect()->back()->with('success', 'Prefix added successfully.');
    }

    // Delete tag in Tagview page
    public function deleteTag($id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return redirect()->back()->with('error', 'Tag not found.');
        }

        $tag->delete();

        return redirect()->back()->with('success', 'Tag deleted successfully.');
    }

    // Delete prefix with tag in Tagview page
    public function deletePrefix($id)
    {
        $prefix = Prefix::find($id);

        if (!$prefix) {
            return redirect()->back()->with('error', 'Prefix not found.');
        }

        $prefix->delete();

        return redirect()->back()->with('success', 'Prefix deleted successfully.');
    }

    public function updatePrefix(Request $request, $id)
    {
        // Validate the request data as needed
        $request->validate([
            'editPrefixName' => 'required|max:30',
        ]);

        // Find the prefix by ID
        $prefix = Prefix::find($id);

        // Update the prefix name
        $prefix->prefix = $request->input('editPrefixName');
        $prefix->save();
        return redirect()->back()->with('success', 'Prefix updated successfully');
    }

    public function updateTagAndPrefix(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'editPrefixId' => 'nullable|exists:prefix,id',
        ]);

        $tag = Tag::findOrFail($id);
        $tag->name = $request->name;
        $tag->prefix_id = $request->prefix_id;
        $tag->save();

        return redirect()->back()->with('success', 'Tag updated successfully.');
    }
}
