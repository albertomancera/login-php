<?php 
    session_start(); //pendiente de hacer segura 

    if(isset($_POST['identificador'])){

    //Inicialización de parametros de conexion
    $host = "localhost";
    $usuario = "root";          //inseguro *****
    $password = "";             //inseguro *****
    $database = "login-php";
    

    //Establecimiento de la conexión
    $mysqli = new mysqli($host,$usuario,$password,$database);

    if($mysqli -> connect_error){
        $_SESSION['error'] = "No se puede comprobar usuario en estos momentos. Vuelve a intenarlo";
        header('Location: index.php');

    }

    $usuario = $_POST['identificador'];
    $password = $_POST['password'];
    
    
    echo $usuario . " y " . $password;

    }else{
        $_SESSION['error'] = "Debes hacer login para acceder";
    }



?>