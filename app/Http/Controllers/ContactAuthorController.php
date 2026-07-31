<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactAuthorRequest;
use App\Mail\ContactTheAuthor;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactAuthorController extends Controller
{
    public function show(): View
    {
        return view('contact-the-author');
    }

    public function submit(ContactAuthorRequest $request): RedirectResponse
    {
        /** @var string $name */
        $name = $request->name;
        /** @var string $email */
        $email = $request->email;
        /** @var string $message */
        $message = $request->message;

        $authorEmail = config('params.author-email');

        try {
            if ($authorEmail) {

                Mail::to($authorEmail)->send(new ContactTheAuthor(
                    $name,
                    $email,
                    $message
                ));

                return redirect()->route('contact-the-author')->with('success', 'Message envoyé à l\'auteur. Merci !');
            } else {
                Log::error('No admin found. No contact author email sent.');
                throw new Exception('Souci : mail non envoyé !');
            }
        } catch (Exception $ex) {
            Log::error('Message not sent to the author : '.$ex->getMessage());

            return redirect('/contact-the-author')->with('error', 'Erreur...Message non envoyé ');
        }
    }
}
