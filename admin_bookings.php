<?php
require_once __DIR__ . '/db.php';

app_require_admin();

$db = app_db();
$perPage = 10;
$page = max(1, (int) ($_GET['page'] ?? 1));
$totalBookings = (int) $db->query('SELECT COUNT(*) AS total FROM website_bookings')->fetch_assoc()['total'];
$totalPages = max(1, (int) ceil($totalBookings / $perPage));
$page = min($page, $totalPages);
$offset = ($page - 1) * $perPage;

$stmt = $db->prepare(
    'SELECT booking_code, name, mobile, email, pickup, drop_location, travel_date, travel_time,
            vehicle, trip_type, trip_days, distance_km, base_fare, per_km, dist_charge,
            driver_allowance, total_fare, created_at
     FROM website_bookings
     ORDER BY id DESC
     LIMIT ? OFFSET ?'
);
$stmt->bind_param('ii', $perPage, $offset);
$stmt->execute();
$bookings = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking List | White Call Taxi Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <style>
    .admin-shell { max-width: 1200px; margin: 0 auto; padding: 32px 16px 56px; }
    .admin-topbar, .admin-card { background: rgba(12, 20, 41, 0.9); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; }
    .admin-topbar { display:flex; justify-content:space-between; align-items:center; gap:16px; padding:20px 24px; margin-bottom:24px; }
    .admin-card { padding:24px; overflow:auto; }
    .admin-table { width:100%; border-collapse:collapse; min-width:1000px; }
    .admin-table th, .admin-table td { padding:12px 10px; border-bottom:1px solid rgba(255,255,255,0.08); text-align:left; color:#fff; vertical-align:top; }
    .admin-table th { color:#ffc107; font-size:13px; letter-spacing:0.04em; }
    .admin-muted { color:rgba(255,255,255,0.68); }
    .pagination { display:flex; gap:10px; flex-wrap:wrap; margin-top:20px; }
    .pagination a, .pagination span { padding:10px 14px; border-radius:10px; text-decoration:none; border:1px solid rgba(255,255,255,0.12); color:#fff; }
    .pagination .active { background:#ffc107; color:#111; border-color:#ffc107; font-weight:700; }
  </style>
</head>
<body>
  <main class="home-page">
    <div class="admin-shell">
      <div class="admin-topbar">
        <div>
          <h1 style="margin:0;color:#fff;">Booking List</h1>
          <p class="admin-muted" style="margin:6px 0 0;"><?= htmlspecialchars((string) $totalBookings, ENT_QUOTES, 'UTF-8') ?> booking(s) found</p>
        </div>
        <div style="display:flex; gap:12px; align-items:center;">
          <a class="button button-secondary" href="admin_dashboard.php">Fare Settings</a>
          <a class="button button-primary" href="admin_logout.php">Logout</a>
        </div>
      </div>

      <section class="admin-card">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Booking ID</th>
              <th>Customer</th>
              <th>Trip</th>
              <th>Vehicle</th>
              <th>Fare</th>
              <th>Created</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!$bookings): ?>
              <tr>
                <td colspan="7" class="admin-muted">No bookings available yet.</td>
              </tr>
            <?php endif; ?>
            <?php foreach ($bookings as $booking): ?>
              <tr>
                <td><?= htmlspecialchars((string) $booking['booking_code'], ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                  <strong><?= htmlspecialchars((string) $booking['name'], ENT_QUOTES, 'UTF-8') ?></strong><br>
                  <span class="admin-muted"><?= htmlspecialchars((string) $booking['mobile'], ENT_QUOTES, 'UTF-8') ?></span><br>
                  <span class="admin-muted"><?= htmlspecialchars((string) $booking['email'], ENT_QUOTES, 'UTF-8') ?></span>
                </td>
                <td>
                  <?= htmlspecialchars((string) $booking['pickup'], ENT_QUOTES, 'UTF-8') ?><br>
                  <span class="admin-muted">to <?= htmlspecialchars((string) $booking['drop_location'], ENT_QUOTES, 'UTF-8') ?></span><br>
                  <span class="admin-muted"><?= htmlspecialchars((string) $booking['travel_date'], ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars((string) $booking['travel_time'], ENT_QUOTES, 'UTF-8') ?></span>
                </td>
                <td>
                  <?= htmlspecialchars(app_vehicle_label((string) $booking['vehicle']), ENT_QUOTES, 'UTF-8') ?><br>
                  <span class="admin-muted">
                    <?php if ($booking['trip_type'] === 'city-ride'): ?>
                      City Ride / <?= htmlspecialchars((string) $booking['trip_days'], ENT_QUOTES, 'UTF-8') ?> hr(s)
                    <?php else: ?>
                      <?= htmlspecialchars(ucwords(str_replace('-', ' ', (string) $booking['trip_type'])), ENT_QUOTES, 'UTF-8') ?> / <?= htmlspecialchars((string) $booking['trip_days'], ENT_QUOTES, 'UTF-8') ?> day(s)
                    <?php endif; ?>
                  </span>
                </td>
                <td>
                  <strong>Rs. <?= htmlspecialchars(number_format((float) $booking['total_fare'], 2), ENT_QUOTES, 'UTF-8') ?></strong><br>
                  <span class="admin-muted">Driver Bata <?= htmlspecialchars(number_format((float) $booking['driver_allowance'], 2), ENT_QUOTES, 'UTF-8') ?></span>
                </td>
                <td><?= htmlspecialchars((string) $booking['created_at'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><a class="button button-secondary" href="admin_booking_edit.php?booking_id=<?= rawurlencode((string) $booking['booking_code']) ?>">View / Update</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <div class="pagination">
          <?php if ($page > 1): ?>
            <a href="admin_bookings.php?page=<?= $page - 1 ?>">Previous</a>
          <?php endif; ?>
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php if ($i === $page): ?>
              <span class="active"><?= $i ?></span>
            <?php else: ?>
              <a href="admin_bookings.php?page=<?= $i ?>"><?= $i ?></a>
            <?php endif; ?>
          <?php endfor; ?>
          <?php if ($page < $totalPages): ?>
            <a href="admin_bookings.php?page=<?= $page + 1 ?>">Next</a>
          <?php endif; ?>
        </div>
      </section>
    </div>
  </main>
</body>
</html>
