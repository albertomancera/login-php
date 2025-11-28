<?php 
    //Comenzamos una sesión
    session_start(); //pendiente de hacer segura




?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilo opcional para un fondo sutil */
        body {
            background-color: #f0f2f5;
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        
        <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                
                <h3 class="text-center mb-4 text-primary">Bienvenido</h3>
                
                <form action="autenticacion.php" method="post">
                    <!-- aqui se mostraran los errores desde dentro de la aplicacion -->
                    <?php 
                    if(isset($_SESSION['error'])){
                        echo '<div class ="alert alert-danger" role="alert">';
                            echo $_SESSION['error'];
                        echo '</div>';

                        //$_SESSION['error'] == ""; contenido vacio pero la variable sigue "set" (no la destruye)
                        unset($_SESSION['error']); //Desaparece la key y la variable
                    }
                    ?>
                    <div class="mb-3">
                        <label for="usuario" class="form-label fw-bold">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="identificador" placeholder="Ingresa tu usuario" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="********" required>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="checkRecordar">
                        <label class="form-check-label text-secondary" for="checkRecordar">Recordarme</label>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </div>
                </form>

                <div class="mt-3 text-center">
                    <a href="#" class="text-decoration-none text-muted small">¿Olvidaste tu contraseña?</a>
                </div>

            </div>
        </div>
    </div>
    <script src="validaciones.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>