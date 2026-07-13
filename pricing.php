<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/seo.php';

$rates = app_rate_table();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
  app_seo_render([
      'title' => 'Taxi Price in Chennai | One Way, Round Trip and Airport Fare | White Call Taxi',
      'description' => 'Check White Call Taxi pricing for one way outstation taxi, round trip cabs, local taxi packages and airport transfers in Chennai with transparent fare details.',
      'path' => '/pricing.php',
      'image' => 'images/booking-taxi.webp',
      'type' => 'website',
      'headline' => 'Taxi price page for Chennai local, airport and outstation cab booking',
      'schema_type' => 'Service',
      'service_name' => 'Taxi pricing in Chennai',
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
          <a href="services.php">Services</a>
          <a href="fleet.php">Fleet</a>
          <a href="about.php">About Us</a>
          <a class="active" href="pricing.php">Pricing</a>
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
            <p class="eyebrow">Taxi Fare and Pricing</p>
            <h1>Transparent <span class="accent">Taxi Price.</span><br>Easy fare <span class="accent">planning.</span></h1>
            <p>View estimated taxi fare for one way outstation, round trip, airport and local Chennai cab service with dummy contact details you can update later.</p>
            <div class="hero-benefits">
              <div class="benefit">
                <div class="icon-badge"><i class="bi bi-receipt-cutoff"></i></div>
                <div>
                  <strong>Clear Rate Structure</strong>
                  <span>Base fare, per-kilometer cost and driver allowance shown clearly.</span>
                </div>
              </div>
              <div class="benefit">
                <div class="icon-badge"><i class="bi bi-cash-stack"></i></div>
                <div>
                  <strong>No Hidden Confusion</strong>
                  <span>Simple fare presentation for common airport and outstation travel needs.</span>
                </div>
              </div>
              <div class="benefit">
                <div class="icon-badge"><i class="bi bi-whatsapp"></i></div>
                <div>
                  <strong>Quick Quote Help</strong>
                  <span>Contact support for route-specific fare confirmation before booking.</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="fare-section">
      <div class="container">
        <div class="fare-header">
          <div>
            <h2>Transparent fare rates for every trip.</h2>
            <p>These are sample prices for SEO and page layout. You can change the rates, phone number and address later.</p>
          </div>
        </div>

        <div class="fare-grid">
          <div class="fare-card">
            <h5>ONE WAY DROP</h5>
            <h3>Outstation one way taxi</h3>
            <p>Best for single-side intercity travel.</p>
            <?php foreach ($rates as $vehicleCode => $rateInfo): ?>
              <div class="fare-row">
                <span><?= htmlspecialchars($rateInfo['vehicle_name'], ENT_QUOTES, 'UTF-8') ?></span>
                <strong>from Rs. <?= number_format($rateInfo['one_way_per_km'], 0) ?>/km</strong>
              </div>
            <?php endforeach; ?>
            <div class="fare-line"></div>
            <small>Minimum billing may apply based on route and city pair.</small>
            <small>Driver bata extra as applicable for selected route.</small>
          </div>

          <div class="fare-card">
            <h5>ROUND TRIP</h5>
            <h3>Outstation round trip taxi</h3>
            <p>Useful for return travel and multi-stop journeys.</p>
            <?php foreach ($rates as $vehicleCode => $rateInfo): ?>
              <div class="fare-row">
                <span><?= htmlspecialchars($rateInfo['vehicle_name'], ENT_QUOTES, 'UTF-8') ?></span>
                <strong>from Rs. <?= number_format($rateInfo['round_trip_per_km'], 0) ?>/km</strong>
              </div>
            <?php endforeach; ?>
            <div class="fare-line"></div>
            <small>Daily minimum kilometers may apply for round trips.</small>
            <small>Night halt, permit and toll charges may be extra.</small>
          </div>

          <div class="fare-card">
            <h5>LOCAL AND AIRPORT</h5>
            <h3>City ride and airport fare</h3>
            <p>Chennai local packages and airport transfer pricing.</p>
            <div class="fare-row"><span>4 hrs / 40 km</span><strong>from Rs.1,199</strong></div>
            <div class="fare-row"><span>8 hrs / 80 km</span><strong>from Rs.2,200</strong></div>
            <div class="fare-row"><span>Airport pickup / drop</span><strong>from Rs.799</strong></div>
            <div class="fare-line"></div>
            <small>Extra hour and extra kilometer charges can be added separately.</small>
            <small>Parking charges may apply on actuals.</small>
          </div>
        </div>
      </div>
    </section>

    <section class="mission-section">
      <div class="container">
        <div class="section-heading"><span>SEO Pricing Content</span></div>
        <div class="mission-grid">
          <div class="mission-card">
            <div class="icon-box"><i class="bi bi-signpost-split-fill"></i></div>
            <h3>Route Based Price</h3>
            <p>Taxi fare depends on pickup, drop, total distance, trip type and the selected cab category.</p>
          </div>
          <div class="mission-card">
            <div class="icon-box"><i class="bi bi-airplane-fill"></i></div>
            <h3>Airport Packages</h3>
            <p>Airport taxi rates are suitable for solo passengers, family bookings and corporate guest pickups.</p>
          </div>
          <div class="mission-card">
            <div class="icon-box"><i class="bi bi-telephone-outbound-fill"></i></div>
            <h3>Contact Details</h3>
            <p>Call +91 70090 05354 or visit 24 GST Road, Guindy, Chennai 600032 for bookings, queries and instant support.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="about-intro">
      <div class="container">
        <div class="intro-grid">
          <div class="intro-content">
            <p class="section-label">Fare Information</p>
            <h2><span>Taxi price in Chennai</span> with better clarity for customers.</h2>
            <p>This pricing page is useful for users searching for Chennai taxi fare, airport cab price, one way taxi rate and outstation cab tariff. It gives a quick idea about how fare is generally structured before the customer submits the trip route on the home page booking form.</p>
            <p>For exact quotation, the booking form uses pickup and drop locations with Google Places selection and distance calculation. That route-based estimate gives customers a more relevant fare than a fixed static table.</p>
          </div>
          <div class="cta-box">
            <div>
              <p class="eyebrow">Get Exact Fare</p>
              <h2>Need route-wise pricing? <span>Use the booking form.</span></h2>
              <p>Enter pickup and drop on the home page to calculate trip distance and estimate.</p>
            </div>
            <a href="index.php#booking" class="inner-book-btn">Get Estimate &rarr;</a>
          </div>
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
