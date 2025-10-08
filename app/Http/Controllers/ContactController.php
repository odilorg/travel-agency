<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactSendRequest;
use App\Mail\ContactSubmission;
use App\Mail\ContactMessageMail;
use App\Mail\ContactAutoReplyMail;
use App\Models\ContactSubmission as ContactSubmissionModel;
use App\Models\SiteSetting;
use App\Services\TelegramNotifier;

class ContactController extends Controller
{
    /**
     * Show the contact page
     */
    public function show()
    {
        $settings = SiteSetting::getInstance();
        
        return view('pages.contact', compact('settings'));
    }

    /**
     * Handle contact form submission (new)
     */
    public function send(ContactSendRequest $request)
    {
        $validated = $request->validated();
        $settings = SiteSetting::getInstance();

        // Store submission in database
        $submission = ContactSubmissionModel::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
            'meta' => [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'submitted_at' => now()->toDateTimeString(),
            ],
        ]);

        // Determine recipient email
        $recipientEmail = $settings->contact_send_to_email 
            ?? $settings->contact_email 
            ?? config('mail.contact_to', env('CONTACT_TO', 'odilorg@gmail.com'));

        // Send email to admin (queued)
        $mail = Mail::to($recipientEmail);
        
        if ($settings->contact_send_cc) {
            $mail->cc($settings->contact_send_cc);
        }
        
        if ($settings->contact_send_bcc) {
            $mail->bcc($settings->contact_send_bcc);
        }

        try {
            $mail->send(new ContactMessageMail($validated));
        } catch (\Throwable $e) {
            \Log::error('Contact message mail failed: ' . $e->getMessage(), ['data' => $validated]);
        }

        // Send auto-reply if enabled (queued)
        if ($settings->contact_auto_reply_enabled) {
            try {
                Mail::to($validated['email'])
                    ->send(new ContactAutoReplyMail(
                        $validated['name'],
                        $settings->contact_auto_reply_subject ?? __('Thank you for contacting us'),
                        $settings->contact_auto_reply_body ?? __('Thank you for reaching out to us. We have received your message and will get back to you shortly.')
                    ));
            } catch (\Throwable $e) {
                \Log::error('Contact auto-reply failed: ' . $e->getMessage(), ['email' => $validated['email']]);
            }
        }

        // Telegram notification (optional)
        try {
            app(TelegramNotifier::class)->send($this->formatTelegramContact($validated));
        } catch (\Throwable $e) {
            // Already logged by service
        }

        return back()->with('success', __('Thank you! We have received your message and will get back to you shortly.'));
    }

    /**
     * Handle legacy contact/booking/inquiry submissions (backward compatibility)
     */
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

        return back()->with('success', __('Thank you! We received your :type.', ['type' => $data['type'] ?? 'request']));
    }

    /**
     * Format data for Telegram notification (new contact form)
     */
    private function formatTelegramContact(array $data): string
    {
        $lines = [];
        $lines[] = '<b>NEW CONTACT FORM SUBMISSION</b>';
        $lines[] = '';
        $lines[] = 'Name: ' . ($data['name'] ?? 'N/A');
        $lines[] = 'Email: ' . ($data['email'] ?? 'N/A');
        $lines[] = '';
        $lines[] = 'Message:';
        $lines[] = strip_tags($data['message'] ?? 'N/A');
        
        return implode("\n", $lines);
    }

    /**
     * Format data for Telegram notification (legacy)
     */
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


