<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/seo.php';

function booking_success_db(): mysqli
{
    return app_db();
}

function booking_label(string $tripType, int $tripDays): string
{
    if ($tripType === 'two-way') {
        return 'Round Trip' . ($tripDays > 0 ? ' (' . $tripDays . ' day' . ($tripDays === 1 ? '' : 's') . ')' : '');
    }

    return 'One Way';
}

$bookingId = trim((string) ($_GET['booking_id'] ?? ''));
$booking = null;
$pageError = '';
$vehicleLabel = '';

if ($bookingId === '') {
    $pageError = 'Booking ID is missing.';
} else {
    try {
        $db = booking_success_db();
        $stmt = $db->prepare(
            'SELECT booking_code, name, mobile, email, pickup, drop_location, travel_date, travel_time,
                    vehicle, trip_type, trip_days, distance_km, base_fare, per_km, dist_charge,
                    driver_allowance, total_fare, created_at
             FROM website_bookings
             WHERE booking_code = ?
             LIMIT 1'
        );
        $stmt->bind_param('s', $bookingId);
        $stmt->execute();
        $result = $stmt->get_result();
        $booking = $result->fetch_assoc() ?: null;

        if ($booking === null) {
            $pageError = 'Booking not found.';
        } else {
            $vehicleLabel = app_vehicle_label((string) $booking['vehicle']);
        }
    } catch (Throwable $e) {
        $pageError = 'Unable to load booking details right now.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
  app_seo_render([
      'title' => 'Booking Confirmed | White Call Taxi',
      'description' => 'White Call Taxi booking confirmation details.',
      'path' => '/booking_success.php',
      'image' => 'images/logo.png',
      'type' => 'website',
      'headline' => 'Taxi booking confirmation',
      'schema_type' => 'WebPage',
      'robots' => 'noindex, nofollow',
  ]);
  ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <main class="home-page">
    <section class="hero" style="min-height: 100vh; padding: 48px 0;">
      <div class="container">
        <div class="hero-shell" style="grid-template-columns: minmax(0, 1fr);">
          <div class="booking-card glass" style="max-width: 860px; margin: 0 auto;">
            <?php if ($pageError !== ''): ?>
              <div class="card-title">
                <div class="square-icon">!</div>
                <h2>Booking Lookup</h2>
              </div>
              <p class="form-message form-message-error" style="display: block;"><?= htmlspecialchars($pageError, ENT_QUOTES, 'UTF-8') ?></p>
              <p><a class="button button-secondary" href="index.php#booking">Back to booking</a></p>
            <?php else: ?>
              <div class="card-title">
                <div class="square-icon">OK</div>
                <h2>Booking Confirmed</h2>
              </div>
              <p class="form-message form-message-success" style="display: block;">Your booking has been saved successfully.</p>

              <div class="booking-summary-panel" style="display: block;">
                <div class="booking-summary-card">
                  <div class="booking-summary-header">
                    <h3>Your Booking Details</h3>
                  </div>

                  <div class="booking-summary-row booking-summary-row-grand">
                    <span class="summary-row-label">Booking ID</span>
                    <strong class="summary-row-value"><?= htmlspecialchars((string) $booking['booking_code'], ENT_QUOTES, 'UTF-8') ?></strong>
                  </div>
                  <div class="booking-summary-row">
                    <div>
                      <span class="summary-row-label">Customer :</span>
                      <strong class="summary-row-value"><?= htmlspecialchars((string) $booking['name'], ENT_QUOTES, 'UTF-8') ?></strong>
                    </div>
                    <div>
                      <span class="summary-row-label">Mobile :</span>
                      <strong class="summary-row-value"><?= htmlspecialchars((string) $booking['mobile'], ENT_QUOTES, 'UTF-8') ?></strong>
                    </div>
                  </div>
                  <div class="booking-summary-row">
                    <div>
                      <span class="summary-row-label">Email :</span>
                      <strong class="summary-row-value"><?= htmlspecialchars((string) $booking['email'], ENT_QUOTES, 'UTF-8') ?></strong>
                    </div>
                    <div>
                      <span class="summary-row-label">Vehicle :</span>
                      <strong class="summary-row-value"><?= htmlspecialchars($vehicleLabel, ENT_QUOTES, 'UTF-8') ?></strong>
                    </div>
                  </div>
                  <div class="booking-summary-row">
                    <div>
                      <span class="summary-row-label">Trip Type :</span>
                      <strong class="summary-row-value"><?= htmlspecialchars(booking_label((string) $booking['trip_type'], (int) $booking['trip_days']), ENT_QUOTES, 'UTF-8') ?></strong>
                    </div>
                    <div>
                      <span class="summary-row-label">Date & Time :</span>
                      <strong class="summary-row-value"><?= htmlspecialchars((string) $booking['travel_date'] . ' ' . (string) $booking['travel_time'], ENT_QUOTES, 'UTF-8') ?></strong>
                    </div>
                  </div>
                  <div class="booking-summary-row">
                    <span class="summary-row-label">Pickup :</span>
                    <strong class="summary-row-value"><?= htmlspecialchars((string) $booking['pickup'], ENT_QUOTES, 'UTF-8') ?></strong>
                  </div>
                  <div class="booking-summary-row">
                    <span class="summary-row-label">Drop :</span>
                    <strong class="summary-row-value"><?= htmlspecialchars((string) $booking['drop_location'], ENT_QUOTES, 'UTF-8') ?></strong>
                  </div>
                  <div class="booking-summary-row">
                    <div>
                      <span class="summary-row-label">Distance :</span>
                      <strong class="summary-row-value"><?= htmlspecialchars(number_format((float) $booking['distance_km'], 1), ENT_QUOTES, 'UTF-8') ?> km</strong>
                    </div>
                    <div>
                      <span class="summary-row-label">Rate Per KM :</span>
                      <strong class="summary-row-value">Rs. <?= htmlspecialchars(number_format((float) $booking['per_km'], 2), ENT_QUOTES, 'UTF-8') ?></strong>
                    </div>
                  </div>
                  <div class="booking-summary-row booking-summary-row-total">
                    <span class="summary-row-label">Base Fare :</span>
                    <strong class="summary-row-value">Rs. <?= htmlspecialchars(number_format((float) $booking['base_fare'], 2), ENT_QUOTES, 'UTF-8') ?></strong>
                  </div>
                  <div class="booking-summary-row booking-summary-row-total">
                    <span class="summary-row-label">Distance Charge :</span>
                    <strong class="summary-row-value">Rs. <?= htmlspecialchars(number_format((float) $booking['dist_charge'], 2), ENT_QUOTES, 'UTF-8') ?></strong>
                  </div>
                  <div class="booking-summary-row booking-summary-row-total">
                    <span class="summary-row-label">Driver Bata :</span>
                    <strong class="summary-row-value">Rs. <?= htmlspecialchars(number_format((float) $booking['driver_allowance'], 2), ENT_QUOTES, 'UTF-8') ?></strong>
                  </div>
                  <div class="booking-summary-row booking-summary-row-grand">
                    <span class="summary-row-label">Total Fare</span>
                    <strong class="summary-row-value">Rs. <?= htmlspecialchars(number_format((float) $booking['total_fare'], 2), ENT_QUOTES, 'UTF-8') ?></strong>
                  </div>
                </div>
              </div>

              <p style="margin-top: 20px;">
                <a class="button button-primary" href="index.php#booking">Book Another Ride</a>
              </p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>
</html>
