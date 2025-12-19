<?php
    // Mantenemos tu lógica PHP intacta
    if (isset($_SESSION['usuario_logueado'])) {
        header("Location: index.php?action=dashboard");
        exit();
    }

    if (empty($_SESSION['csrf_token'])) {
        try {
            $csrf_token = bin2hex(random_bytes(64));
        } catch (Exception $e) {
            $csrf_token = bin2hex(openssl_random_pseudo_bytes(64));
        }
        $_SESSION['csrf_token'] = $csrf_token;
    } else {
        $csrf_token = $_SESSION['csrf_token'];
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Acceso Seguro</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        
        <style>
            body {
                background-color: #f0f2f5;
            }
        </style>
    </head>
    <body>
        <div class="container d-flex justify-content-center align-items-center vh-100">
            <div class="card p-4 rounded-4 shadow-lg border-0" style="max-width: 400px; width: 100%;">
                
                <div class="text-center mb-3 text-primary">
                    <i class="bi bi-shield-lock-fill" style="font-size: 3rem;"></i>
                </div>

                <h3 class="text-center mb-4 fw-bold text-dark">Iniciar Sesión</h3>

                <?php
                    if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        echo '<i class="bi bi-exclamation-triangle-fill me-2"></i>' . $_SESSION['error'];
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '</div>';
                        unset ($_SESSION['error']);
                    }
                ?>

                <form action="index.php?action=authenticate" method="post" id="formulario">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

                    <div class="mb-3">
                        <label for="usuario" class="form-label text-muted small fw-bold">USUARIO</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control bg-light border-start-0 ps-0" id="usuario" name="usuario" placeholder="Introduce tu usuario">
                        </div>
                        <div id="usuarioHelp" class="form-text text-danger" hidden>El usuario es obligatorio.</div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label text-muted small fw-bold">CONTRASEÑA</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-key"></i></span>
                            <input type="password" class="form-control bg-light border-start-0 border-end-0 ps-0" id="password" name="password" placeholder="Introduce tu contraseña">
                            <button class="btn btn-light border border-start-0 text-muted" type="button" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div id="passwordHelp" class="form-text text-danger" hidden>La contraseña es obligatoria.</div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
    <script src="./views/js/validaciones.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordInput.getAttribute('type') === 'password') {
                passwordInput.setAttribute('type', 'text');
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.setAttribute('type', 'password');
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    </script>
</html>