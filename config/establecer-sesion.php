<?php
// config/establecer-sesion.php

// PUNTOS 2 y 6: Seguridad de cookies y expiración
session_set_cookie_params([
    'lifetime' => 0,        // La cookie dura hasta que se cierra el navegador
    'path' => '/',
    'domain' => '',         // Tu dominio (localhost o el que sea)
    'secure' => true,       // Pon false si estás en localhost SIN https
    'httponly' => true,     // Inaccesible para JS
    'samesite' => 'Strict', // Protección CSRF extra
]);

session_start();

// --- PUNTO 7: Tiempo límite absoluto de sesión (2 horas) ---
// Esto asegura que la sesión muera a las 2 horas aunque el usuario siga activo
$limite_absoluto = 7200; // 2 horas en segundos

if (isset($_SESSION['created_at']) && (time() - $_SESSION['created_at'] > $limite_absoluto)) {
    session_unset();
    session_destroy();
    // Redirigimos con un mensaje de timeout
    header("Location: index.php?action=login&timeout=1");
    exit();
}

// Si es una sesión nueva, marcamos cuándo se creó
if (!isset($_SESSION['created_at'])) {
    $_SESSION['created_at'] = time();
}

// --- PUNTO 7: Regeneración periódica (Anti-Fixation) ---
$regenerate_interval = 300; // 5 minutos
if (!isset($_SESSION['last_regeneration'])) {
    $_SESSION['last_regeneration'] = time();
}
if (time() - $_SESSION['last_regeneration'] >= $regenerate_interval) {
    session_regenerate_id(true); // true borra la sesión antigua
    $_SESSION['last_regeneration'] = time();
}
?>