<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailstoreController extends Controller
{

    public function Mail(Request $request)
    {
        // Validate email
        $validated = $request->validate([
            'email' => 'required|email'
        ]);

        $email = $validated['email'];


        // Send email
        Mail::raw("New Newsletter Subscriber: $email", function ($message) use ($email) {
            $message->from($email, 'Shah Brothers Clothing Store');
            $message->to('minimilitia1491@gmail.com') // Receiver
                ->subject('New Newsletter Subscription');
        });

        return back()->with('success', 'Thank you for subscribing!');
    }
}
