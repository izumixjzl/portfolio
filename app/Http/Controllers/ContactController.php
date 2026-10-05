<?php

namespace App\Http\Controllers;

use App\Mail\NewContactMessage;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // Honeypot: real visitors never see or fill the "website" field.
        if (filled($request->input('website'))) {
            return back()->with('contact_sent', true);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'subject' => ['nullable', 'string', 'max:150'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        $message = ContactMessage::create($data + ['ip_address' => $request->ip()]);

        // Email is a bonus: the message is already saved in the admin inbox.
        if ($to = config('portfolio.notify_email')) {
            try {
                Mail::to($to)->send(new NewContactMessage($message));
            } catch (\Throwable $e) {
                Log::warning('Contact notification email failed', ['error' => $e->getMessage()]);
            }
        }

        return redirect(url()->previous().'#contact')->with('contact_sent', true);
    }
}
