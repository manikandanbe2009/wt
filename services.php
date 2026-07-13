<?php
require_once __DIR__ . '/seo.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
  app_seo_render([
      'title' => 'Taxi Services in Chennai | Airport, Outstation and Local Cabs | White Call Taxi',
      'description' => 'Explore White Call Taxi services for Chennai airport transfers, one way outstation taxi, round trip cabs, local rides and corporate travel with fast booking support.',
      'path' => '/services.php',
      'image' => 'images/one-way-outstation-call-taxi.webp',
      'type' => 'website',
      'headline' => 'White Call Taxi services in Chennai for local, airport and outstation travel',
      'schema_type' => 'Service',
      'service_name' => 'Taxi services in Chennai',
  ]);
  ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="topbar">
    <div class="container">
      <div class="nav-shell">
        <a class="brand" href="index.php" aria-label="White Call Taxi home">
          <img class="brand-mark brand-mark-photo" src="images/logo.webp" alt="White Call Taxi logo">
          <div class="brand-copy">
            <strong>WHITE CALL TAXI</strong>
            <span>Premium Reliable Safe</span>
          </div>
        </a>

        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-nav" aria-label="Open menu">
          <span></span>
          <span></span>
          <span></span>
        </button>

        <nav class="nav-links" id="primary-nav" aria-label="Primary">
          <a href="index.php">Home</a>
          <a class="active" href="services.php">Services</a>
          <a href="fleet.php">Fleet</a>
          <a href="about.php">About Us</a>
          <a href="pricing.php">Pricing</a>
          <a href="contact.php">Contact</a>
        </nav>

        <div class="nav-cta">
          <div class="support">
            <span>
              <small>24/7 Support</small>
              <?= env_value('BUSINESS_PHONE', '+91 70090 05354') ?>
            </span>
          </div>
          <a class="button button-secondary" href="index.php#booking">Book Now <span aria-hidden="true">&rarr;</span></a>
        </div>
      </div>
    </div>
  </header>

  <main class="inner-page">
    <section class="hero" id="home">
      <div class="container">
        <div class="hero-shell">
          <div class="hero-left">
            <p class="eyebrow">Taxi Services In Chennai</p>
            <h1>Reliable <span class="accent">Taxi Service.</span><br>For every <span class="accent">travel plan.</span></h1>
            <p>White Call Taxi offers one way taxi, round trip outstation taxi, airport transfers, city cabs and business travel support across Chennai and nearby cities.</p>
            <div class="hero-benefits">
              <div class="benefit">
                <div class="icon-badge"><i class="bi bi-shield-check"></i></div>
                <div>
                  <strong>Verified Drivers</strong>
                  <span>Experienced drivers for safe local and long-distance rides.</span>
                </div>
              </div>
              <div class="benefit">
                <div class="icon-badge"><i class="bi bi-geo-alt-fill"></i></div>
                <div>
                  <strong>Wide Coverage</strong>
                  <span>Booking support for Chennai, airport routes and outstation destinations.</span>
                </div>
              </div>
              <div class="benefit">
                <div class="icon-badge"><i class="bi bi-telephone-fill"></i></div>
                <div>
                  <strong>Instant Support</strong>
                  <span>Call or WhatsApp anytime for fare details and booking help.</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section services">
      <div class="container">
        <div class="section-heading"><span>Our Premium Services</span></div>
        <div class="services-grid">
          <article class="service-card">
            <div class="service-body">
              <div class="icon-badge"><i class="bi bi-airplane-engines-fill"></i></div>
              <h3>Airport Pickup and Drop</h3>
              <p>On-time Chennai airport taxi for departure and arrival travel with clean cars and live driver coordination.</p>
            </div>
            <div class="service-image">
              <img src="images/airport-call-taxi.webp" alt="Airport taxi service" loading="lazy" decoding="async">
              <div class="service-arrow">&rarr;</div>
            </div>
          </article>

          <article class="service-card">
            <div class="service-body">
              <div class="icon-badge"><i class="bi bi-taxi-front-fill"></i></div>
              <h3>One Way Outstation Taxi</h3>
              <p>Affordable intercity taxi service for Chennai to Bangalore, Pondicherry, Trichy, Madurai and more routes.</p>
            </div>
            <div class="service-image">
              <img src="images/one-way-outstation-call-taxi.webp" alt="One way outstation taxi" loading="lazy" decoding="async">
              <div class="service-arrow">&rarr;</div>
            </div>
          </article>

          <article class="service-card">
            <div class="service-body">
              <div class="icon-badge"><i class="bi bi-arrow-repeat"></i></div>
              <h3>Round Trip Outstation Taxi</h3>
              <p>Flexible round trip cab booking for family travel, pilgrim routes, business visits and weekend plans.</p>
            </div>
            <div class="service-image">
              <img src="images/roundtrip-white-call-taxi.webp" alt="Round trip outstation taxi" loading="lazy" decoding="async">
              <div class="service-arrow">&rarr;</div>
            </div>
          </article>

          <article class="service-card">
            <div class="service-body">
              <div class="icon-badge"><i class="bi bi-buildings-fill"></i></div>
              <h3>Local City Taxi</h3>
              <p>Convenient local taxi service in Chennai for shopping, meetings, hospital visits and full-day city travel.</p>
            </div>
            <div class="service-image">
              <img src="images/city-call-taxi.webp" alt="Local city taxi service" loading="lazy" decoding="async">
              <div class="service-arrow">&rarr;</div>
            </div>
          </article>
        </div>
      </div>
    </section>

    <section class="about-intro">
      <div class="container">
        <div class="intro-grid">
          <div class="intro-image">
            <img src="images/about-us-image.webp" alt="Taxi service in Chennai" loading="lazy" decoding="async">
          </div>
          <div class="intro-content">
            <p class="section-label">SEO Content</p>
            <h2><span>Best taxi services in Chennai</span> for airport, local and outstation travel.</h2>
            <p>White Call Taxi helps customers book dependable taxi services in Chennai with easy route planning and clear fare details. If you need a Chennai airport taxi, a local cab for a few hours, or a one way outstation taxi to major Tamil Nadu and Karnataka cities, our team can support your trip with quick response and clean vehicles.</p>
            <p>Our booking support is useful for family travel, business travel, one way drop taxi booking, railway station transfers and day-return plans. Customers looking for Chennai cab services often prefer quick fare confirmation, verified drivers and flexible travel options, and that is the focus of our service page.</p>
            <div class="check-list">
              <div><i class="bi bi-check-circle-fill"></i> One way and round trip booking support</div>
              <div><i class="bi bi-check-circle-fill"></i> Sedan, SUV and premium cab options</div>
              <div><i class="bi bi-check-circle-fill"></i> Dummy office address: 24 GST Road, Guindy, Chennai 600032</div>
              <div><i class="bi bi-check-circle-fill"></i> Support Phone: +91 70090 05354</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="mission-section">
      <div class="container">
        <div class="section-heading"><span>Why Choose This Service</span></div>
        <div class="mission-grid">
          <div class="mission-card">
            <div class="icon-box"><i class="bi bi-stopwatch-fill"></i></div>
            <h3>Fast Response</h3>
            <p>Quick fare sharing for airport rides, city bookings and outstation taxi requests.</p>
          </div>
          <div class="mission-card">
            <div class="icon-box"><i class="bi bi-map-fill"></i></div>
            <h3>Route Based Booking</h3>
            <p>Footer route pages can prefill pickup and drop in the booking form and use Google location suggestions.</p>
          </div>
          <div class="mission-card">
            <div class="icon-box"><i class="bi bi-chat-dots-fill"></i></div>
            <h3>Phone and WhatsApp Help</h3>
            <p>Customers can connect through call, WhatsApp or email for trip planning and fare details.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="about-cta">
      <div class="container">
        <div class="cta-box">
          <div>
            <p class="eyebrow">Plan Your Ride</p>
            <h2>Need a taxi service quote? <span>Book from the home page.</span></h2>
            <p>Share your pickup and drop location to get an instant estimate using Google location based route distance.</p>
          </div>
          <a href="index.php#booking" class="inner-book-btn">Book Now &rarr;</a>
        </div>
      </div>
    </section>
  </main>

  <?php require __DIR__ . '/site-footer.php'; ?>

  <script>
    const menuToggle = document.querySelector(".menu-toggle");
    const primaryNav = document.getElementById("primary-nav");
    const navShell = document.querySelector(".nav-shell");

    if (menuToggle && primaryNav && navShell) {
      const navLinks = primaryNav.querySelectorAll("a");

      menuToggle.addEventListener("click", () => {
        const isOpen = menuToggle.getAttribute("aria-expanded") === "true";
        menuToggle.setAttribute("aria-expanded", String(!isOpen));
        navShell.classList.toggle("menu-open", !isOpen);
      });

      navLinks.forEach((link) => {
        link.addEventListener("click", () => {
          menuToggle.setAttribute("aria-expanded", "false");
          navShell.classList.remove("menu-open");
        });
      });
    }
  </script>
</body>
</html>
