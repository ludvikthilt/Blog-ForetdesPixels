<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    /**
     * Envoi du message de contact
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ];

        try {
            Mail::to('ludviktybho@gmail.com')->send(new ContactFormMail($details));
            return back()->with('success', 'Merci pour votre message! Nous vous répondrons bientôt.');
        } catch (\Exception $e) {
            return back()->with('error', 'Désolé, une erreur s\'est produite. Veuillez réessayer plus tard.');
        }
    }
}