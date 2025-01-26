<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
   
     public function index()
     {
         // Fetch unread notifications for the admin
         $notifications = Auth::user()->unreadNotifications;
 
         return view('admin.dashboard',compact('notifications'));
     }
 
     /**
      * Mark all notifications as read.
      *
      * @return \Illuminate\Http\RedirectResponse
      */
   
}
