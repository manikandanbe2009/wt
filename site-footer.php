<?php
require_once __DIR__ . '/route-data.php';

$routeLinks = array_values(app_route_pages());
$chennaiLinks = array_values(app_route_chennai_pages());
$airportLinks = array_values(app_route_airport_pages());
?>
<footer id="contact">
  <div class="container">
    <div class="footer-shell footer-shell-expanded">
      
      <div class="footer-col">
        <h4>Contact Us</h4>
        <nav>
          <p>White Call Taxi, 24 GST Road, Guindy, Chennai, Tamil Nadu 600032</p>
          <a href="tel:+911234567890">+91 12345 67890</a>
          <a href="mailto:info@whitecalltaxi.com">info@whitecalltaxi.com</a>
          <a href="contact.php">24/7 Booking Support</a>
          <div class="socials">
          <a href="tel:+911234567890" aria-label="Call White Call Taxi">Call</a>
          <a href="https://wa.me/911234567890" aria-label="WhatsApp White Call Taxi">WA</a>
          <a href="mailto:info@whitecalltaxi.com" aria-label="Email White Call Taxi">Mail</a>
        </div>
        </nav>
      </div>
     

      <div class="footer-col">
        <h4>Chennai One Way Taxi</h4>
        <nav>
          <?php foreach ($chennaiLinks as $route): ?>
            <a href="<?= htmlspecialchars($route['slug'] . '.php', ENT_QUOTES, 'UTF-8') ?>">
             <?= htmlspecialchars($route['pickup'] . ' to ' . $route['drop'], ENT_QUOTES, 'UTF-8') ?>
            </a>
          <?php endforeach; ?>
        </nav>
      </div>
      <div class="footer-col">
        <h4>Airport Outstation Taxi</h4>
        <nav>
          <?php foreach ($airportLinks as $route): ?>
            <a href="<?= htmlspecialchars($route['slug'] . '.php', ENT_QUOTES, 'UTF-8') ?>">
             <?= htmlspecialchars($route['pickup'], ENT_QUOTES, 'UTF-8') ?> One Way Taxi
            </a>
          <?php endforeach; ?>
        </nav>
      </div>

      <div class="footer-col footer-routes-col">
        <h4>One Way Outstation Taxi</h4>
        <nav class="footer-route-links" aria-label="Popular taxi routes">
          <?php foreach ($routeLinks as $route): ?>
            <a href="<?= htmlspecialchars($route['slug'] . '.php', ENT_QUOTES, 'UTF-8') ?>">
             <?= htmlspecialchars($route['pickup'] . ' to ' . $route['drop'], ENT_QUOTES, 'UTF-8') ?>
            </a>
          <?php endforeach; ?>
        </nav>
      </div>

      
    </div>

    <div class="footer-bottom">
      <div>&copy; 2026 White Call Taxi. All Rights Reserved.</div>
      <div>
        <a href="index.php">Home</a>
        <a href="services.php">Services</a>
        <a href="pricing.php">Pricing</a>
        <a href="contact.php">Contact</a>
        <a href="about.php">About</a>
        <a href="fleet.php">Fleet</a>
        <a href="index.php#booking">Book Now</a>
      </div>
    </div>
  </div>
</footer>
