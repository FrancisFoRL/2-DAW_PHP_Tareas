<?php

session_start();

use Src\Libros;

require __DIR__."/../../vendor/autoload.php";

if(!isset($_POST['libro'])){
    header("Location:index.php)");
    die();
}

$libro = unserialize($_POST['libro']);

if(!Libros::exiteId($libro->id)){
    header("Location:index.php)");
    die();
}

if(basename($libro->portada) != "default.png"){
    unlink("..".$libro->portada);
}

Libros::delete($libro->id);
$_SESSION['mensaje'] = "Libro eliminado con exito";
header("Location:index.php");