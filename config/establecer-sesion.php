<?php
session_set_cookie_params([
    'lifetime' => 1800, // Vida de la sesión: 30 minutos
    'path' => '/',
    'httponly' => true,
    'samesite' => 'Strict',
]);
session_start();

// --- Regeneración segura del ID de sesión ---
$regenerate_interval = 300; // Regeneración del ID de sesión: 5 minutos
if (!isset($_SESSION['last_regeneration'])) {
    $_SESSION['last_regeneration'] = time();
}
if (time() - $_SESSION['last_regeneration'] >= $regenerate_interval) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}