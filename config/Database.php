<?php
// config/Database.php
class Database
{
    private $host = 'localhost'; // Define la dirección del servidor de base de datos (local)
    private $db_name = 'login-php'; // Define el nombre de la base de datos a la que conectar
    private $username = 'root'; // Define el nombre de usuario para acceder a la base de datos
    private $password = ''; // Define la contraseña del usuario (vacía por defecto en XAMPP)
    private $port = '3307'; // Define el puerto específico de MySQL (útil si no usas el 3306)

    public $PDO; // Variable pública que almacenará el objeto de conexión activo

    public function getConnection()
    {
        $this->PDO = null; // Inicializa la conexión como nula antes de intentar conectar
        try {
            // Construye la cadena de conexión (DSN) con host, puerto, nombre de BD y codificación
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8";
            
            $this->PDO = new PDO($dsn, $this->username, $this->password); // Crea la instancia de PDO intentando conectar
            $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configura PDO para lanzar excepciones si hay errores
            
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage(); // Captura y muestra el mensaje si falla la conexión
        }
        return $this->PDO; // Retorna el objeto de conexión (o null si falló)
    }
}