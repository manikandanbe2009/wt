<?php
require_once __DIR__ . '/route-data.php';

$routeLinks = array_values(app_route_pages());
?>
<footer id="contact">
  <div class="container">
    <div class="footer-shell glass footer-shell-expanded">
      

     

      <div class="footer-col">
        <h4>Chennai One Way Taxi</h4>
        <nav>
          <a href="index.php#services"> One Way Taxi Chennai to Bangalore</a>
          <a href="index.php#services">One Way Taxi Chennai to Tirupati</a>
          <a href="index.php#services">One Way Taxi Chennai to Pondy</a>
          <a href="index.php#services">One Way Taxi Chennai to Vellore</a>
          <a href="index.php#services">One Way Taxi Chennai to Salem</a>
          <a href="index.php#services">One Way Taxi Chennai to Trichy</a>
          <a href="index.php#services">One Way Taxi Chennai to Coimbatore</a>
          <a href="index.php#services">One Way Taxi Chennai to Madurai</a>
          <a href="index.php#services">One Way Taxi Chennai to Cuddalore</a>
          <a href="index.php#services">One Way Taxi Chennai to Kanyakumari</a>
        </nav>
      </div>
      <div class="footer-col">
        <h4>Airport Outstation Taxi</h4>
        <nav>
          <a href="index.php#services"> Chennai Airport One Way Taxi</a>
          <a href="index.php#services">Bangalore Airport One Way Taxi</a>
          <a href="index.php#services">Tirupati Airport One Way Taxi</a>
          <a href="index.php#services">Hyderabad Airport One Way Taxi</a>
          <a href="index.php#services">Coimbatore Airport One Way Taxi</a>
          <a href="index.php#pricing">Trichy Airport One Way Taxi</a>
          <a href="index.php#pricing">Madurai Airport One Way Taxi</a>
        <a href="index.php#pricing">Salem Airport One Way Taxi</a>
        <a href="index.php#pricing">Vellore Airport One Way Taxi</a>
        <a href="index.php#pricing">Thoothukudi Airport One Way Taxi</a>
        </nav>
      </div>

      <div class="footer-col footer-routes-col">
        <h4>One Way Outstation Taxi</h4>
        <nav class="footer-route-links" aria-label="Popular taxi routes">
          <?php foreach ($routeLinks as $route): ?>
            <a href="<?= htmlspecialchars($route['slug'] . '.php', ENT_QUOTES, 'UTF-8') ?>">
              One Way Taxi <?= htmlspecialchars($route['pickup'] . ' to ' . $route['drop'], ENT_QUOTES, 'UTF-8') ?>
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
