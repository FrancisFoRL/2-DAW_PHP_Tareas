<?php

session_start();

use Src\Autores;

require __DIR__."/../../vendor/autoload.php";

if(!isset($_POST['autor'])){
    header("Location:index.php");
    die();
}

$autor = unserialize($_POST['autor']);

if(!Autores::existeId($autor->id)){
    header("Location:index.php");
    die();
}

if(basename($autor->foto) != "default.png"){
    unlink("..".$autor->foto);
}

Autores::delete($autor->id);
$_SESSION['mensaje'] = "Autor eliminado con exito";
header("Location:index.php");
