<?php

function app_route_pages(): array
{
    return [
        'chennai-to-bangalore-taxi' => [
            'slug' => 'chennai-to-bangalore-taxi',
            'pickup' => 'Chennai',
            'drop' => 'Bangalore',
            'title' => 'Chennai to Bangalore Taxi | Book Cab ₹3,200 — White Call Taxi',
            'description' => 'Book Chennai to Bangalore taxi from ₹3,200. One-way & round trip. 346 km | 6 hrs. Verified drivers. No hidden charges',
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
        'chennai-to-trichy-taxi' => [
            'slug' => 'chennai-to-trichy-taxi',
            'pickup' => 'Chennai',
            'drop' => 'Trichy',
            'title' => 'Chennai to Trichy Taxi | Outstation Cab Booking | White Call Taxi',
            'description' => 'Book Chennai to Trichy taxi service for family travel, business trips and one way outstation rides with White Call Taxi.',
            'headline' => 'Chennai to Trichy taxi booking',
            'hero_eyebrow' => 'Popular Outstation Route',
            'hero_title' => 'Chennai to <span class="accent">Trichy</span><br>Taxi Booking.',
            'hero_description' => 'Trusted cab booking from Chennai to Trichy with reliable pickups, safe rides and clear pricing.',
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
    $routes = array_merge(
        app_route_pages(),
        app_route_chennai_pages(),
        app_route_airport_pages()
    );

    return $routes[$slug] ?? null;
}


function app_route_chennai_pages(): array
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
        'chennai-to-tirupati-taxi' => [
            'slug' => 'chennai-to-tirupati-taxi',
            'pickup' => 'Chennai',
            'drop' => 'Tirupati',
            'title' => 'Chennai to Tirupati Taxi | One Way Cab Booking | White Call Taxi',
            'description' => 'Hire Chennai to Tirupati taxi service with one way and round trip cab booking, transparent fares and verified drivers.',
            'headline' => 'Chennai to Tirupati taxi booking',
            'hero_eyebrow' => 'Popular Outstation Route',
            'hero_title' => 'Chennai to <span class="accent">Tirupati</span><br>Taxi Booking.',
            'hero_description' => 'Reliable cab service from Chennai to Tirupati for business, family and leisure travel.',
        ],
        'chennai-to-Kanyakumari-taxi' => [
            'slug' => 'chennai-to-Kanyakumari-taxi',
            'pickup' => 'Chennai',
            'drop' => 'Kanyakumari',
            'title' => 'Chennai to Kanyakumari Taxi | One Way Cab Booking | White Call Taxi',
            'description' => 'Hire Chennai to Kanyakumari taxi service with one way and round trip cab booking, transparent fares and verified drivers.',
            'headline' => 'Chennai to Kanyakumari taxi booking',
            'hero_eyebrow' => 'Popular Outstation Route',
            'hero_title' => 'Chennai to <span class="accent">Kanyakumari</span><br>Taxi Booking.',
            'hero_description' => 'Reliable cab service from Chennai to Kanyakumari for business, family and leisure travel.',
        ],
        'chennai-to-vellore-taxi' => [
            'slug' => 'chennai-to-vellore-taxi',
            'pickup' => 'Chennai',
            'drop' => 'Vellore',
            'title' => 'Chennai to Vellore Taxi | One Way Cab Booking | White Call Taxi',
            'description' => 'Hire Chennai to Vellore taxi service with one way and round trip cab booking, transparent fares and verified drivers.',
            'headline' => 'Chennai to Vellore taxi booking',
            'hero_eyebrow' => 'Frequent Travel Route',
            'hero_title' => 'Trichy to <span class="accent">Chennai</span><br>Taxi Booking.',
            'hero_description' => 'Convenient intercity cab service from Trichy to Chennai for business, airport and family travel.',
        ],
    ];
}

function app_route_chennai_page(string $slug): ?array
{
    $routes = app_route_chennai_pages();

    return $routes[$slug] ?? null;
}

 
function app_route_airport_pages(): array
{
      return [
        'chennai-airport-one-way-taxi' => [
            'slug' => 'chennai-airport-one-way-taxi',
            'pickup' => 'Chennai Airport',
            'drop' => '',
            'title' => 'Chennai Airport one Way Taxi | One Way Cab Booking | White Call Taxi',
            'description' => 'Book Chennai Airport one way taxi with White Call Taxi for one way, round trip, airport transfer and outstation travel with transparent fare and 24/7 support.',
           'headline' => 'Chennai Airport one Way Taxi booking',
            'hero_eyebrow' => 'Popular Chennai Airport Route',
            'hero_title' => 'Chennai Airport  <span class="accent"> One Way</span><br>Taxi Booking.',
            'hero_description' => 'Comfortable airport transfer service from Chennai Airport One Way Taxi with verified drivers, clean cars and fast booking support.',
        ],
         'bangalore-airport-one-way-taxi' => [
            'slug' => 'bangalore-airport-one-way-taxi',
            'pickup' => 'Bangalore Airport',
            'drop' => '',
            'title' => 'Bangalore Airport one Way Taxi | One Way Cab Booking | White Call Taxi',
            'description' => 'Book Bangalore Airport one way taxi with White Call Taxi for one way, round trip, airport transfer and outstation travel with transparent fare and 24/7 support.',
           'headline' => 'Bangalore Airport one Way Taxi booking',
            'hero_eyebrow' => 'Popular Bangalore Airport Route',
            'hero_title' => 'Bangalore Airport  <span class="accent"> One Way</span><br>Taxi Booking.',
            'hero_description' => 'Comfortable airport transfer service from Bangalore Airport One Way Taxi with verified drivers, clean cars and fast booking support.',
        ],
        'tirupati-airport-one-way-taxi' => [
            'slug' => 'tirupati-airport-one-way-taxi',
            'pickup' => 'Tirupati Airport',
            'drop' => '',
            'title' => 'Tirupati Airport one Way Taxi | One Way Cab Booking | White Call Taxi',
            'description' => 'Book Tirupati Airport one way taxi with White Call Taxi for one way, round trip, airport transfer and outstation travel with transparent fare and 24/7 support.',
           'headline' => 'Tirupati Airport one Way Taxi booking',
            'hero_eyebrow' => 'Popular Tirupati Airport Route',
            'hero_title' => 'Tirupati Airport  <span class="accent"> One Way</span><br>Taxi Booking.',
            'hero_description' => 'Comfortable airport transfer service from Tirupati Airport One Way Taxi with verified drivers, clean cars and fast booking support.',
        ],
        'hyderabad-airport-one-way-taxi' => [
            'slug' => 'hyderabad-airport-one-way-taxi',
            'pickup' => 'Hyderabad Airport',
            'drop' => '',
            'title' => 'Hyderabad Airport one Way Taxi | One Way Cab Booking | White Call Taxi',
            'description' => 'Book Hyderabad Airport one way taxi with White Call Taxi for one way, round trip, airport transfer and outstation travel with transparent fare and 24/7 support.',
           'headline' => 'Hyderabad Airport one Way Taxi booking',
            'hero_eyebrow' => 'Popular Hyderabad Airport Route',
            'hero_title' => 'Hyderabad Airport  <span class="accent"> One Way</span><br>Taxi Booking.',
            'hero_description' => 'Comfortable airport transfer service from Hyderabad Airport One Way Taxi with verified drivers, clean cars and fast booking support.',
        ],
        'coimbatore-airport-one-way-taxi' => [
            'slug' => 'coimbatore-airport-one-way-taxi',
            'pickup' => 'Coimbatore Airport',
            'drop' => '',
            'title' => 'Coimbatore Airport one Way Taxi | One Way Cab Booking | White Call Taxi',
            'description' => 'Book Coimbatore Airport one way taxi with White Call Taxi for one way, round trip, airport transfer and outstation travel with transparent fare and 24/7 support.',
           'headline' => 'Coimbatore Airport one Way Taxi booking       ',
            'hero_eyebrow' => 'Popular Coimbatore Airport Route',
            'hero_title' => 'Coimbatore Airport  <span class="accent"> One Way</span><br>Taxi Booking.',
            'hero_description' => 'Comfortable airport transfer service from Coimbatore Airport One Way Taxi with verified drivers, clean cars and fast booking support.',
        ],
        'trichy-airport-one-way-taxi' => [
            'slug' => 'trichy-airport-one-way-taxi',
            'pickup' => 'Trichy Airport',
            'drop' => '',
            'title' => 'Trichy Airport one Way Taxi | One Way Cab Booking | White Call Taxi',
            'description' => 'Book Trichy Airport one way taxi with White Call Taxi for one way, round trip, airport transfer and outstation travel with transparent fare and 24/7 support.',
           'headline' => 'Trichy Airport one Way Taxi booking       ',
            'hero_eyebrow' => 'Popular Trichy Airport Route',
            'hero_title' => 'Trichy Airport  <span class="accent"> One Way</span><br>Taxi Booking.',
            'hero_description' => 'Comfortable airport transfer service from Trichy Airport One Way Taxi with verified drivers, clean cars and fast booking support.',
        ],
        'madurai-airport-one-way-taxi' => [
            'slug' => 'madurai-airport-one-way-taxi',
            'pickup' => 'Madurai Airport',
            'drop' => '',
            'title' => 'Madurai Airport one Way Taxi | One Way Cab Booking | White Call Taxi',
            'description' => 'Book Madurai Airport one way taxi with White Call Taxi for one way, round trip, airport transfer and outstation travel with transparent fare and 24/7 support.',
           'headline' => 'Madurai Airport one Way Taxi booking       ',
            'hero_eyebrow' => 'Popular Madurai Airport Route',
            'hero_title' => 'Madurai Airport  <span class="accent"> One Way</span><br>Taxi Booking.',
            'hero_description' => 'Comfortable airport transfer service from Madurai Airport One Way Taxi with verified drivers, clean cars and fast booking support.',
        ],
        'tuticorin-airport-one-way-taxi' => [
            'slug' => 'tuticorin-airport-one-way-taxi',
            'pickup' => 'Tuticorin Airport',
            'drop' => '',
            'title' => 'Tuticorin Airport one Way Taxi | One Way Cab Booking | White Call Taxi',
            'description' => 'Book Tuticorin Airport one way taxi with White Call Taxi for one way, round trip, airport transfer and outstation travel with transparent fare and 24/7 support.',
           'headline' => 'Tuticorin Airport one Way Taxi booking       ',
            'hero_eyebrow' => 'Popular Tuticorin Airport Route',
            'hero_title' => 'Tuticorin Airport  <span class="accent"> One Way</span><br>Taxi Booking.',
            'hero_description' => 'Comfortable airport transfer service from Tuticorin Airport One Way Taxi with verified drivers, clean cars and fast booking support.',
        ]
    ];
}

function app_route_airport_page(string $slug): ?array
{
    $routes = app_route_airport_pages();

    return $routes[$slug] ?? null;
}


