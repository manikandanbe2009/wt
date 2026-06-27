<?php
require_once __DIR__ . '/db.php';

app_require_admin();

$db = app_db();
$bookingId = trim((string) ($_GET['booking_id'] ?? $_POST['booking_id'] ?? ''));
$successMessage = '';
$errorMessage = '';
$rates = app_rate_table();

if ($bookingId === '') {
    header('Location: admin_bookings.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($_POST['name'] ?? ''));
    $mobile = trim((string) ($_POST['mobile'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $pickup = trim((string) ($_POST['pickup'] ?? ''));
    $dropLocation = trim((string) ($_POST['drop_location'] ?? ''));
    $travelDate = trim((string) ($_POST['travel_date'] ?? ''));
    $travelTime = trim((string) ($_POST['travel_time'] ?? ''));
    $vehicle = trim((string) ($_POST['vehicle'] ?? ''));
    $tripType = trim((string) ($_POST['trip_type'] ?? 'one-way'));
    $tripDays = max(1, (int) ($_POST['trip_days'] ?? 1));
    $distanceKm = (float) ($_POST['distance_km'] ?? 0);
    $baseFare = (float) ($_POST['base_fare'] ?? 0);
    $perKm = (float) ($_POST['per_km'] ?? 0);
    $distCharge = (float) ($_POST['dist_charge'] ?? 0);
    $driverAllowance = (float) ($_POST['driver_allowance'] ?? 0);
    $totalFare = (float) ($_POST['total_fare'] ?? 0);

    try {
        $stmt = $db->prepare(
            'UPDATE website_bookings
             SET name = ?, mobile = ?, email = ?, pickup = ?, drop_location = ?, travel_date = ?, travel_time = ?,
                 vehicle = ?, trip_type = ?, trip_days = ?, distance_km = ?, base_fare = ?, per_km = ?,
                 dist_charge = ?, driver_allowance = ?, total_fare = ?
             WHERE booking_code = ?'
        );
        $stmt->bind_param(
            'sssssssssidddddds',
            $name,
            $mobile,
            $email,
            $pickup,
            $dropLocation,
            $travelDate,
            $travelTime,
            $vehicle,
            $tripType,
            $tripDays,
            $distanceKm,
            $baseFare,
            $perKm,
            $distCharge,
            $driverAllowance,
            $totalFare,
            $bookingId
        );
        $stmt->execute();
        $successMessage = 'Booking updated successfully.';
    } catch (Throwable $e) {
        $errorMessage = 'Unable to update booking details.';
    }
}

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
$booking = $stmt->get_result()->fetch_assoc();

if (!$booking) {
    header('Location: admin_bookings.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Booking | White Call Taxi Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <main class="home-page">
    <section class="hero" style="min-height: 100vh; padding: 40px 0;">
      <div class="container">
        <div class="hero-shell" style="grid-template-columns: minmax(0, 1fr);">
          <div class="booking-card glass" style="max-width: 980px; margin: 0 auto;">
            <div style="display:flex; justify-content:space-between; gap:12px; align-items:center; margin-bottom:16px;">
              <div class="card-title" style="margin:0;">
                <div class="square-icon">B</div>
                <h2>Update Booking</h2>
              </div>
              <a class="button button-secondary" href="admin_bookings.php">Back to Booking List</a>
            </div>

            <?php if ($successMessage !== ''): ?>
              <p class="form-message form-message-success" style="display:block;"><?= htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
            <?php if ($errorMessage !== ''): ?>
              <p class="form-message form-message-error" style="display:block;"><?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>

            <form method="post" class="booking-grid">
              <input type="hidden" name="booking_id" value="<?= htmlspecialchars((string) $booking['booking_code'], ENT_QUOTES, 'UTF-8') ?>">

              <div class="field">
                <label>Booking ID</label>
                <input type="text" value="<?= htmlspecialchars((string) $booking['booking_code'], ENT_QUOTES, 'UTF-8') ?>" readonly>
              </div>

              <div class="field-row field-row-compact">
                <div class="field">
                  <label for="name">Name</label>
                  <input id="name" name="name" type="text" value="<?= htmlspecialchars((string) $booking['name'], ENT_QUOTES, 'UTF-8') ?>">
                </div>
                <div class="field">
                  <label for="mobile">Mobile</label>
                  <input id="mobile" name="mobile" type="text" value="<?= htmlspecialchars((string) $booking['mobile'], ENT_QUOTES, 'UTF-8') ?>">
                </div>
              </div>

              <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="<?= htmlspecialchars((string) $booking['email'], ENT_QUOTES, 'UTF-8') ?>">
              </div>

              <div class="field">
                <label for="pickup">Pickup</label>
                <input id="pickup" name="pickup" type="text" value="<?= htmlspecialchars((string) $booking['pickup'], ENT_QUOTES, 'UTF-8') ?>">
              </div>

              <div class="field">
                <label for="drop_location">Drop</label>
                <input id="drop_location" name="drop_location" type="text" value="<?= htmlspecialchars((string) $booking['drop_location'], ENT_QUOTES, 'UTF-8') ?>">
              </div>

              <div class="field-row field-row-compact">
                <div class="field">
                  <label for="travel_date">Date</label>
                  <input id="travel_date" name="travel_date" type="date" value="<?= htmlspecialchars((string) $booking['travel_date'], ENT_QUOTES, 'UTF-8') ?>">
                </div>
                <div class="field">
                  <label for="travel_time">Time</label>
                  <input id="travel_time" name="travel_time" type="time" value="<?= htmlspecialchars((string) $booking['travel_time'], ENT_QUOTES, 'UTF-8') ?>">
                </div>
              </div>

              <div class="field-row field-row-compact">
                <div class="field">
                  <label for="vehicle">Vehicle</label>
                  <select id="vehicle" name="vehicle">
                    <?php foreach ($rates as $vehicleCode => $rate): ?>
                      <option value="<?= htmlspecialchars($vehicleCode, ENT_QUOTES, 'UTF-8') ?>" <?= (string) $booking['vehicle'] === $vehicleCode ? 'selected' : '' ?>><?= htmlspecialchars((string) $rate['vehicle_name'], ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="field">
                  <label for="trip_type">Trip Type</label>
                  <select id="trip_type" name="trip_type">
                    <option value="one-way" <?= (string) $booking['trip_type'] === 'one-way' ? 'selected' : '' ?>>One Way</option>
                    <option value="two-way" <?= (string) $booking['trip_type'] === 'two-way' ? 'selected' : '' ?>>Round Trip</option>
                  </select>
                </div>
              </div>

              <div class="field-row field-row-compact">
                <div class="field">
                  <label for="trip_days">Trip Days</label>
                  <input id="trip_days" name="trip_days" type="number" min="1" value="<?= htmlspecialchars((string) $booking['trip_days'], ENT_QUOTES, 'UTF-8') ?>">
                </div>
                <div class="field">
                  <label for="distance_km">Distance KM</label>
                  <input id="distance_km" name="distance_km" type="number" min="0" step="0.01" value="<?= htmlspecialchars((string) $booking['distance_km'], ENT_QUOTES, 'UTF-8') ?>">
                </div>
              </div>

              <div class="field-row field-row-compact">
                <div class="field">
                  <label for="base_fare">Base Fare</label>
                  <input id="base_fare" name="base_fare" type="number" min="0" step="0.01" value="<?= htmlspecialchars((string) $booking['base_fare'], ENT_QUOTES, 'UTF-8') ?>">
                </div>
                <div class="field">
                  <label for="per_km">Per KM</label>
                  <input id="per_km" name="per_km" type="number" min="0" step="0.01" value="<?= htmlspecialchars((string) $booking['per_km'], ENT_QUOTES, 'UTF-8') ?>">
                </div>
              </div>

              <div class="field-row field-row-compact">
                <div class="field">
                  <label for="dist_charge">Distance Charge</label>
                  <input id="dist_charge" name="dist_charge" type="number" min="0" step="0.01" value="<?= htmlspecialchars((string) $booking['dist_charge'], ENT_QUOTES, 'UTF-8') ?>">
                </div>
                <div class="field">
                  <label for="driver_allowance">Driver Bata</label>
                  <input id="driver_allowance" name="driver_allowance" type="number" min="0" step="0.01" value="<?= htmlspecialchars((string) $booking['driver_allowance'], ENT_QUOTES, 'UTF-8') ?>">
                </div>
              </div>

              <div class="field">
                <label for="total_fare">Total Fare</label>
                <input id="total_fare" name="total_fare" type="number" min="0" step="0.01" value="<?= htmlspecialchars((string) $booking['total_fare'], ENT_QUOTES, 'UTF-8') ?>">
              </div>

              <button class="button button-primary" type="submit">Update Booking</button>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>
</html>
