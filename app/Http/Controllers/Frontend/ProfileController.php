<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function dashboard()
    {
        return view('frontend.pages.profile.dashboard');
    }

    public function favourites()
    {
        $user = Auth::user();
        $favourites = $user->favorites()->with('park')->get();
        return view('frontend.pages.profile.favourites', compact('favourites'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('frontend.pages.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return redirect()->route('profile.edit')->with(['success' => 'Profile updated successfully.', 'icon' => 'success']);
    }
    
    public function modalProfileUpdate(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        
        return redirect()->back()->with(['success' => 'Profile updated successfully.', 'icon' => 'success']);
    }
}