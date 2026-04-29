<?php

$documentRoot = dirname(__DIR__);
$uriPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$requestedPath = realpath($documentRoot . $uriPath);

if ($uriPath !== '/' && $requestedPath !== false && str_starts_with($requestedPath, $documentRoot) && is_file($requestedPath)) {
    return false;
}

require $documentRoot . '/index.php';
return true;
