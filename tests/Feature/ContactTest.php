<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\SiteSetting;
use App\Models\ContactSubmission;
use App\Mail\ContactMessageMail;
use App\Mail\ContactAutoReplyMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create site settings
        SiteSetting::create([
            'site_name' => 'Travel Agency Test',
            'contact_email' => 'admin@example.com',
            'contact_send_to_email' => 'contact@example.com',
            'contact_auto_reply_enabled' => false,
        ]);
    }

    /** @test */
    public function it_displays_the_contact_page()
    {
        $response = $this->get(route('contact'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.contact');
        $response->assertViewHas('settings');
        $response->assertSee('Contact Us');
    }

    /** @test */
    public function it_submits_a_valid_contact_form()
    {
        Mail::fake();

        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'This is a test message for the travel agency.',
        ];

        $response = $this->post(route('contact.send'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Assert database has the submission
        $this->assertDatabaseHas('contact_submissions', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'This is a test message for the travel agency.',
        ]);

        // Assert email was sent
        Mail::assertSent(ContactMessageMail::class, function ($mail) {
            return $mail->hasTo('contact@example.com');
        });
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $response = $this->post(route('contact.send'), []);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
    }

    /** @test */
    public function it_validates_email_format()
    {
        $response = $this->post(route('contact.send'), [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'message' => 'Test message',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function it_validates_max_length()
    {
        $response = $this->post(route('contact.send'), [
            'name' => str_repeat('a', 101), // Over 100 chars
            'email' => 'john@example.com',
            'message' => str_repeat('a', 2001), // Over 2000 chars
        ]);

        $response->assertSessionHasErrors(['name', 'message']);
    }

    /** @test */
    public function it_blocks_spam_with_honeypot()
    {
        Mail::fake();

        $data = [
            'name' => 'Spammer',
            'email' => 'spam@example.com',
            'message' => 'This is spam',
            '_hp' => 'bot filled this', // Honeypot field should be empty
        ];

        $response = $this->post(route('contact.send'), $data);

        // Should redirect back with fake success message
        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Assert NO submission was saved
        $this->assertDatabaseMissing('contact_submissions', [
            'email' => 'spam@example.com',
        ]);

        // Assert NO email was sent
        Mail::assertNothingSent();
    }

    /** @test */
    public function it_sends_auto_reply_when_enabled()
    {
        Mail::fake();

        // Enable auto-reply
        $settings = SiteSetting::first();
        $settings->update([
            'contact_auto_reply_enabled' => true,
            'contact_auto_reply_subject' => 'Thank you for contacting us',
            'contact_auto_reply_body' => 'We received your message and will respond soon.',
        ]);

        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'message' => 'I have a question about tours.',
        ];

        $response = $this->post(route('contact.send'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Assert both emails were sent
        Mail::assertSent(ContactMessageMail::class);
        Mail::assertSent(ContactAutoReplyMail::class, function ($mail) {
            return $mail->hasTo('jane@example.com') &&
                   $mail->subject === 'Thank you for contacting us';
        });
    }

    /** @test */
    public function it_does_not_send_auto_reply_when_disabled()
    {
        Mail::fake();

        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'message' => 'I have a question about tours.',
        ];

        $response = $this->post(route('contact.send'), $data);

        $response->assertRedirect();

        // Assert only admin email was sent, not auto-reply
        Mail::assertSent(ContactMessageMail::class);
        Mail::assertNotSent(ContactAutoReplyMail::class);
    }

    /** @test */
    public function it_sends_email_with_cc_and_bcc()
    {
        Mail::fake();

        // Set CC and BCC
        $settings = SiteSetting::first();
        $settings->update([
            'contact_send_cc' => 'cc@example.com',
            'contact_send_bcc' => 'bcc@example.com',
        ]);

        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Test message',
        ];

        $response = $this->post(route('contact.send'), $data);

        $response->assertRedirect();

        Mail::assertSent(ContactMessageMail::class, function ($mail) {
            return $mail->hasTo('contact@example.com') &&
                   $mail->hasCc('cc@example.com') &&
                   $mail->hasBcc('bcc@example.com');
        });
    }

    /** @test */
    public function it_stores_metadata_with_submission()
    {
        Mail::fake();

        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Test message',
        ];

        $this->post(route('contact.send'), $data);

        $submission = ContactSubmission::latest()->first();
        
        $this->assertNotNull($submission->meta);
        $this->assertArrayHasKey('ip', $submission->meta);
        $this->assertArrayHasKey('user_agent', $submission->meta);
        $this->assertArrayHasKey('submitted_at', $submission->meta);
    }

    /** @test */
    public function it_preserves_old_input_on_validation_error()
    {
        $response = $this->post(route('contact.send'), [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'message' => 'Test message',
        ]);

        $response->assertSessionHasErrors(['email']);
        $response->assertSessionHasInput('name', 'John Doe');
        $response->assertSessionHasInput('message', 'Test message');
    }

    /** @test */
    public function it_uses_fallback_email_when_no_settings_configured()
    {
        Mail::fake();

        // Clear contact settings
        $settings = SiteSetting::first();
        $settings->update([
            'contact_send_to_email' => null,
            'contact_email' => null,
        ]);

        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Test message',
        ];

        $response = $this->post(route('contact.send'), $data);

        $response->assertRedirect();

        // Should still send to fallback email (configured in ContactController)
        Mail::assertSent(ContactMessageMail::class);
    }
}

