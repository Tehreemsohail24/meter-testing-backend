<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

// Get only the path (ignore query string)
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Home route
if ($request === '/' || $request === '') {
    echo json_encode([
        "status" => "success",
        "message" => "🚀 API is running on Railway"
    ]);
    exit;
}

// API routes
$routes = [
    '/api/login' => __DIR__ . '/api/login.php',
    '/api/fetch_meter' => __DIR__ . '/api/fetch_meter.php',
    '/api/sync_inspection' => __DIR__ . '/api/sync_inspection.php',
    '/api/verify_otp' => __DIR__ . '/api/verify_otp.php',
];

if (isset($routes[$request])) {
    require $routes[$request];
    exit;
}

http_response_code(404);
echo json_encode([
    "status" => "error",
    "message" => "Endpoint not found"
]);