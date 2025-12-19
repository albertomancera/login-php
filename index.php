<?php
error_reporting(0); // Desactiva la visualización de errores en pantalla (útil para producción, aunque en desarrollo es mejor E_ALL)

require_once 'controllers/AuthController.php';  // Importa el controlador que maneja la lógica de autenticación
require_once 'models/User.php';                 // Importa el modelo de Usuario para interactuar con la BD
																								// (MVC: Modelo-Vista-Controlador)
// Iniciar sesión de forma segura
require_once './config/establecer-sesion.php'; // Configura e inicia la sesión (cookies seguras, timeouts, etc.) antes de cualquier lógica

$controller = new AuthController();  // Instancia el controlador principal para manejar las peticiones

// ENRUTAMIENTO (Front Controller): Decide qué hacer según la URL
if (!isset($_REQUEST['action'])) {             // Si no hay ninguna acción en la URL (ej: entras directo a index.php)...
    $controller->login();                      // ...muestra el formulario de login por defecto
} else {
    switch ($_REQUEST['action']) {             // Evalúa el parámetro 'action' que viene por GET o POST
        case 'login':
            $controller->login();              // Muestra la vista de login
            break;
        case 'authenticate':
            $controller->authenticate();      // Procesa el formulario de login (verifica credenciales)
            break;
        case 'dashboard':
            $controller->dashboard();         // Muestra el panel principal (solo si está logueado)
            break;
        case 'logout':
            $controller->logout();            // Cierra la sesión y redirige al login
            break;
        default:
            $controller->login();             // Si la acción no existe o es incorrecta, vuelve al login por seguridad
            break;
    }
}

?>