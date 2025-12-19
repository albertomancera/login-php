<?php
require_once 'config/Database.php';                      // Importa el archivo Database.php para poder usar la clase de conexión

class Usuario
{
    private $PDO; // Variable privada para guardar el objeto de conexión a la base de datos
    private $tabla_nombre = "usuarios";                 // Define el nombre de la tabla donde están los usuarios

    public function __construct()
    {
        $database = new Database();                    // Crea una instancia de la clase Database
        $this->PDO = $database->getConnection();       // Llama al método getConnection() y guarda la conexión activa en $this->PDO
    }

    // Método para verificar usuario y contraseña
    public function login($idusuario, $password)      // Función pública que recibe usuario y contraseña para validar
    {                                                 
        // Define la consulta SQL: selecciona todo (*) de la tabla usuarios donde el campo idusuario coincida con el parámetro (?)
        $query = "SELECT * FROM " . $this->tabla_nombre . " WHERE idusuario = ? LIMIT 0,1";
        
        $stmt = $this->PDO->prepare($query); // Prepara la consulta en la base de datos (seguridad contra inyección SQL)
        $stmt->bindParam(1, $idusuario); // Vincula el primer parámetro (?) con la variable $idusuario
        
        $stmt->execute(); // Ejecuta la consulta preparada

        $num = $stmt->rowCount(); // Cuenta cuántas filas devolvió la consulta (0 si no existe, 1 si existe)

        if ($num > 0) { // Si se encontró al menos un registro...
            $row = $stmt->fetch(PDO::FETCH_ASSOC); // ...obtiene los datos de la fila como un array asociativo
            
            // Compara la contraseña ingresada (texto plano) con el hash encriptado de la base de datos
            if (password_verify($password, $row['password'])) {
                return $row; // Si coinciden, devuelve los datos del usuario (Login correcto)
            }
        }
        return false; // Si no existe el usuario o la contraseña es incorrecta, devuelve false
    }
}
?>