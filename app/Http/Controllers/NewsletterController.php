<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate(['email' => 'required|email|unique:subscribers,email']);

        Subscriber::create(['email' => $request->email]);

        return back()->with('success', 'Merci pour votre abonnement !');
    }
    public function showSubscribe()
    {
        $subscribers = Subscriber::all();
        return view('Admin.Pages.subscribes.subscribe', compact('subscribers'));
    }
}
