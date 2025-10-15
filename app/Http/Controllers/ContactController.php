<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {

        return view('Users.Pages.Contact.contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Envoi du mail
        Mail::to('contact@infoflashsport.com')->send(new ContactMail($request->all()));

        return back()->with('success', 'Votre message a été envoyé avec succès');
    }
}
