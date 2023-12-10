<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUs;
use App\Mail\ContactUsConfirmation;

class contact_usController extends Controller
{
    public function index()
    {
        return view('contact_us');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'subject' => 'required|min:3',
            'message' => 'required|min:15',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $subject = $request->input('subject');
        $message = $request->input('message');

        // Send email to admin
        Mail::to('knowyourbird@gmail.com')->send(new ContactUs($name, $email, $subject, $message));

        // Confirmation email to user
        Mail::to($email)->send(new ContactUsConfirmation($name));

        return redirect('/contact_us')->with('success', 'Thank you! Your message has been sent and will get back to you as soon as possible.');
    }
}