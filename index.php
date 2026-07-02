<?php

require_once __DIR__ . '/config/database.php';

$request = $_SERVER['REQUEST_URI'];

if ($request === '/' || $request === '') {
    echo json_encode([
        "status" => "success",
        "message" => "🚀 API is running on Railway"
    ]);
    exit;
}

// API routing
if (strpos($request, '/api/') === 0) {
    $file = __DIR__ . $request . ".php";

    if (file_exists($file)) {
        include $file;
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Endpoint not found"]);
    }
    exit;
}

http_response_code(404);
echo json_encode(["error" => "Route not found"]);