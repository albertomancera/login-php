<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 Diagnóstico de Conexión</h1>";

$host = 'localhost';
$user = 'root';
$pass = ''; // Dejamos la contraseña vacía como suele ser en XAMPP
$db_name = 'login-php'; // El nombre de tu base de datos

function intentar_conectar($puerto, $host, $user, $pass, $db) {
    echo "<hr><h3>Probando puerto: $puerto...</h3>";
    try {
        $dsn = "mysql:host=$host;port=$puerto;dbname=$db;charset=utf8";
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<h2 style='color:green'>✅ ¡CONEXIÓN EXITOSA en el puerto $puerto!</h2>";
        echo "<p>Tu base de datos '$db' existe y el usuario es correcto.</p>";
        echo "<p><strong>SOLUCIÓN:</strong> Asegúrate de que en tu archivo Database.php uses <code>private \$port = '$puerto';</code></p>";
        return true;
    } catch (PDOException $e) {
        echo "<h4 style='color:red'>❌ Falló en el puerto $puerto</h4>";
        echo "<strong>Mensaje de error:</strong> " . $e->getMessage() . "<br>";
        
        if (strpos($e->getMessage(), 'Unknown database') !== false) {
            echo "<br>⚠️ <strong>¡OJO!</strong> El error dice 'Unknown database'. Significa que la conexión funciona, pero <strong>no has creado la base de datos '$db'</strong> todavía en phpMyAdmin.";
        }
        if (strpos($e->getMessage(), 'Access denied') !== false) {
            echo "<br>⚠️ <strong>Pista:</strong> El usuario o la contraseña están mal, o este puerto requiere contraseña.";
        }
        return false;
    }
}

// 1. Probar el puerto modificado (XAMPP alternativo)
intentar_conectar(3307, $host, $user, $pass, $db_name);

// 2. Probar el puerto estándar (MySQL normal)
intentar_conectar(3306, $host, $user, $pass, $db_name);

echo "<hr><p>Fin del diagnóstico.</p>";
?>