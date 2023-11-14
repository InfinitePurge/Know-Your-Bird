<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bird;
use App\Models\Pauksciai;

class AdminController extends Controller
{
    public function deleteBird($id)
    {
        // Perform the logic to delete the bird with the given ID
        // For example:
        Pauksciai::find($id)->delete();

        // Redirect back to the birdlist page
        return redirect('/birdlist')->with('success', 'Bird deleted successfully.');
    }
}
