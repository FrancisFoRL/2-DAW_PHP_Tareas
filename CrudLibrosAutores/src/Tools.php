<?php

namespace Src;

class Tools {

    private static $categoria = ['Cuentos', 'Humor', 'Aventuras', 'Suspense', 'Ciencia Ficcion', 'Romantica'];
    private static $images = ['image/png', 'image/jpg', 'image/webp', 'image/tiff', 'image/ico', 'image/bmp', 'image/jpeg'];

    public static function getCategoria()
    {
        return self::$categoria;
    }

    public static function getImages()
    {
        return self::$images;
    }
}
