<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ManageUsers extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy('name');

        if ($request->filled('role')) {
            $users->where('role', $request->input('role'));
        }

        if ($request->filled('email_verified')) {
            if ($request->input('email_verified') == 'verified') {
                $users->whereNotNull('email_verified_at');
            } elseif ($request->input('email_verified') == 'not_verified') {
                $users->whereNull('email_verified_at');
            }
        }

        $users = $users->paginate(10);

        return view('adminpanel', compact('users'));
    }


    public function updateRole(Request $request, $id)
    {
        $validatedData = $request->validate([
            'role' => 'required|integer|between:1,2',
        ]);

        $user = User::findOrFail($id);
        $user->role = $validatedData['role'];

        $user->save();

        return redirect()->route('adminpanel')->with('success', 'Role updated successfully');
    }

    public function updatePassword(Request $request, $id)
    {
        $validatedData = $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->password = bcrypt($validatedData['password']);
        $user->save();

        return redirect()->route('adminpanel')->with('success', 'Password updated successfully');
    }

    public function updateEmail(Request $request, $id)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|max:255|unique:users,email',
        ]);

        $user = User::findOrFail($id);
        $user->email = $validatedData['email'];
        $user->email_verified_at = null;
        $user->save();

        return redirect()->route('adminpanel')->with('success', 'Email updated successfully');
    }

    public function updateUsername(Request $request, $id)
    {
        // Validation passed, update the username
        $validatedData = $request->validate([
            'username' => 'required|min:3|max:255| unique:users,name|regex:/^[a-zA-Z0-9_]+$/',
        ]);

        $user = User::findOrFail($id);
        $user->name = $validatedData['username'];
        $user->save();

        return redirect()->route('adminpanel')->with('success', 'Username updated successfully');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/adminpanel');
    }

    public function deleteSelected(Request $request)
    {
        User::whereIn('id', $request->input('selected'))->delete();
        Log::info('deleteSelected method was called with data: ', $request->all());

        return response()->json(['success' => 'Selected users deleted successfully.']);
    }
}
