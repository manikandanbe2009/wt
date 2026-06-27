<?php
require_once __DIR__ . '/route-data.php';

$routeLinks = array_values(app_route_pages());
?>
<footer id="contact">
  <div class="container">
    <div class="footer-shell glass footer-shell-expanded">
      <div class="footer-brand">
        <a class="brand footer-brand-row" href="index.php" aria-label="White Call Taxi">          
          <div class="brand-copy footer-copy">
            <strong>WHITE CALL TAXI</strong>
            <span>Airport, City & Outstation Taxi</span>
            <p class="mt-3">
            <span class="contact-icon"><i class="bi bi-telephone"></i></span>
            <a href="tel:+919841766590" target="_blank"><span>+91 98417 66590</span></a>
          </p>
          <p>
            <span class="contact-icon"><i class="bi bi-envelope"></i></span>
            <a href="mailto:sivamonewaytaxi2026@gmail.com" target="_blank"><span>sivamonewaytaxi2026@gmail.com</span></a>
          </p>
            <a href="index.php#contact">24/7 Booking Support</a>
          </div>
        </a>
       
      </div>

     

      <div class="footer-col">
        <h4>Our Services</h4>
        <nav>
          <a href="index.php#services">Airport Taxi</a>
          <a href="index.php#services">One Way Taxi</a>
          <a href="index.php#services">Round Trip Taxi</a>
          <a href="index.php#services">Local City Rides</a>
          <a href="index.php#services">Corporate Cab Service</a>
          <a href="index.php#pricing">Fare Details</a>
        </nav>
      </div>

      <div class="footer-col footer-routes-col">
        <h4>Top Routes</h4>
        <nav class="footer-route-links" aria-label="Popular taxi routes">
          <?php foreach ($routeLinks as $route): ?>
            <a href="<?= htmlspecialchars($route['slug'] . '.php', ENT_QUOTES, 'UTF-8') ?>">
              <?= htmlspecialchars($route['pickup'] . ' to ' . $route['drop'], ENT_QUOTES, 'UTF-8') ?>
            </a>
          <?php endforeach; ?>
        </nav>
      </div>

      <div class="footer-col">
        <h4>Contact Us</h4>
        <nav>
          <p>White Call Taxi, Tamil Nadu, India</p>
          <a href="tel:+911234567890">+91 12345 67890</a>
          <a href="mailto:info@whitecalltaxi.com">info@whitecalltaxi.com</a>
          <a href="index.php#contact">24/7 Booking Support</a>
          <div class="socials">
          <a href="tel:+911234567890" aria-label="Call White Call Taxi">Call</a>
          <a href="https://wa.me/911234567890" aria-label="WhatsApp White Call Taxi">WA</a>
          <a href="mailto:info@whitecalltaxi.com" aria-label="Email White Call Taxi">Mail</a>
        </div>
        </nav>
      </div>
    </div>

    <div class="footer-bottom">
      <div>&copy; 2026 White Call Taxi. All Rights Reserved.</div>
      <div>
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="fleet.php">Fleet</a>
        <a href="index.php#booking">Book Now</a>
      </div>
    </div>
  </div>
</footer>
