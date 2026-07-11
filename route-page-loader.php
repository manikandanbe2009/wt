<?php
require_once __DIR__ . '/route-data.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
$currentFile = basename((string) $requestUri);
$slug = preg_replace('/\.php$/', '', $currentFile);
$selectedRoute = app_route_page((string) $slug);

if ($selectedRoute === null) {
    http_response_code(404);
    exit('Route not found.');
}

require __DIR__ . '/route-landing.php';
exit;
