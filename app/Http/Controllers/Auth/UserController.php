<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
class UserController extends Controller
{

    public function showProfile()
    {
         $notifications = auth()->user()->notifications; 
         $categories = Category::all();
        
        return view('user.profile',compact('notifications','categories'));
    }
  
    public function updateProfile(Request $request)
{
    // Validate the input data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone_number' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = Auth::user();
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->phone_number = $request->input('phone_number');
    $user->address = $request->input('address');
    if ($request->hasFile('profile_photo')) {
        // Delete the old profile photo if it exists
        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Store the new profile photo
        $filePath = $request->file('profile_photo')->store('profile_photos', 'public');
        $user->profile_photo_path = $filePath;
    }

    $user->save();

    return redirect()->back()->with('success', 'Profile updated successfully.');
}
    
    public function deleteProfile()
    {
        $user = Auth::user();
        $user->delete();

        return redirect('/')->with('success', 'Profile deleted successfully');
    }

}
