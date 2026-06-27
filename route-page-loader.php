<?php
require_once __DIR__ . '/route-data.php';

$currentFile = basename((string) ($_SERVER['SCRIPT_NAME'] ?? ''));
$slug = preg_replace('/\.php$/', '', $currentFile);
$selectedRoute = app_route_page((string) $slug);

if ($selectedRoute === null) {
    http_response_code(404);
    exit('Route not found.');
}

require __DIR__ . '/route-landing.php';
exit;
