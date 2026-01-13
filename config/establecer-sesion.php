<?php
// config/establecer-sesion.php

// Configura los parámetros de seguridad de la cookie de sesión (antes de iniciarla)
session_set_cookie_params([
    'lifetime' => 0,        // La cookie expira al cerrar el navegador
    'path' => '/',          // Disponible en todo el sitio
    'domain' => '',         // Dominio actual (localhost)
    'secure' => true,       // Solo se envía por HTTPS (false si usas http://localhost)
    'httponly' => true,     // No accesible vía JavaScript (protege contra XSS)
    'samesite' => 'Strict', // Solo se envía en peticiones del mismo sitio (protege contra CSRF)
]);

session_start(); // Inicia o reanuda la sesión existente

// Define el tiempo máximo absoluto de vida de la sesión (independiente de la actividad)
$limite_absoluto = 7200; // 7200 segundos equivalen a 2 horas

// Verifica si la sesión existe y si ha superado el tiempo límite desde su creación
if (isset($_SESSION['created_at']) && (time() - $_SESSION['created_at'] > $limite_absoluto)) {
    session_unset();    // Limpia las variables de sesión
    session_destroy();  // Destruye la sesión en el servidor
    // Redirige al login con un parámetro de timeout
    header("Location: index.php?action=login&timeout=1");
    exit(); // Detiene la ejecución del script
}

// Si es la primera vez que se crea la sesión, guardamos la marca de tiempo
if (!isset($_SESSION['created_at'])) {
    $_SESSION['created_at'] = time(); // Guarda el momento actual
}

// Intervalo para rotar el ID de sesión (seguridad contra fijación de sesión)
$regenerate_interval = 300; // 5 minutos en segundos

// Inicializa la marca de tiempo de regeneración si no existe
if (!isset($_SESSION['last_regeneration'])) {
    $_SESSION['last_regeneration'] = time();
}

// Si ha pasado el tiempo de intervalo, regeneramos el ID
if (time() - $_SESSION['last_regeneration'] >= $regenerate_interval) {
    session_regenerate_id(true); // Genera nuevo ID y borra el archivo de sesión viejo
    $_SESSION['last_regeneration'] = time(); // Actualiza el contador
}
?>