<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Destination;
use App\Models\DestinationActivity;
use App\Models\DestinationItem;
use App\Models\Tour;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Countries
        $vietnam = Country::create([
            'name' => 'Vietnam',
            'slug' => 'vietnam',
            'iso2' => 'VN',
            'meta_title' => 'Vietnam Tours & Travel Destinations',
            'meta_description' => 'Explore the best destinations and tours in Vietnam',
        ]);

        $indonesia = Country::create([
            'name' => 'Indonesia',
            'slug' => 'indonesia',
            'iso2' => 'ID',
            'meta_title' => 'Indonesia Tours & Travel Destinations',
            'meta_description' => 'Discover amazing destinations and tours in Indonesia',
        ]);

        // Create Destinations
        $nhaTrang = Destination::create([
            'country_id' => $vietnam->id,
            'name' => 'Nha Trang',
            'slug' => 'nha-trang',
            'excerpt' => 'Coastal paradise with pristine beaches, vibrant culture, and world-class diving spots.',
            'description_html' => '<p>Nha Trang is a coastal city and capital of Khánh Hòa Province, on the South Central Coast of Vietnam. It is known for its pristine beaches, diving sites, and offshore islands. The city is a popular destination for both domestic and international tourists, offering a perfect blend of natural beauty and modern amenities.</p><p>With its warm climate year-round, Nha Trang is ideal for beach activities, water sports, and island hopping. The city also features historical sites, vibrant nightlife, and delicious seafood cuisine.</p>',
            'facts' => [
                'language' => 'Vietnamese',
                'currency' => 'Vietnamese Dong (VND)',
                'religion' => 'Buddhism, Catholicism',
                'timezone' => 'ICT (UTC+7)',
            ],
            'is_featured' => true,
            'order' => 1,
            'status' => 'published',
            'published_at' => now(),
            'best_time_html' => '<p>The best time to visit Nha Trang is from February to May when the weather is dry and pleasant with minimal rainfall.</p>',
            'weather_json' => [
                'average_temp' => '26°C - 28°C',
                'rainy_season' => 'September to December',
                'dry_season' => 'January to August',
            ],
        ]);

        $bali = Destination::create([
            'country_id' => $indonesia->id,
            'name' => 'Bali',
            'slug' => 'bali',
            'excerpt' => 'Island of the Gods offering stunning beaches, rice terraces, temples, and rich culture.',
            'description_html' => '<p>Bali is an Indonesian island known for its forested volcanic mountains, iconic rice paddies, beaches and coral reefs. The island is home to religious sites such as cliffside Uluwatu Temple. To the south, the beachside city of Kuta has lively bars, while Seminyak, Sanur and Nusa Dua are popular resort towns.</p><p>Bali is the perfect destination for surfers, yogis, culture enthusiasts, and beach lovers. The island offers a unique blend of spiritual experiences, adventure activities, and relaxation opportunities.</p>',
            'facts' => [
                'language' => 'Indonesian, Balinese',
                'currency' => 'Indonesian Rupiah (IDR)',
                'religion' => 'Hinduism (predominantly)',
                'timezone' => 'WITA (UTC+8)',
            ],
            'is_featured' => true,
            'order' => 2,
            'status' => 'published',
            'published_at' => now(),
            'best_time_html' => '<p>The best time to visit Bali is during the dry season from April to October, with July and August being the peak tourist months.</p>',
            'weather_json' => [
                'average_temp' => '27°C - 30°C',
                'rainy_season' => 'November to March',
                'dry_season' => 'April to October',
            ],
        ]);

        // Create Activities for Nha Trang
        DestinationActivity::create([
            'destination_id' => $nhaTrang->id,
            'title' => 'Summer (February - May)',
            'brief_html' => '<p>Perfect beach weather with calm seas ideal for diving and snorkeling. Island hopping tours are at their best during this season. Enjoy water sports, beach volleyball, and coastal cycling.</p>',
            'sort_order' => 1,
        ]);

        DestinationActivity::create([
            'destination_id' => $nhaTrang->id,
            'title' => 'Monsoon Season (September - December)',
            'brief_html' => '<p>While rainfall increases, this season offers unique experiences like visiting the Po Nagar Cham Towers, exploring mud baths, and enjoying indoor attractions. Great time for spa treatments and cultural tours.</p>',
            'sort_order' => 2,
        ]);

        DestinationActivity::create([
            'destination_id' => $nhaTrang->id,
            'title' => 'Year-Round Activities',
            'brief_html' => '<p>Visit the Long Son Pagoda, explore Vinpearl Land amusement park, take a cable car ride over the bay, and experience the vibrant night markets. Fresh seafood dining is available throughout the year.</p>',
            'sort_order' => 3,
        ]);

        // Create Activities for Bali
        DestinationActivity::create([
            'destination_id' => $bali->id,
            'title' => 'Dry Season (April - October)',
            'brief_html' => '<p>Perfect for beach activities, surfing, temple visits, and rice terrace exploration. Trek Mount Batur for sunrise views, enjoy yoga retreats, and explore Ubud\'s art galleries and markets.</p>',
            'sort_order' => 1,
        ]);

        DestinationActivity::create([
            'destination_id' => $bali->id,
            'title' => 'Wet Season (November - March)',
            'brief_html' => '<p>Experience lush green landscapes, fewer crowds, and better prices. Visit waterfalls, enjoy spa treatments, take cooking classes, and explore indoor cultural attractions.</p>',
            'sort_order' => 2,
        ]);

        DestinationActivity::create([
            'destination_id' => $bali->id,
            'title' => 'Year-Round Experiences',
            'brief_html' => '<p>Attend traditional dance performances, visit ancient temples like Tanah Lot and Besakih, explore local villages, participate in purification ceremonies, and enjoy world-class dining and nightlife.</p>',
            'sort_order' => 3,
        ]);

        // Create Must-Know Items for Nha Trang
        DestinationItem::create([
            'destination_id' => $nhaTrang->id,
            'title' => 'Visa Requirements',
            'body_html' => '<p>Most visitors need a visa to enter Vietnam. E-visas are available for 90-day stays. Check the latest requirements before traveling.</p>',
            'sort_order' => 1,
        ]);

        DestinationItem::create([
            'destination_id' => $nhaTrang->id,
            'title' => 'Getting Around',
            'body_html' => '<p>Taxis, motorbike rentals, and Grab (ride-hailing app) are the main transportation options. The city is relatively compact and easy to navigate.</p>',
            'sort_order' => 2,
        ]);

        DestinationItem::create([
            'destination_id' => $nhaTrang->id,
            'title' => 'Local Cuisine',
            'body_html' => '<p>Don\'t miss fresh seafood, Bánh Canh (Vietnamese udon), Nem Nướng (grilled pork rolls), and Bún Chả Cá (fish cake noodle soup).</p>',
            'sort_order' => 3,
        ]);

        // Create Must-Know Items for Bali
        DestinationItem::create([
            'destination_id' => $bali->id,
            'title' => 'Visa on Arrival',
            'body_html' => '<p>Many nationalities can get a 30-day visa on arrival. Extensions up to 60 days are possible. Always check current regulations before travel.</p>',
            'sort_order' => 1,
        ]);

        DestinationItem::create([
            'destination_id' => $bali->id,
            'title' => 'Transportation',
            'body_html' => '<p>Rent a scooter for flexibility, use Grab or Gojek apps, or hire private drivers for day trips. Traffic can be heavy in tourist areas.</p>',
            'sort_order' => 2,
        ]);

        DestinationItem::create([
            'destination_id' => $bali->id,
            'title' => 'Cultural Etiquette',
            'body_html' => '<p>Dress modestly when visiting temples, respect local customs, and be mindful during religious ceremonies. Sarongs are often required at temple entrances.</p>',
            'sort_order' => 3,
        ]);

        $this->command->info('Destinations, activities, and items seeded successfully!');
        $this->command->info('Note: Add media files manually or via Filament admin panel.');
    }
}
