<?php
require_once __DIR__ . '/db.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!empty($_SESSION['admin_user'])) {
    header('Location: admin_dashboard.php');
    exit;
}

$errorMessage = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $errorMessage = 'Enter username and password.';
    } else {
        $db = app_db();
        $stmt = $db->prepare('SELECT id, username, password_hash FROM admin_users WHERE username = ? LIMIT 1');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $admin = $stmt->get_result()->fetch_assoc();

        if (!$admin || !password_verify($password, (string) $admin['password_hash'])) {
            $errorMessage = 'Invalid username or password.';
        } else {
            $_SESSION['admin_user'] = [
                'id' => (int) $admin['id'],
                'username' => (string) $admin['username'],
            ];
            header('Location: admin_dashboard.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | White Call Taxi</title>
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
          <div class="booking-card glass" style="max-width: 520px; margin: 0 auto;">
            <div class="card-title">
              <div class="square-icon">A</div>
              <h2>Admin Login</h2>
            </div>
            <?php if ($errorMessage !== ''): ?>
              <p class="form-message form-message-error" style="display:block;"><?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
            <form method="post" class="booking-grid" novalidate>
              <div class="field">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>" required>
              </div>
              <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required>
              </div>
              <button class="button button-primary" type="submit">Login</button>
            </form>
            <p style="margin-top:16px;color:rgba(255,255,255,0.7);">Default login: `admin` / `admin123`</p>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>
</html>
