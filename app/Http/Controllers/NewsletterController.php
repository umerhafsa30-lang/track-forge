<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscriber;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email',
        ], [
            'email.unique' => 'this email is already subscribed!',
        ]);

        NewsletterSubscriber::create([
            'email' => $request->email,
        ]);

        return back()->with('success', '🎉 Successfully subscribed!');
    }
}