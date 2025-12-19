<?php
require_once 'config/Database.php';                      // incluimos el código de conexión a la BD

class Usuario
{
    private $PDO;
    private $tabla_nombre = "usuarios";                 // Tu tabla de usuarios

    public function __construct()
    {
        $database = new Database();                    // aquí se invoca al constructor Database, que crea la conexión
        $this->PDO = $database->getConnection();       // y se almacena en el objeto usuario, cuando se invoca su constructor
    }

    // Método para verificar usuario y contraseña
    public function login($idusuario, $password)      // para un objeto usuario, se puede invocar el método login()
    {                                                 // si tuviéramos registro, también se declararía un método para ello...
        // Modificamos la query para buscar solo por usuario, la contraseña se verifica después con el hash
        $query = "SELECT * FROM " . $this->tabla_nombre . " WHERE idusuario = ? LIMIT 0,1";
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(1, $idusuario);
        // Ya no vinculamos la contraseña aquí porque compararemos el hash en PHP
        $stmt->execute();

        $num = $stmt->rowCount(); 

        if ($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Aquí usamos password_verify para comparar la contraseña plana con el hash de la BD
            if (password_verify($password, $row['password'])) {
                return $row; // Devuelve los datos del usuario
            }
        }
        return false; // Usuario no encontrado
    }
}
?>