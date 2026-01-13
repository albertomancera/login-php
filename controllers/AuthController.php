<?php
// controllers/AuthController.php

class AuthController
{
    private $userModel; // Propiedad para almacenar la instancia del modelo de Usuario

    public function __construct()
    {
        $this->userModel = new Usuario(); // Inicializa el modelo Usuario para poder acceder a la base de datos
    }

    public function login()
    {
        include 'views/login.php'; // Carga la vista del formulario de login
    }

    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Verifica que los datos vengan por el método POST
            
            // 1. Verificar Token CSRF (Seguridad añadida anteriormente)
            // Compara el token del formulario con el de la sesión para evitar ataques CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $_SESSION['error'] = "Error de seguridad (Token inválido)."; // Guarda el error en sesión
                header('Location: index.php?action=login'); // Redirige al login
                exit(); // Detiene la ejecución del script
            }

            // 2. CONTROL DE INTENTOS (Lógica traída de autenticacion.php)
            if (!isset($_SESSION['intentos'])) { // Si no existe el contador de intentos...
                $_SESSION['intentos'] = 0; // ...lo inicializa a 0
            }

            // Si supera 5 intentos, bloqueamos
            if ($_SESSION['intentos'] >= 5) { // Comprueba si se alcanzó el límite de intentos
                $_SESSION['error'] = "Has superado el número máximo de intentos (5). Inténtalo más tarde."; // Mensaje de bloqueo
                header('Location: index.php?action=login'); // Redirige al login
                exit(); // Detiene la ejecución
            }

            // 3. Recoger datos
            // Usamos htmlspecialchars como en tu archivo de ejemplo para sanitizar entrada básica
            // Limpia el usuario (quita espacios y caracteres especiales)
            $username = isset($_POST['usuario']) ? htmlspecialchars(trim($_POST['usuario'])) : "";
            // Limpia la contraseña (caracteres especiales)
            $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : "";

            // 4. Intentar Login
            // Llama al modelo para verificar usuario y contraseña en la BD
            if ($this->userModel->login($username, $password)) {
                
                // ÉXITO: Reiniciamos el contador de intentos
                $_SESSION['intentos'] = 0; // Resetea el contador al loguearse correctamente

                // Variables de sesión
                $_SESSION['usuario_logueado'] = true; // Marca la sesión como iniciada
                $_SESSION['idusuario'] = $username; // Guarda el nombre de usuario en la sesión
                
                header('Location: index.php?action=dashboard'); // Redirige al panel principal
                exit(); // Detiene la ejecución

            } else {
                // FALLO: Incrementamos contador
                $_SESSION['intentos']++; // Suma 1 al contador de fallos
                
                $restantes = 5 - $_SESSION['intentos']; // Calcula cuántos intentos quedan
                
                // Mensaje dinámico según intentos
                if ($restantes > 0) {
                    $_SESSION['error'] = "Usuario o contraseña incorrectos. Te quedan $restantes intentos."; // Informa al usuario
                } else {
                    $_SESSION['error'] = "Has superado el número máximo de intentos."; // Informa del bloqueo
                }

                header('Location: index.php?action=login'); // Redirige de vuelta al formulario
                exit(); // Detiene la ejecución
            }
        }
    }

    public function dashboard()
    {
        if (!isset($_SESSION['usuario_logueado'])) { // Verifica si el usuario NO está logueado
            header('Location: index.php?action=login'); // Lo manda al login
            exit(); // Detiene la ejecución
        }
        include 'views/inicio.php'; // Si está logueado, muestra la vista de inicio
    }

    public function logout()
    {
        // 1. Vaciar variables de sesión
        $_SESSION = array(); // Borra todos los datos almacenados en la variable $_SESSION

        // 2. PUNTO 4: Borrar la cookie del navegador explícitamente
        // Se debe usar los mismos parámetros con los que se creó
        if (ini_get("session.use_cookies")) { // Comprueba si la sesión usa cookies
            $params = session_get_cookie_params(); // Obtiene los parámetros de la cookie actual
            // Sobrescribe la cookie con tiempo expirado para borrarla del navegador
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // 3. Destruir la sesión en el servidor
        session_destroy(); // Elimina el archivo de sesión en el servidor

        header('Location: index.php?action=login'); // Redirige al usuario al login
        exit(); // Detiene la ejecución
    }
}
?>