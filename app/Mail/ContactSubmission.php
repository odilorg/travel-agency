<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSubmission extends Mailable
{
    use Queueable, SerializesModels;

    public array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function build(): self
    {
        $type = ucfirst($this->payload['type'] ?? 'Contact');
        $subject = $type;
        if (!empty($this->payload['tour_title'])) {
            $subject .= ' — '.$this->payload['tour_title'];
        }

        return $this->subject($subject)
            ->view('emails.contact-submission');
    }
}


