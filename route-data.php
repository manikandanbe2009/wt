<?php

function app_route_pages(): array
{
    return [
        'chennai-to-bangalore-taxi' => [
            'slug' => 'chennai-to-bangalore-taxi',
            'pickup' => 'Chennai',
            'drop' => 'Bangalore',
            'title' => 'Chennai to Bangalore Taxi | One Way Cab Booking | White Call Taxi',
            'description' => 'Book Chennai to Bangalore taxi with White Call Taxi for one way, round trip, airport transfer and outstation travel with transparent fare and 24/7 support.',
            'headline' => 'Chennai to Bangalore taxi booking',
            'hero_eyebrow' => 'Popular Outstation Route',
            'hero_title' => 'Chennai to <span class="accent">Bangalore</span><br>Taxi Booking.',
            'hero_description' => 'Comfortable outstation cab service from Chennai to Bangalore with verified drivers, clean cars and fast booking support.',
        ],
        'chennai-to-coimbatore-taxi' => [
            'slug' => 'chennai-to-coimbatore-taxi',
            'pickup' => 'Chennai',
            'drop' => 'Coimbatore',
            'title' => 'Chennai to Coimbatore Taxi | Outstation Cab Service | White Call Taxi',
            'description' => 'Hire Chennai to Coimbatore taxi service with flexible one way and round trip cab booking, fixed pricing and safe drivers from White Call Taxi.',
            'headline' => 'Chennai to Coimbatore taxi booking',
            'hero_eyebrow' => 'Popular Outstation Route',
            'hero_title' => 'Chennai to <span class="accent">Coimbatore</span><br>Taxi Booking.',
            'hero_description' => 'Reliable outstation travel from Chennai to Coimbatore with fixed fare support and premium cab options.',
        ],
        'chennai-to-madurai-taxi' => [
            'slug' => 'chennai-to-madurai-taxi',
            'pickup' => 'Chennai',
            'drop' => 'Madurai',
            'title' => 'Chennai to Madurai Taxi | One Way Cab Service | White Call Taxi',
            'description' => 'Get Chennai to Madurai taxi booking with one way and round trip options, comfortable vehicles and transparent pricing from White Call Taxi.',
            'headline' => 'Chennai to Madurai taxi booking',
            'hero_eyebrow' => 'Popular Outstation Route',
            'hero_title' => 'Chennai to <span class="accent">Madurai</span><br>Taxi Booking.',
            'hero_description' => 'Book a safe and punctual long-distance taxi from Chennai to Madurai with 24/7 customer assistance.',
        ],
        'chennai-to-pondicherry-taxi' => [
            'slug' => 'chennai-to-pondicherry-taxi',
            'pickup' => 'Chennai',
            'drop' => 'Pondicherry',
            'title' => 'Chennai to Pondicherry Taxi | One Way Cab Booking | White Call Taxi',
            'description' => 'Choose White Call Taxi for Chennai to Pondicherry cab booking with clean cars, experienced drivers and instant fare estimates.',
            'headline' => 'Chennai to Pondicherry taxi booking',
            'hero_eyebrow' => 'Weekend Travel Route',
            'hero_title' => 'Chennai to <span class="accent">Pondicherry</span><br>Taxi Booking.',
            'hero_description' => 'Smooth city-to-coast travel from Chennai to Pondicherry with sedan, SUV and premium taxi options.',
        ],
        'chennai-to-salem-taxi' => [
            'slug' => 'chennai-to-salem-taxi',
            'pickup' => 'Chennai',
            'drop' => 'Salem',
            'title' => 'Chennai to Salem Taxi | Outstation Cab Booking | White Call Taxi',
            'description' => 'Book Chennai to Salem taxi service for family travel, business trips and one way outstation rides with White Call Taxi.',
            'headline' => 'Chennai to Salem taxi booking',
            'hero_eyebrow' => 'Popular Outstation Route',
            'hero_title' => 'Chennai to <span class="accent">Salem</span><br>Taxi Booking.',
            'hero_description' => 'Trusted cab booking from Chennai to Salem with reliable pickups, safe rides and clear pricing.',
        ],
        'coimbatore-to-chennai-taxi' => [
            'slug' => 'coimbatore-to-chennai-taxi',
            'pickup' => 'Coimbatore',
            'drop' => 'Chennai',
            'title' => 'Coimbatore to Chennai Taxi | One Way Cab Service | White Call Taxi',
            'description' => 'Reserve Coimbatore to Chennai taxi rides with one way and round trip cab options, fixed fares and 24/7 booking support.',
            'headline' => 'Coimbatore to Chennai taxi booking',
            'hero_eyebrow' => 'Popular Return Route',
            'hero_title' => 'Coimbatore to <span class="accent">Chennai</span><br>Taxi Booking.',
            'hero_description' => 'Long-distance taxi rides from Coimbatore to Chennai for airport transfer, family travel and business trips.',
        ],
        'madurai-to-chennai-taxi' => [
            'slug' => 'madurai-to-chennai-taxi',
            'pickup' => 'Madurai',
            'drop' => 'Chennai',
            'title' => 'Madurai to Chennai Taxi | Outstation Cab Booking | White Call Taxi',
            'description' => 'Book Madurai to Chennai taxi service with clean cabs, professional drivers and easy one way travel from White Call Taxi.',
            'headline' => 'Madurai to Chennai taxi booking',
            'hero_eyebrow' => 'Popular Return Route',
            'hero_title' => 'Madurai to <span class="accent">Chennai</span><br>Taxi Booking.',
            'hero_description' => 'Dependable outstation taxi service from Madurai to Chennai with instant booking assistance.',
        ],
        'trichy-to-chennai-taxi' => [
            'slug' => 'trichy-to-chennai-taxi',
            'pickup' => 'Trichy',
            'drop' => 'Chennai',
            'title' => 'Trichy to Chennai Taxi | One Way Cab Booking | White Call Taxi',
            'description' => 'Hire Trichy to Chennai taxi service with one way and round trip cab booking, transparent fares and verified drivers.',
            'headline' => 'Trichy to Chennai taxi booking',
            'hero_eyebrow' => 'Frequent Travel Route',
            'hero_title' => 'Trichy to <span class="accent">Chennai</span><br>Taxi Booking.',
            'hero_description' => 'Convenient intercity cab service from Trichy to Chennai for business, airport and family travel.',
        ],
    ];
}

function app_route_page(string $slug): ?array
{
    $routes = app_route_pages();

    return $routes[$slug] ?? null;
}

