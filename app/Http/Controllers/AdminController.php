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
    public function saveImages(Request $request)
    {
        $imageUrls = array();
        if ($files = $request->file('images')) {
            foreach ($files as $file) {
                $image_name = md5(rand(1000, 10000));
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $image_name . '.' . $ext;
                $upload_path = 'images/birds/'; // Relative path for storing images
                $image_url = $upload_path . $image_full_name;
                $file->move(public_path($upload_path), $image_full_name); // Moving file to the destination
                $imageUrls[] = $image_url;
            }
        }
        return implode('|', $imageUrls);
    }

    // Delete bird in Birdlist page
    public function deleteBird($id)
    {
        $bird = Pauksciai::find($id);

        if (!$bird) {
            return redirect()->back()->with('error', 'Bird not found.');
        }

        // Delete all images associated with the bird
        $images = explode('|', $bird->image);
        foreach ($images as $image) {
            // Correct the path using DIRECTORY_SEPARATOR
            $correctedImagePath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $image);
            $fullPath = public_path($correctedImagePath);

            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        $bird->delete();

        return redirect()->back()->with('success', 'Bird deleted successfully.');
    }


    // Add bird in Birdlist page
    public function addBird(Request $request)
    {
        // Validate the form data
        // Updated validation rules to handle multiple images
        $validator = Validator::make($request->all(), [
            'birdName' => 'required|string|unique:pauksciai,pavadinimas',
            'images' => 'required', // Updated to handle multiple images
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for each image
            'birdContinent' => 'required|string',
            'birdMiniText' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->to('/birdlist')
                ->withErrors($validator)
                ->withInput()
                ->with('scrollToForm', true);
        }

        // Handle multiple image upload
        $imagesString = $this->saveImages($request);

        $bird = new Pauksciai([
            'pavadinimas' => $request->birdName,
            'aprasymas' => $request->birdMiniText,
            'kilme' => $request->birdContinent,
            'image' => $imagesString,
            'created_by' => Auth::id(),
        ]);

        $bird->save();

        // Synchronize tags
        $tags = $request->input('tags');
        if (!empty($tags)) {
            $bird->tags()->sync($tags);
        }

        return redirect()->back()->with('success', 'Bird added successfully.');
    }

    // Edit bird in Birdlist page
    public function editBird(Request $request, $birdId)
    {
        try {
            $bird = Pauksciai::findOrFail($birdId);

            $validator = Validator::make($request->all(), [
                'birdName' => 'required|string|unique:pauksciai,pavadinimas,' . $bird->id,
                'birdContinent' => 'required|string',
                'birdMiniText' => 'required|string',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for each image
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

            // Handle multiple image upload
            if ($request->hasFile('images')) {
                // Delete existing images
                $existingImages = explode('|', $bird->image);
                foreach ($existingImages as $image) {
                    Storage::disk('bird_images')->delete($image);
                }

                // Upload new images
                $imagesString = $this->saveImages($request);
                $birdData['image'] = $imagesString;
            }

            // Synchronize tags
            $tagsInput = $request->input('tags', []);
            $bird->tags()->sync($tagsInput);

            // Update bird information
            $bird->update($birdData);

            return redirect()->back()->with('success', 'Bird information updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating bird information:', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'An error occurred while updating bird information');
        }
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
