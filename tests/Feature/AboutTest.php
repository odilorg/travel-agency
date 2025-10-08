<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AboutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create site settings
        SiteSetting::create([
            'site_name' => 'Travel Agency Test',
            'about_hero_title' => 'About Us',
            'about_hero_subtitle' => 'Let\'s explore what we do!',
            'about_provide_title' => 'Providing the best travel experience',
            'about_provide_text' => 'We are dedicated to making your travel dreams come true.',
            'about_vision_title' => 'Our Vision',
            'about_vision_text' => 'To be the world\'s leading travel agency.',
            'about_mission_title' => 'Our Mission',
            'about_mission_text' => 'To provide unforgettable travel experiences.',
            'about_cta_enabled' => true,
            'about_cta_title' => 'Let\'s connect',
            'about_cta_uses_contact_form' => true,
        ]);
    }

    /** @test */
    public function it_displays_the_about_page()
    {
        $response = $this->get(route('about'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.about');
        $response->assertViewHas('settings');
        $response->assertViewHas('metaData');
    }

    /** @test */
    public function it_shows_hero_content_from_settings()
    {
        $response = $this->get(route('about'));

        $response->assertSee('About Us');
        $response->assertSee('Let\'s explore what we do!');
    }

    /** @test */
    public function it_shows_vision_and_mission_cards()
    {
        $response = $this->get(route('about'));

        $response->assertSee('Our Vision');
        $response->assertSee('To be the world\'s leading travel agency');
        $response->assertSee('Our Mission');
        $response->assertSee('To provide unforgettable travel experiences');
    }

    /** @test */
    public function it_displays_team_members_when_configured()
    {
        $settings = SiteSetting::first();
        $settings->update([
            'about_team_members' => [
                [
                    'name' => 'John Doe',
                    'role' => 'CEO',
                    'photo' => 'team/john.jpg',
                ],
                [
                    'name' => 'Jane Smith',
                    'role' => 'Travel Director',
                    'photo' => 'team/jane.jpg',
                ],
            ],
        ]);

        $response = $this->get(route('about'));

        $response->assertSee('John Doe');
        $response->assertSee('CEO');
        $response->assertSee('Jane Smith');
        $response->assertSee('Travel Director');
        $response->assertSee('Meet Our Team');
    }

    /** @test */
    public function it_shows_cta_form_when_enabled()
    {
        $response = $this->get(route('about'));

        $response->assertSee('Let\'s connect');
        $response->assertSee('name="name"', false);
        $response->assertSee('name="email"', false);
        $response->assertSee('name="message"', false);
        $response->assertSee('name="source" value="about"', false);
    }

    /** @test */
    public function it_hides_cta_form_when_disabled()
    {
        $settings = SiteSetting::first();
        $settings->update(['about_cta_enabled' => false]);

        $response = $this->get(route('about'));

        $response->assertDontSee('Let\'s connect');
        $response->assertDontSee('name="source" value="about"', false);
    }

    /** @test */
    public function it_displays_contact_tiles_when_configured()
    {
        $settings = SiteSetting::first();
        $settings->update([
            'about_contact_email' => 'info@travel.com',
            'about_contact_phone' => '+1234567890',
            'about_contact_location' => '123 Travel Street, NY',
        ]);

        $response = $this->get(route('about'));

        $response->assertSee('info@travel.com');
        $response->assertSee('+1234567890');
        $response->assertSee('123 Travel Street, NY');
    }

    /** @test */
    public function it_displays_dream_features_when_configured()
    {
        $settings = SiteSetting::first();
        $settings->update([
            'about_dream_title' => 'Finding your dream destination',
            'about_dream_features' => [
                [
                    'icon' => 'solar:star-bold',
                    'title' => 'Best Prices',
                    'text' => 'We offer competitive pricing',
                ],
                [
                    'icon' => 'solar:shield-check-bold',
                    'title' => 'Safe Travel',
                    'text' => 'Your safety is our priority',
                ],
            ],
        ]);

        $response = $this->get(route('about'));

        $response->assertSee('Finding your dream destination');
        $response->assertSee('Best Prices');
        $response->assertSee('We offer competitive pricing');
        $response->assertSee('Safe Travel');
        $response->assertSee('Your safety is our priority');
    }

    /** @test */
    public function it_has_correct_meta_tags()
    {
        $response = $this->get(route('about'));

        $response->assertSee('About Us - Travel Agency Test', false);
        $response->assertSee('canonical', false);
    }

    /** @test */
    public function it_has_breadcrumb_schema()
    {
        $response = $this->get(route('about'));

        $response->assertSee('BreadcrumbList', false);
        $response->assertSee('Home', false);
        $response->assertSee('About Us', false);
    }
}

