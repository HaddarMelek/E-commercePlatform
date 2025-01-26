<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::all()->groupBy('role');
        $notifications = Auth::user()->unreadNotifications;
        
        return view('admin.users.index', compact('users','notifications'));
    }
   

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);
    $user->update($request->all());

    return redirect()->route('admin.users')->with('success', 'User updated successfully');
}

public function destroy($id)
{
    User::destroy($id);
    return redirect()->route('admin.users')->with('success', 'User deleted successfully');
}

}