<?php
// config/Database.php
class Database
{
    private $host = 'localhost';
    private $db_name = 'login-php'; // Asegúrate de que este nombre sea exacto al de phpMyAdmin
    private $username = 'root';
    private $password = ''; // En XAMPP suele estar vacía
    private $port = '3307'; // <--- AQUÍ ES DONDE FORZAMOS EL PUERTO DE XAMPP

    public $PDO;

    public function getConnection()
    {
        $this->PDO = null;
        try {
            // Fíjate que añadimos ";port=" . $this->port a la cadena de conexión
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8";
            
            $this->PDO = new PDO($dsn, $this->username, $this->password);
            $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->PDO;
    }
}