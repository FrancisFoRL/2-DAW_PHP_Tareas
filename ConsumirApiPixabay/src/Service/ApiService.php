<?php

namespace App\Service;

use App\Images\Imagen;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();

$busqueda="almeria";

define("URL", $_ENV['URL_BASE'].$_ENV['API_KEY'].$_ENV['IMAGE'].$busqueda);

class ApiService{
    public function getImagen() : array{
        $imagenes=[];
        $datos = file_get_contents(URL);
        $datosJson = json_decode($datos);
        $datosImagenes = $datosJson->hits;

        foreach($datosImagenes as $ObjImg){
            $imagenes[]=(new Imagen)
            ->setImagen($ObjImg->largeImageURL)
            ->setAutor($ObjImg->user)
            ->setLikes($ObjImg->likes);
        }
        return $imagenes;
    }
}