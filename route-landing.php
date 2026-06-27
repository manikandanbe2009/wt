<?php
require_once __DIR__ . '/route-data.php';

if (!isset($selectedRoute) || !is_array($selectedRoute)) {
    http_response_code(404);
    exit('Route not found.');
}

require __DIR__ . '/index.php';
