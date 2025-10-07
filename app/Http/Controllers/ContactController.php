<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactSubmission;
use App\Services\TelegramNotifier;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Two sources: direct contact page, or tour booking/inquiry
        if ($request->input('inquiry_type') === 'booking') {
            $validated = $request->validate([
                'first_name' => 'required|max:60',
                'last_name' => 'required|max:60',
                'email' => 'required|email|max:150',
                'phone' => 'nullable|max:50',
                'check_in' => 'required|date|after_or_equal:today',
                'tour_title' => 'required',
                'tour_slug' => 'required',
            ]);
            $data = [
                'type' => 'booking',
                'name' => $validated['first_name'].' '.$validated['last_name'],
                'email' => $validated['email'],
                'phone' => $request->input('phone'),
                'check_in' => $validated['check_in'],
                'tour_title' => $validated['tour_title'],
                'tour_slug' => $validated['tour_slug'],
                'extras' => $request->input('extras', []),
                'pax' => $request->input('pax', []),
            ];
        } elseif ($request->input('inquiry_type') === 'inquiry') {
            $validated = $request->validate([
                'name' => 'required|max:100',
                'email' => 'required|email|max:150',
                'message' => 'nullable|max:2000',
                'tour_title' => 'required',
                'tour_slug' => 'required',
            ]);
            $data = array_merge(['type' => 'inquiry'], $validated);
        } else {
            $data = $request->validate([
                'name' => 'required|max:100',
                'email' => 'required|email|max:150',
                'phone' => 'nullable|max:50',
                'message' => 'required|max:2000',
            ]);
            $data['type'] = 'contact';
        }

        // Send email to configured recipient
        $to = config('mail.contact_to', env('CONTACT_TO', 'odilorg@gmail.com'));
        try {
            Mail::to($to)->send(new ContactSubmission($data));
        } catch (\Throwable $e) {
            \Log::error('Contact mail failed: '.$e->getMessage(), ['payload' => $data]);
        }

        // Telegram notification (optional)
        try {
            app(TelegramNotifier::class)->send($this->formatTelegram($data));
        } catch (\Throwable $e) {
            // already logged by service
        }

        return back()->with('success', 'Thank you! We received your '.($data['type'] ?? 'request').' about '.($data['tour_title'] ?? 'your inquiry').'.');
    }

    private function formatTelegram(array $data): string
    {
        $lines = [];
        $lines[] = '<b>'.strtoupper($data['type'] ?? 'CONTACT').'</b>';
        if (!empty($data['tour_title'])) {
            $lines[] = 'Tour: <b>'.$data['tour_title'].'</b>';
        }
        if (!empty($data['name'])) {
            $lines[] = 'Name: '.$data['name'];
        }
        if (!empty($data['email'])) {
            $lines[] = 'Email: '.$data['email'];
        }
        if (!empty($data['phone'])) {
            $lines[] = 'Phone: '.$data['phone'];
        }
        if (!empty($data['check_in'])) {
            $lines[] = 'Check-in: '.$data['check_in'];
        }
        if (!empty($data['message'])) {
            $lines[] = "\n".strip_tags($data['message']);
        }
        return implode("\n", $lines);
    }
}


