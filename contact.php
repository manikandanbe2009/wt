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
      'title' => 'Contact White Call Taxi | Chennai Taxi Booking Phone Number',
      'description' => 'Contact White Call Taxi for Chennai airport taxi, one way outstation cab, local rides and fare enquiries by phone, WhatsApp or email.',
      'path' => '/contact.php',
      'image' => 'images/logo.webp',
      'type' => 'website',
      'headline' => 'Contact White Call Taxi for booking support and fare enquiries',
      'schema_type' => 'ContactPage',
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
          <a href="pricing.php">Pricing</a>
          <a class="active" href="contact.php">Contact</a>
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
            <p class="eyebrow">Contact White Call Taxi</p>
            <h1>Call, WhatsApp or <span class="accent">Email Us.</span><br>We help you <span class="accent">book faster.</span></h1>
            <p>Reach our taxi booking support for Chennai airport taxi, outstation cab booking, local cab service and route-wise fare enquiry.</p>
            <div class="hero-benefits">
              <div class="benefit">
                <div class="icon-badge"><i class="bi bi-headset"></i></div>
                <div>
                  <strong>24/7 Booking Help</strong>
                  <span>Support team available for quick ride planning and customer queries.</span>
                </div>
              </div>
              <div class="benefit">
                <div class="icon-badge"><i class="bi bi-whatsapp"></i></div>
                <div>
                  <strong>WhatsApp Friendly</strong>
                  <span>Send pickup, drop, travel date and cab preference for a quick response.</span>
                </div>
              </div>
              <div class="benefit">
                <div class="icon-badge"><i class="bi bi-pin-map-fill"></i></div>
                <div>
                  <strong>Office Location</strong>
                  <span>Dummy address added below so you can replace it with your real office details.</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="mission-section">
      <div class="container">
        <div class="section-heading"><span>Contact Details</span></div>
        <div class="mission-grid">
          <div class="mission-card">
            <div class="icon-box"><i class="bi bi-telephone-fill"></i></div>
            <h3>Phone Number</h3>
            <p><a href="tel:+917009005354">+91 70090 05354</a></p>
            <p>Call us anytime for bookings, queries and instant support.</p>
          </div>
          <div class="mission-card">
            <div class="icon-box"><i class="bi bi-envelope-fill"></i></div>
            <h3>Email Address</h3>
            <p><a href="mailto:info@whitecalltaxi.com">info@whitecalltaxi.com</a></p>
            <p>Good for booking requests, customer support and invoice-related communication.</p>
          </div>
          <div class="mission-card">
            <div class="icon-box"><i class="bi bi-geo-alt-fill"></i></div>
            <h3>Office Address</h3>
            <p>White Call Taxi<br>24 GST Road, Guindy<br>Chennai, Tamil Nadu 600032</p>
            <p>This is dummy address content you can update anytime.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="about-intro">
      <div class="container">
        <div class="intro-grid">
          <div class="intro-content">
            <p class="section-label">SEO Contact Content</p>
            <h2><span>Taxi booking contact page</span> for Chennai and outstation trips.</h2>
            <p>This contact page is useful for people searching terms like Chennai taxi phone number, airport taxi contact, one way cab booking number and local taxi enquiry. It gives customers a quick way to connect before they complete an online booking.</p>
            <p>For faster fare estimation, customers can use the home page booking form where pickup and drop can be selected using Google location suggestions. That helps generate route-based pricing for airport rides, city travel and outstation taxi routes.</p>
            <div class="check-list">
              <div><i class="bi bi-check-circle-fill"></i> Phone: +91 70090 05354</div>
              <div><i class="bi bi-check-circle-fill"></i> Dummy email: info@whitecalltaxi.com</div>
              <div><i class="bi bi-check-circle-fill"></i> Dummy address: 24 GST Road, Guindy, Chennai 600032</div>
              <div><i class="bi bi-check-circle-fill"></i> Booking form available on the home page</div>
            </div>
          </div>
          <div class="timeline-item">
            <span>01</span>
            <h4>How To Book</h4>
            <p>Call or WhatsApp us with your route details, or open the home page booking form and enter pickup and drop locations.</p>
            <span>02</span>
            <h4>Fare Confirmation</h4>
            <p>We share estimated pricing based on distance, trip type and selected cab category.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="about-cta">
      <div class="container">
        <div class="cta-box">
          <div>
            <p class="eyebrow">Start Your Booking</p>
            <h2>Need fare for pickup and drop? <span>Open the booking form now.</span></h2>
            <p>The footer route links can also open route pages that prefill pickup and drop in the booking form.</p>
          </div>
          <a href="index.php#booking" class="inner-book-btn">Open Booking Form &rarr;</a>
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
