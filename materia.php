<?php
require('conexion.php');

function buscarMateria() {
    $cn = getConexion();  

    try {
        $stm = $cn->query("SELECT * FROM materia");
        $rows = $stm->fetchAll(PDO::FETCH_ASSOC);

    } catch(Exception $ex){
        // print_r($ex);
    }
    
    $data=[];
    foreach ($rows as $row){
        $data[]= [
            "id" => $row["id"],
            "nombre" =>$row["nombre"],
            "creditos" =>$row["creditos"]
        ];
    }

    // print_r($data);

    header("Content-Type: application/json",true);
    $data = json_encode($data);
    echo $data;

}

function guardarMateria() {
    $postdata=file_get_contents("php://input");
    $data= json_decode($postdata, true);
    $cn= getConexion();
    //$stm= $pdo->prepare("INSERT INTO carrera(nombre) VALUE (:nombre)");
    $stm= $cn->prepare("INSERT INTO materia (id, nombre, creditos) VALUE (:id, :nombre, :creditos)");
    $stm->bindparam(":id",$data["id"]);
    $stm->bindparam(":nombre",$data["nombre"]);
    $stm->bindparam(":creditos",$data["creditos"]);
    $data=$stm->execute();
        echo'Guardar Materia';
    }

$method= $_SERVER["REQUEST_METHOD"];
switch ($method) {
    case 'POST':
        guardarMateria();
        break;
    case 'GET':
        buscarMateria();
        break;
    case 'DELATE':
    case 'PUT':
    default:
        echo'TO BE IMPLEMENTED'; 
    }  






// // error_reporting(E_ALL | E_STRICT);
// // ini_set('display_errors', 1);

// try {
//     $pdo = new PDO("mysql:host=localhost; dbname=universidad;","root", "password");
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     // $stm = $pdo->query("SELECT VERSION()");
//     // $version = $stm->fetch();
//     // echo $version[0] . PHP_EOL;

//     $nombre = "Educacion Fisica";
//     $creditos = "3";
//    //$edad = "30";

//     $stm = $pdo->prepare("INSERT INTO materia (nombre, creditos) VALUES (:nombre,:creditos)");
//     $stm->bindParam(":nombre", $nombre);
//     $stm->bindParam(":creditos", $creditos);
//     //$stm->bindParam(":edad", $edad);

//     $data = $stm->execute();
//     print_r($data);

//     echo "Datos actualizado";
// } catch (PDOException $e){
//     echo $e->getMessage();
//}