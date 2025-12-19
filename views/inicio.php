<?php
    session_start();

    if (!isset($_SESSION['idusuario'])) {
        // Lo mandamos de vuelta al login (ajusta la ruta si tu login está en otro lado)
        header("Location: ../index.php"); 
        exit(); // Detenemos la ejecución del script
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard - Inicio</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        
        <style>
            body {
                background-color: #f0f2f5;
            }
        </style>
    </head>
    <body>

        <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow mb-5">
            <div class="container">
                <a class="navbar-brand fw-bold" href="#">
                    <i class="bi bi-shield-lock-fill me-2"></i>LOGIN-MVC
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav align-items-center gap-3">
                        <li class="nav-item">
                            <div class="d-flex align-items-center text-white">
                                <i class="bi bi-person-circle me-2"></i>
                                <span class="me-1 opacity-75">Usuario:</span> 
                                <span class="fw-bold"><?php echo htmlspecialchars($_SESSION['idusuario']); ?></span>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?action=logout" class="btn btn-light btn-sm px-3 text-primary fw-bold">
                                <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg border-0 mb-5 rounded-4">
                        <div class="card-header bg-white border-bottom-0 p-4">
                            <h5 class="mb-0 text-primary fw-bold"><i class="bi bi-speedometer2 me-2"></i>Panel de Control</h5>
                        </div>
                        <div class="card-body p-5 text-center">
                            
                            <div class="mb-4">
                                <div class="d-inline-block p-4 rounded-circle bg-primary bg-opacity-10 mb-3">
                                    <i class="bi bi-person-workspace display-1 text-primary"></i>
                                </div>
                                <h2 class="fw-bold text-dark">¡Bienvenido de nuevo!</h2>
                                <p class="lead text-muted">
                                    Hola, <strong class="text-primary"><?php echo htmlspecialchars($_SESSION['idusuario']); ?></strong>.
                                </p>
                            </div>
                            
                            <div class="alert alert-success d-flex align-items-center justify-content-center border-0 shadow-sm" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <div>
                                    Has iniciado sesión correctamente en el sistema.
                                </div>
                            </div>

                        </div>
                        <div class="card-footer bg-light border-top-0 text-muted text-center small py-3 rounded-bottom-4">
                            Alberto Mancera Plaza
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>