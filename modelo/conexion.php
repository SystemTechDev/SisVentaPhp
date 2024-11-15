<?php 
session_start();
if(!isset($_SESSION['idusuario'])){
    if(!isset($_POST['proceso'])){
        header("Location: ../index.php");
    }else{
        if($_POST['proceso']!="LOGIN"){
            header("Location: ../index.php");
        }
    }
}
$manejador = "mysql";
$servidor = "localhost";
$usuario = "root"; // usuario con acceso a la base de datos, generalmente root
$pass = "";// aquí coloca la clave de la base de datos del servidor o hosting
$base = "system_integrado"; //nombre de la base de datos
$cadena = "$manejador:host=$servidor;dbname=$base";

$cnx = new PDO($cadena, $usuario, $pass,  array(PDO::ATTR_PERSISTENT => "true", PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

//probando conexion
/*
$resultado = $cnx->query("SELECT * FROM opcion");

foreach($resultado as $k=>$v){
    echo $v['idopcion'].'-'.$v['descripcion'].'-'.$v['url'].'<br/>';
}
*/
?>