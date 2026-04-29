<?php
require __DIR__ . '/includes/i18n.php';
event_hunters_boot_i18n();

$uriPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$route = trim($uriPath, '/');

if (str_ends_with($route, '.php')) {
    $route = substr($route, 0, -4);
}

$routes = [
    '' => 'VIEW/index.php',
    'index' => 'VIEW/index.php',
    'about_us' => 'VIEW/about_us.php',
    'crearEvento' => 'VIEW/crearEvento.php',
    'cuenta' => 'VIEW/cuenta.php',
    'cuentaAdmin' => 'VIEW/cuentaAdmin.php',
    'cuentaMod' => 'VIEW/cuentaMod.php',
    'eventos' => 'VIEW/eventos.php',
    'login' => 'VIEW/login.php',
    'pagEventos' => 'VIEW/pagEventos.php',
    'registro' => 'VIEW/registro.php',
    'registroAdmin' => 'VIEW/registroAdmin.php',
];

if (!isset($routes[$route])) {
    http_response_code(404);
    echo '404';
    exit();
}

require __DIR__ . '/' . $routes[$route];
