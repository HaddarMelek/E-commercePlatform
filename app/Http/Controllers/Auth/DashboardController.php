<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class DashboardController extends Controller
{
    public function index()
    {

        $user = auth()->user();
        if ($user->role === 'buyer') {
            return redirect()->route('buyer.index');
        } elseif ($user->role === 'seller') {
            return redirect()->route('seller.dashboard');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard'); 
        }

        return view('dashboard');


       
    }
}
