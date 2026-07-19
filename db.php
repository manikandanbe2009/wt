<?php
require_once __DIR__ . '/config.php';

function app_db(): mysqli
{
    static $db = null;

    if ($db instanceof mysqli) {
        return $db;
    }

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $host = env_value('DB_HOST', 'localhost');
    $name = env_value('DB_NAME', 'whitetaxi');
    $user = env_value('DB_USER', 'root');
    $pass = env_value('DB_PASS', '');
    $port = (int) env_value('DB_PORT', '3307');

    $server = new mysqli($host, $user, $pass, '', $port);
    $server->set_charset('utf8mb4');
    $server->query(
        sprintf(
            'CREATE DATABASE IF NOT EXISTS `%s` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci',
            $server->real_escape_string($name)
        )
    );
    $server->select_db($name);

    app_ensure_schema($server);

    $db = $server;

    return $db;
}

function app_ensure_schema(mysqli $db): void
{
    $db->query(
        'CREATE TABLE IF NOT EXISTS website_bookings (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            booking_code VARCHAR(32) NOT NULL UNIQUE,
            name VARCHAR(150) NOT NULL,
            mobile VARCHAR(20) NOT NULL,
            email VARCHAR(190) NOT NULL,
            pickup TEXT NOT NULL,
            drop_location TEXT NOT NULL,
            travel_date DATE NOT NULL,
            travel_time VARCHAR(20) NOT NULL,
            vehicle VARCHAR(80) NOT NULL,
            trip_type VARCHAR(20) NOT NULL,
            trip_days INT NOT NULL DEFAULT 1,
            distance_km DECIMAL(10,2) NOT NULL DEFAULT 0,
            base_fare DECIMAL(10,2) NOT NULL DEFAULT 0,
            per_km DECIMAL(10,2) NOT NULL DEFAULT 0,
            dist_charge DECIMAL(10,2) NOT NULL DEFAULT 0,
            driver_allowance DECIMAL(10,2) NOT NULL DEFAULT 0,
            total_fare DECIMAL(10,2) NOT NULL DEFAULT 0,
            customer_sent TINYINT(1) NOT NULL DEFAULT 0,
            business_sent TINYINT(1) NOT NULL DEFAULT 0,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );

    $db->query(
        'CREATE TABLE IF NOT EXISTS cab_fares (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            vehicle_code VARCHAR(32) NOT NULL UNIQUE,
            vehicle_name VARCHAR(80) NOT NULL,
            one_way_base_fare DECIMAL(10,2) NOT NULL DEFAULT 0,
            round_trip_base_fare DECIMAL(10,2) NOT NULL DEFAULT 0,
            one_way_per_km DECIMAL(10,2) NOT NULL DEFAULT 0,
            round_trip_per_km DECIMAL(10,2) NOT NULL DEFAULT 0,
            one_way_driver_bata DECIMAL(10,2) NOT NULL DEFAULT 0,
            round_trip_driver_bata DECIMAL(10,2) NOT NULL DEFAULT 0,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );

    $cabFareColumns = [];
    $columnsResult = $db->query("SHOW COLUMNS FROM cab_fares");
    while ($column = $columnsResult->fetch_assoc()) {
        $cabFareColumns[] = (string) $column['Field'];
    }

    if (!in_array('one_way_base_fare', $cabFareColumns, true)) {
        $db->query('ALTER TABLE cab_fares ADD COLUMN one_way_base_fare DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER vehicle_name');
    }

    if (!in_array('round_trip_base_fare', $cabFareColumns, true)) {
        $db->query('ALTER TABLE cab_fares ADD COLUMN round_trip_base_fare DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER one_way_base_fare');
    }

    if (!in_array('one_way_per_km', $cabFareColumns, true)) {
        $db->query('ALTER TABLE cab_fares ADD COLUMN one_way_per_km DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER round_trip_base_fare');
    }

    if (!in_array('round_trip_per_km', $cabFareColumns, true)) {
        $db->query('ALTER TABLE cab_fares ADD COLUMN round_trip_per_km DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER one_way_per_km');
    }

    if (!in_array('one_way_driver_bata', $cabFareColumns, true)) {
        $db->query('ALTER TABLE cab_fares ADD COLUMN one_way_driver_bata DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER per_km');
    }

    if (!in_array('round_trip_driver_bata', $cabFareColumns, true)) {
        $db->query('ALTER TABLE cab_fares ADD COLUMN round_trip_driver_bata DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER one_way_driver_bata');
    }

    if (in_array('base_fare', $cabFareColumns, true)) {
        $db->query(
            'UPDATE cab_fares
             SET one_way_base_fare = CASE
                    WHEN one_way_base_fare = 0 THEN base_fare
                    ELSE one_way_base_fare
                 END,
                 round_trip_base_fare = CASE
                    WHEN round_trip_base_fare = 0 THEN base_fare
                    ELSE round_trip_base_fare
                 END'
        );
    }

    if (in_array('per_km', $cabFareColumns, true)) {
        $db->query(
            'UPDATE cab_fares
             SET one_way_per_km = CASE
                    WHEN one_way_per_km = 0 THEN per_km
                    ELSE one_way_per_km
                 END,
                 round_trip_per_km = CASE
                    WHEN round_trip_per_km = 0 THEN per_km
                    ELSE round_trip_per_km
                 END'
        );
    }

    if (in_array('driver_allowance', $cabFareColumns, true)) {
        $db->query(
            'UPDATE cab_fares
             SET round_trip_driver_bata = CASE
                     WHEN round_trip_driver_bata = 0 THEN driver_allowance
                     ELSE round_trip_driver_bata
                 END,
                 one_way_driver_bata = CASE
                     WHEN one_way_driver_bata = 0 THEN driver_allowance
                     ELSE one_way_driver_bata
                 END'
        );
    }

    $db->query(
        'CREATE TABLE IF NOT EXISTS admin_users (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(80) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );

    $defaultFares = [
        'SEDAN' => ['Sedan', 150, 150, 14, 14, 300, 300],
        'ETIOS' => ['Etios', 140, 140, 13, 13, 300, 300],
        'SUV' => ['SUV', 220, 220, 19, 19, 400, 400],
        'INNOVA' => ['Innova', 260, 260, 20, 20, 450, 450],
    ];

    $fareStmt = $db->prepare(
        'INSERT INTO cab_fares (
            vehicle_code, vehicle_name, one_way_base_fare, round_trip_base_fare,
            one_way_per_km, round_trip_per_km, one_way_driver_bata, round_trip_driver_bata
         ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
         ON DUPLICATE KEY UPDATE vehicle_name = VALUES(vehicle_name)'
    );

    foreach ($defaultFares as $code => [$name, $oneWayBaseFare, $roundTripBaseFare, $oneWayPerKm, $roundTripPerKm, $oneWayDriverBata, $roundTripDriverBata]) {
        $fareStmt->bind_param('ssdddddd', $code, $name, $oneWayBaseFare, $roundTripBaseFare, $oneWayPerKm, $roundTripPerKm, $oneWayDriverBata, $roundTripDriverBata);
        $fareStmt->execute();
    }

    $adminExists = (int) $db->query('SELECT COUNT(*) AS total FROM admin_users')->fetch_assoc()['total'];
    if ($adminExists === 0) {
        $username = env_value('ADMIN_USERNAME', 'admin');
        $password = env_value('ADMIN_PASSWORD', 'admin123');
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $adminStmt = $db->prepare('INSERT INTO admin_users (username, password_hash) VALUES (?, ?)');
        $adminStmt->bind_param('ss', $username, $passwordHash);
        $adminStmt->execute();
    }
}

function app_rate_table(): array
{
    $db = app_db();
    $result = $db->query('SELECT vehicle_code, vehicle_name, one_way_base_fare, round_trip_base_fare, one_way_per_km, round_trip_per_km, one_way_driver_bata, round_trip_driver_bata FROM cab_fares ORDER BY id ASC');
    $rates = [];

    while ($row = $result->fetch_assoc()) {
        $rates[$row['vehicle_code']] = [
            'vehicle_name' => (string) $row['vehicle_name'],
            'one_way_base_fare' => (float) $row['one_way_base_fare'],
            'round_trip_base_fare' => (float) $row['round_trip_base_fare'],
            'one_way_per_km' => (float) $row['one_way_per_km'],
            'round_trip_per_km' => (float) $row['round_trip_per_km'],
            'one_way_driver_bata' => (float) $row['one_way_driver_bata'],
            'round_trip_driver_bata' => (float) $row['round_trip_driver_bata'],
        ];
    }

    return $rates;
}

function app_require_admin(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (empty($_SESSION['admin_user'])) {
        header('Location: admin_login.php');
        exit;
    }
}

function app_vehicle_label(string $vehicleCode): string
{
    $rates = app_rate_table();

    return $rates[$vehicleCode]['vehicle_name'] ?? $vehicleCode;
}
