<?php
require_once '../CONTROLLER/eventsController.php'; // Ruta corregida

session_start();
$userEmail = $_SESSION['email'] ?? null; // Cambiado a 'email' que es lo que usas en el controlador

if (!$userEmail) {
    die("Usuario no autenticado");
}

$eventManager = new eventController(); 

// Llamar a la función sin parámetros, como está definida en el controlador
$eventManager->viewEventByEmail(); 

// Si no hay eventos
if (empty($eventos)) {
    echo "<p>No hay eventos programados.</p>";
    var_dump($eventos);
    echo __LINE__;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Eventos</title>
    <link rel="stylesheet" href="pagEventos.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Mis Eventos</h1>
            <p class="subtitle">Todos tus eventos en un solo lugar</p>
        </header>
        
        <?php if (empty($eventos)): ?>
            <div class="no-events">
                <p>No tienes eventos programados actualmente</p>
            </div>
        <?php else: ?>
            <div class="events-grid">
                <?php foreach ($eventos as $evento): ?>
                    <div class="event-card">
                        <div class="event-image">
                            <?= htmlspecialchars($evento['name'] ?? 'Imagen del Evento') ?>
                        </div>
                        
                        <div class="event-content">
                            <h2 class="event-title"><?= htmlspecialchars($evento['name'] ?? 'Nombre del Evento') ?></h2>
                            
                            <div class="event-details">
                                <div class="detail-item">
                                    <div class="detail-icon">📅</div>
                                    <div class="detail-text">
                                        <div class="detail-label">FECHA</div>
                                        <div class="detail-value"><?= htmlspecialchars($evento['date'] ?? 'Fecha no disponible') ?></div>
                                    </div>
                                </div>
                                
                                <div class="detail-item">
                                    <div class="detail-icon">📍</div>
                                    <div class="detail-text">
                                        <div class="detail-label">UBICACIÓN</div>
                                        <div class="detail-value"><?= htmlspecialchars($evento['place'] ?? 'Ubicación no disponible') ?></div>
                                    </div>
                                </div>

                                <div class="detail-item">
                                    <div class="detail-icon">💰</div>
                                    <div class="detail-text">
                                        <div class="detail-label">PRECIO</div>
                                        <div class="detail-value"><?= htmlspecialchars($evento['price'] ?? 'Precio no disponible') ?> €</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <footer>
            <p>Sistema de Gestión de Eventos &copy; <?= date('Y') ?></p>
        </footer>
    </div>
</body>
</html>