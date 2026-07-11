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
      'title' => 'Taxi Fleet | Sedan, SUV and Premium Cabs | White Call Taxi',
      'description' => 'Explore the White Call Taxi fleet with sedan, SUV and premium cars for airport pickup, local travel, outstation rides and corporate bookings.',
      'path' => '/fleet.php',
      'image' => 'images/premium-fleet.png',
      'type' => 'website',
      'headline' => 'Sedan, SUV and premium taxi fleet options',
      'schema_type' => 'CollectionPage',
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
        <a class="brand" href="#home" aria-label="White Call Taxi home">
          <img class="brand-mark brand-mark-photo" src="images/logo.png" alt="White Call Taxi logo">
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
          <a  class="active" href="fleet.php">Fleet</a>
          <a  href="about.php">About Us</a>
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
            <p class="eyebrow">Our Premium Fleet</p>
            <h1>Perfect <span class="accent">Cab.</span><br>for every<span class="accent"> Trip.</span></h1>
            <p> Sedan, SUV and premium cars available for airport, city,
              outstation and corporate travel.</p>
            <div class="hero-benefits">
              <div class="benefit">
                <div class="icon-badge"><i class="bi bi-shield-check"></i></div>
                <div>
                  <strong>Safe &amp; Secure</strong>
                  <span>Your safety is our top priority on every route.</span>
                </div>
              </div>
              <div class="benefit">
                <div class="icon-badge"><i class="bi bi-person-check"></i></div>
                <div>
                  <strong>Verified Drivers</strong>
                  <span>Professional and background-checked.</span>
                </div>
              </div>
              <div class="benefit">
                <div class="icon-badge"><i class="bi bi-tags"></i></div>
                <div>
                  <strong>Transparent Pricing</strong>
                  <span>No hidden charges. What you see is what you pay.</span>
                </div>
              </div>
            </div>

         
          </div>

          
      </div>
    </section>

  
   

      

      <section class="fleet-section">
        <div class="container">
          <div class="fleet-filter">
            <button class="filter-btn active" data-filter="all">
              All Cars
            </button>
            <button class="filter-btn" data-filter="sedan">Sedan</button>
            <button class="filter-btn" data-filter="suv">SUV</button>
            <button class="filter-btn" data-filter="premium">Premium</button>
          </div>

          <div class="fleet-grid">
            <article class="fleet-card" data-category="sedan">
              <div class="fleet-img">
                <img src="images/sedan-etios-fleet.png" alt="Executive Sedan" loading="lazy" decoding="async" />
              </div>
              <div class="fleet-body">
                <span class="fleet-tag">Sedan</span>
                <h3>Executive Sedan</h3>
                <p>
                  Perfect for city rides, airport transfers and business travel.
                </p>

                <div class="fleet-info">
                  <span><i class="bi bi-people"></i> 4 Seats</span>
                  <span><i class="bi bi-bag"></i> 2 Bags</span>
                  <span><i class="bi bi-snow"></i> AC</span>
                </div>

                <a href="index.php#booking" class="fleet-btn"
                  >Book This Cab →</a
                >
              </div>
            </article>

            <article class="fleet-card" data-category="sedan">
              <div class="fleet-img">
                <img src="images/swift-dzire-fleet.png" alt="Swift Dzire" loading="lazy" decoding="async" />
              </div>
              <div class="fleet-body">
                <span class="fleet-tag">Sedan</span>
                <h3>Swift Dzire</h3>
                <p>
                  Comfortable and economical option for local and outstation
                  trips.
                </p>

                <div class="fleet-info">
                  <span><i class="bi bi-people"></i> 4 Seats</span>
                  <span><i class="bi bi-bag"></i> 2 Bags</span>
                  <span><i class="bi bi-snow"></i> AC</span>
                </div>

                <a href="index.php#booking" class="fleet-btn">Book This Cab →</a>
              </div>
            </article>

            <article class="fleet-card" data-category="suv">
              <div class="fleet-img">
                <img src="images/suv-ertiga-fleet.png" alt="Ertiga SUV" loading="lazy" decoding="async" />
              </div>
              <div class="fleet-body">
                <span class="fleet-tag">SUV</span>
                <h3>Ertiga SUV</h3>
                <p>
                  Spacious choice for family trips, group travel and airport
                  rides.
                </p>

                <div class="fleet-info">
                  <span><i class="bi bi-people"></i> 6 Seats</span>
                  <span><i class="bi bi-bag"></i> 3 Bags</span>
                  <span><i class="bi bi-snow"></i> AC</span>
                </div>

                <a href="index.php#booking" class="fleet-btn">Book This Cab →</a>
              </div>
            </article>

            <article class="fleet-card" data-category="suv">
              <div class="fleet-img">
                <img
                  src="images/SUV-innova-crysta-car.png"
                  alt="Innova Crysta"
                  loading="lazy"
                  decoding="async"
                />
              </div>
              <div class="fleet-body">
                <span class="fleet-tag">SUV</span>
                <h3>Innova Crysta</h3>
                <p>
                  Premium comfort for long-distance travel and corporate
                  bookings.
                </p>

                <div class="fleet-info">
                  <span><i class="bi bi-people"></i> 7 Seats</span>
                  <span><i class="bi bi-bag"></i> 4 Bags</span>
                  <span><i class="bi bi-snow"></i> AC</span>
                </div>

                <a href="index.php#booking" class="fleet-btn">Book This Cab →</a>
              </div>
            </article>

            <article class="fleet-card" data-category="premium">
              <div class="fleet-img">
                <img src="images/premium-fleet.png" alt="Premium Car" loading="lazy" decoding="async" />
              </div>
              <div class="fleet-body">
                <span class="fleet-tag">Premium</span>
                <h3>Business Class</h3>
                <p>
                  Luxury travel experience for VIP, executive and special
                  occasions.
                </p>

                <div class="fleet-info">
                  <span><i class="bi bi-people"></i> 4 Seats</span>
                  <span><i class="bi bi-stars"></i> Premium</span>
                  <span><i class="bi bi-snow"></i> AC</span>
                </div>

                <a href="index.php#booking" class="fleet-btn">Book This Cab →</a>
              </div>
            </article>

            <article class="fleet-card" data-category="premium">
              <div class="fleet-img">
                <img src="images/corporate-taxi.png" alt="Corporate Travel" loading="lazy" decoding="async" />
              </div>
              <div class="fleet-body">
                <span class="fleet-tag">Premium</span>
                <h3>Corporate Travel</h3>
                <p>
                  Professional travel support for meetings, events and office
                  pickups.
                </p>

                <div class="fleet-info">
                  <span><i class="bi bi-briefcase"></i> Business</span>
                  <span><i class="bi bi-clock"></i> On Time</span>
                  <span><i class="bi bi-shield-check"></i> Safe</span>
                </div>

                <a href="index.php#booking" class="fleet-btn">Book This Cab →</a>
              </div>
            </article>
          </div>
        </div>
      </section>

      <section class="fleet-cta">
        <div class="container">
          <div class="cta-box">
            <div>
              <p class="eyebrow">Need help choosing?</p>
              <h2>
                Tell us your route. <span>We’ll suggest the best cab.</span>
              </h2>
            </div>
            <a href="index.php" class="inner-book-btn">Get Estimation →</a>
          </div>
        </div>
      </section>


    <section class="section" id="app">
      <div class="container">
        <div class="app-card glass">
          <div class="phones">
            <img src="images/booking-taxi.png" class="img-fluid" alt="Online taxi booking illustration" loading="lazy" decoding="async" >
          </div>

          <div class="app-copy">
            <p class="eyebrow">Easy To Book</p>
            <h2><span class="accent">Simple, Transparent</span><br>Booking Experience.</h2>
            <p>No apps, no confusion. Just tell us where you're going and we handle the rest.</p>
            <!-- <div class="store-row">
              <a class="store-badge" href="#"><span>GP</span>Google Play</a>
              <a class="store-badge" href="#"><span>AS</span>App Store</a>
            </div> -->
          </div>

          <div class="app-points">
            <div class="point">
              <div class="square-icon"><i class="bi bi-geo-fill"></i></div>
              <div>
                <strong>Share Your Route</strong>
                <span>Enter trip or airport details in the form or send us your trip details on WhatsApp.</span>
              </div>
            </div>
            <div class="point">
              <div class="square-icon"><i class="bi bi-tags-fill"></i></div>
              <div>
                <strong>Get Fixed Quote</strong>
                <span>We share an all-inclusive fare with no hidden charges or last-minute surprises.</span>
              </div>
            </div>
            <div class="point">
              <div class="square-icon"><i class="bi bi-emoji-smile-fill"></i></div>
              <div>
                <strong>Ride With Peace</strong>
                <span>Verified chauffeurs, clean cars and support throughout your journey.</span>
              </div>
            </div>
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
    const filterButtons = document.querySelectorAll(".filter-btn");
    const fleetCards = document.querySelectorAll(".fleet-card");

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
 

      

      filterButtons.forEach((button) => {
        button.addEventListener("click", () => {
          filterButtons.forEach((btn) => btn.classList.remove("active"));
          button.classList.add("active");

          const filterValue = button.getAttribute("data-filter");

          fleetCards.forEach((card) => {
            const category = card.getAttribute("data-category");

            if (filterValue === "all" || filterValue === category) {
              card.style.display = "block";
            } else {
              card.style.display = "none";
            }
          });
        });
      });
  </script>
  
</body>
</html>
