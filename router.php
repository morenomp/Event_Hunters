<?php

$uriPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$documentRoot = __DIR__;
$requestedPath = realpath($documentRoot . $uriPath);

if ($uriPath !== '/' && $requestedPath !== false && str_starts_with($requestedPath, $documentRoot) && is_file($requestedPath)) {
    return false;
}

if ($uriPath === '/' || $uriPath === '') {
    require $documentRoot . '/index.php';
    return true;
}

$normalizedPath = rtrim($uriPath, '/');
$candidate = $documentRoot . $normalizedPath . '.php';

if (is_file($candidate)) {
    require $candidate;
    return true;
}

return false;
