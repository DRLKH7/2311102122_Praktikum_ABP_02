<?php
require __DIR__ . '/../bootstrap/app.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$routes = require __DIR__ . '/../routes/web.php';

if (isset($routes[$requestUri]) && is_callable($routes[$requestUri])) {
    $routes[$requestUri]();
    return;
}

http_response_code(404);
echo '<h1>404 Not Found</h1><p>Halaman tidak ditemukan.</p>';
