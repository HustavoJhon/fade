<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $adminEmail = config('mail.from.address');

        $phone = $validated['phone'] ?? 'N/A';

        if ($adminEmail) {
            Mail::raw(
                "Nombre: {$validated['name']}\n"
                . "Email: {$validated['email']}\n"
                . "Teléfono: {$phone}\n\n"
                . "Mensaje:\n{$validated['message']}",
                fn($message) => $message
                    ->to($adminEmail)
                    ->subject('Nuevo mensaje de contacto - Fade Barbershop')
                    ->replyTo($validated['email'])
            );
        }

        return back()->with('success', 'Gracias por contactarnos. Te responderemos pronto.');
    }
}
