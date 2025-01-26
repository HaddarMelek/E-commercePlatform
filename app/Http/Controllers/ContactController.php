<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('welcome');
    }

    /**
     * Handle the form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(Request $request)
    {
       /* $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|regex:/^[\w\.\-]+@[\w\.\-]+\.[a-zA-Z]{2,6}$/|max:255',
            'phone' => 'nullable|digits_between:10,15',
            'message' => 'required|string',
        ]);*/
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable',
            'message' => 'required|string',
        ]);
        Contact::create($validated);

        return redirect()->back()->with('success', 'Your message has been sent!');
    }
    
    public function viewMessages()
    {
        $user = Auth::user();
        $notifications = $user->notifications;
        $contacts = Contact::all(); 
        return view('contact', compact('contacts','notifications')); 
    }
}
