<?php
require_once __DIR__ . '/route-data.php';

$routeLinks = array_values(app_route_pages());
$chennaiLinks = array_values(app_route_chennai_pages());
$airportLinks = array_values(app_route_airport_pages());

$phone = env_value('BUSINESS_PHONE', '+91 70090 05354');
$cleanPhone = preg_replace('/[^+0-9]/', '', $phone);
$email = env_value('BUSINESS_EMAIL', 'info@whitecalltaxi.com');
$whatsapp = env_value('WHATSAPP_NUMBER', '917009005354');
?>
<footer id="contact">
  <div class="container">
    <div class="footer-shell footer-shell-expanded">
      
      <div class="footer-col">
        <h4>Contact Us</h4>
        <nav>
          <p>White Call Taxi, 24 GST Road, Guindy, Chennai, Tamil Nadu 600032</p>
          <a href="tel:<?= htmlspecialchars($cleanPhone, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') ?></a>
          <a href="mailto:<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?></a>
          <a href="contact.php">24/7 Booking Support</a>
          <div class="socials">
          <a href="tel:<?= htmlspecialchars($cleanPhone, ENT_QUOTES, 'UTF-8') ?>" aria-label="Call White Call Taxi">Call</a>
          <a href="https://wa.me/<?= htmlspecialchars($whatsapp, ENT_QUOTES, 'UTF-8') ?>" aria-label="WhatsApp White Call Taxi">WA</a>
          <a href="mailto:<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" aria-label="Email White Call Taxi">Mail</a>
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

<!-- Floating WhatsApp Chat Badge -->
<a href="https://wa.me/<?= htmlspecialchars($whatsapp, ENT_QUOTES, 'UTF-8') ?>?text=<?= urlencode('Hello White Call Taxi, I want to book a ride.') ?>" class="whatsapp-float-badge" target="_blank" rel="noopener noreferrer" aria-label="Book Taxi via WhatsApp">
  <i class="bi bi-whatsapp"></i>
  <span>Book via WhatsApp</span>
</a>
