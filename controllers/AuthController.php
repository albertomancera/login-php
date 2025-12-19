<?php
// controllers/AuthController.php

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new Usuario();
    }

    public function login()
    {
        include 'views/login.php';
    }

    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // 1. Verificar Token CSRF (Seguridad añadida anteriormente)
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $_SESSION['error'] = "Error de seguridad (Token inválido).";
                header('Location: index.php?action=login');
                exit();
            }

            // 2. CONTROL DE INTENTOS (Lógica traída de autenticacion.php)
            if (!isset($_SESSION['intentos'])) {
                $_SESSION['intentos'] = 0;
            }

            // Si supera 5 intentos, bloqueamos
            if ($_SESSION['intentos'] >= 5) {
                $_SESSION['error'] = "Has superado el número máximo de intentos (5). Inténtalo más tarde.";
                header('Location: index.php?action=login');
                exit();
            }

            // 3. Recoger datos
            // Usamos htmlspecialchars como en tu archivo de ejemplo para sanitizar entrada básica
            $username = isset($_POST['usuario']) ? htmlspecialchars(trim($_POST['usuario'])) : "";
            $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : "";

            // 4. Intentar Login
            if ($this->userModel->login($username, $password)) {
                
                // ÉXITO: Reiniciamos el contador de intentos
                $_SESSION['intentos'] = 0;

                // Variables de sesión
                $_SESSION['usuario_logueado'] = true;
                $_SESSION['idusuario'] = $username;
                
                header('Location: index.php?action=dashboard');
                exit();

            } else {
                // FALLO: Incrementamos contador
                $_SESSION['intentos']++;
                
                $restantes = 5 - $_SESSION['intentos'];
                
                // Mensaje dinámico según intentos
                if ($restantes > 0) {
                    $_SESSION['error'] = "Usuario o contraseña incorrectos. Te quedan $restantes intentos.";
                } else {
                    $_SESSION['error'] = "Has superado el número máximo de intentos.";
                }

                header('Location: index.php?action=login');
                exit();
            }
        }
    }

    public function dashboard()
    {
        if (!isset($_SESSION['usuario_logueado'])) {
            header('Location: index.php?action=login');
            exit();
        }
        include 'views/inicio.php';
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: index.php?action=login');
        exit();
    }
}