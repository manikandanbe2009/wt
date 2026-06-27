<?php
require_once __DIR__ . '/db.php';

app_require_admin();

$db = app_db();
$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update_fares') {
    $vehicleCodes = $_POST['vehicle_code'] ?? [];
    $vehicleNames = $_POST['vehicle_name'] ?? [];
    $oneWayBaseFares = $_POST['one_way_base_fare'] ?? [];
    $roundTripBaseFares = $_POST['round_trip_base_fare'] ?? [];
    $oneWayPerKmRates = $_POST['one_way_per_km'] ?? [];
    $roundTripPerKmRates = $_POST['round_trip_per_km'] ?? [];
    $oneWayDriverBataRates = $_POST['one_way_driver_bata'] ?? [];
    $roundTripDriverBataRates = $_POST['round_trip_driver_bata'] ?? [];

    try {
        $stmt = $db->prepare(
            'UPDATE cab_fares
             SET vehicle_name = ?, one_way_base_fare = ?, round_trip_base_fare = ?, one_way_per_km = ?, round_trip_per_km = ?, one_way_driver_bata = ?, round_trip_driver_bata = ?
             WHERE vehicle_code = ?'
        );

        foreach ($vehicleCodes as $index => $vehicleCode) {
            $code = trim((string) $vehicleCode);
            $name = trim((string) ($vehicleNames[$index] ?? $code));
            $oneWayBaseFare = (float) ($oneWayBaseFares[$index] ?? 0);
            $roundTripBaseFare = (float) ($roundTripBaseFares[$index] ?? 0);
            $oneWayPerKm = (float) ($oneWayPerKmRates[$index] ?? 0);
            $roundTripPerKm = (float) ($roundTripPerKmRates[$index] ?? 0);
            $oneWayDriverBata = (float) ($oneWayDriverBataRates[$index] ?? 0);
            $roundTripDriverBata = (float) ($roundTripDriverBataRates[$index] ?? 0);

            if ($code === '' || $name === '') {
                continue;
            }

            $stmt->bind_param('sddddddds', $name, $oneWayBaseFare, $roundTripBaseFare, $oneWayPerKm, $roundTripPerKm, $oneWayDriverBata, $roundTripDriverBata, $code);
            $stmt->execute();
        }

        $successMessage = 'Fare settings updated successfully.';
    } catch (Throwable $e) {
        $errorMessage = 'Unable to update fare settings.';
    }
}

$rates = app_rate_table();
$totalBookings = (int) $db->query('SELECT COUNT(*) AS total FROM website_bookings')->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | White Call Taxi</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <style>
    .admin-shell { max-width: 1200px; margin: 0 auto; padding: 32px 16px 56px; }
    .admin-topbar, .admin-card { background: rgba(12, 20, 41, 0.9); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; }
    .admin-topbar { display:flex; justify-content:space-between; align-items:center; gap:16px; padding:20px 24px; margin-bottom:24px; }
    .admin-grid { display:grid; gap:24px; }
    .admin-card { padding:24px; overflow:auto; }
    .admin-table { width:100%; border-collapse:collapse; min-width:960px; }
    .admin-table th, .admin-table td { padding:12px 10px; border-bottom:1px solid rgba(255,255,255,0.08); text-align:left; color:#fff; vertical-align:top; }
    .admin-table th { color:#ffc107; font-size:13px; letter-spacing:0.04em; }
    .admin-table input { width:100%; }
    .admin-muted { color:rgba(255,255,255,0.68); }
  </style>
</head>
<body>
  <main class="home-page">
    <div class="admin-shell">
      <div class="admin-topbar">
        <div>
          <h1 style="margin:0;color:#fff;">Admin Dashboard</h1>
          <p class="admin-muted" style="margin:6px 0 0;">Welcome, <?= htmlspecialchars((string) $_SESSION['admin_user']['username'], ENT_QUOTES, 'UTF-8') ?></p>
        </div>
        <div style="display:flex; gap:12px; align-items:center;">
          <a class="button button-secondary" href="admin_bookings.php">Booking List</a>
          <a class="button button-secondary" href="index.php">View Website</a>
          <a class="button button-primary" href="admin_logout.php">Logout</a>
        </div>
      </div>

      <?php if ($successMessage !== ''): ?>
        <p class="form-message form-message-success" style="display:block;"><?= htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8') ?></p>
      <?php endif; ?>
      <?php if ($errorMessage !== ''): ?>
        <p class="form-message form-message-error" style="display:block;"><?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') ?></p>
      <?php endif; ?>

      <div class="admin-grid">
        <section class="admin-card">
          <div class="card-title">
            <div class="square-icon">R</div>
            <h2>Cab Fare Settings</h2>
          </div>
          <p class="admin-muted">Updates here are stored in the database and used automatically on the frontend booking form.</p>
          <form method="post">
            <input type="hidden" name="action" value="update_fares">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Code</th>
                  <th>Vehicle Name</th>
                  <th>One Way Base Fare</th>
                  <th>Round Trip Base Fare</th>
                  <th>One Way Per KM</th>
                  <th>Round Trip Per KM</th>
                  <th>One Way Driver Bata</th>
                  <th>Round Trip Driver Bata</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($rates as $vehicleCode => $rate): ?>
                  <tr>
                    <td>
                      <?= htmlspecialchars($vehicleCode, ENT_QUOTES, 'UTF-8') ?>
                      <input type="hidden" name="vehicle_code[]" value="<?= htmlspecialchars($vehicleCode, ENT_QUOTES, 'UTF-8') ?>">
                    </td>
                    <td><input name="vehicle_name[]" type="text" value="<?= htmlspecialchars((string) $rate['vehicle_name'], ENT_QUOTES, 'UTF-8') ?>"></td>
                    <td><input name="one_way_base_fare[]" type="number" min="0" step="0.01" value="<?= htmlspecialchars((string) $rate['one_way_base_fare'], ENT_QUOTES, 'UTF-8') ?>"></td>
                    <td><input name="round_trip_base_fare[]" type="number" min="0" step="0.01" value="<?= htmlspecialchars((string) $rate['round_trip_base_fare'], ENT_QUOTES, 'UTF-8') ?>"></td>
                    <td><input name="one_way_per_km[]" type="number" min="0" step="0.01" value="<?= htmlspecialchars((string) $rate['one_way_per_km'], ENT_QUOTES, 'UTF-8') ?>"></td>
                    <td><input name="round_trip_per_km[]" type="number" min="0" step="0.01" value="<?= htmlspecialchars((string) $rate['round_trip_per_km'], ENT_QUOTES, 'UTF-8') ?>"></td>
                    <td><input name="one_way_driver_bata[]" type="number" min="0" step="0.01" value="<?= htmlspecialchars((string) $rate['one_way_driver_bata'], ENT_QUOTES, 'UTF-8') ?>"></td>
                    <td><input name="round_trip_driver_bata[]" type="number" min="0" step="0.01" value="<?= htmlspecialchars((string) $rate['round_trip_driver_bata'], ENT_QUOTES, 'UTF-8') ?>"></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <div style="margin-top:18px;">
              <button class="button button-primary" type="submit">Update Fare Settings</button>
            </div>
          </form>
        </section>

        <section class="admin-card">
          <div class="card-title">
            <div class="square-icon">B</div>
            <h2>Booking Management</h2>
          </div>
          <p class="admin-muted">You have <?= htmlspecialchars((string) $totalBookings, ENT_QUOTES, 'UTF-8') ?> booking(s). Open the separate booking screen to view paginated records and update booking details.</p>
          <a class="button button-primary" href="admin_bookings.php">Open Booking List</a>
        </section>
      </div>
    </div>
  </main>
</body>
</html>
