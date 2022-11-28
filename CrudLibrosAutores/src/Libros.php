<?php

namespace Src;

use PDO;
use PDOException;

class Libros extends Conexion{

    private int $id;
    private string $nombre;
    private string $isbn;
    private string $categoria;
    private string $descripcion;
    private string $portada;
    private string $autor_id;

    public function __construct(){
        parent::__construct();
    }

    //_____________Grud__________________

    public function create(){
        $q="insert into Libros (nombre, isbn, categoria, descripcion, portada, autor_id) values (:n , :i, :c, :d, :p, :a)";
        $stmt = parent::$conexion->prepare($q);

        try{
            $stmt->execute([
                ':n' => $this->nombre,
                ':i' => $this->isbn,
                ':c' => $this->categoria,
                ':d' => $this->descripcion,
                ':p' => $this->portada ?? 'img/libros/default.png',
                ':a' => $this->autor_id
            ]);
        }catch(PDOException $ex){
            die("Error en crear Libros: ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->rowCount();
    }

    public function read(){
        $q="select * from libros where id = :i";
        $stmt = parent::$conexion->prepare($q);
        try{
            $stmt->execute([":i" => $this->id]);
        }catch(PDOException $ex){
            die("Error en read Libros:".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function update($id){
        $q="update libros set nombre = :n, isbn = :is, categoria = :c, descripcion = :d , portada = :p, autor_id = :a where id = :i";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':n' => $this->nombre,
                ':is' => $this->isbn,
                ':c' => $this->categoria,
                ':d' => $this->descripcion,
                ':p' => $this->portada ?? 'img/libros/default.png',
                ':a' => $this->autor_id,
                ':i' => $id
            ]);
        }catch(PDOException $ex){
            die("Error en update libros: ".$ex->getMessage());
        }
        parent::$conexion=null;
    }

    public static function delete($id){
        parent::crearConexion();
        $q="delete from libros where id = :i";
        $stmt = parent::$conexion->prepare($q);
        try{
            $stmt->execute([':i'=>$id]);
        }catch(PDOException $ex){
            die("Error en delete Libros: ").$ex->getMessage();
        }
        parent::$conexion=null;
    }

    public static function readAll(?int $mode=null){
        parent::crearConexion();
        $q=($mode == null)?"select * from libros order by id":"select nombre, id from libros order by id";
        $stmt = parent::$conexion->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error en readAll Libros: ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function readDetalle($id){
        parent::crearConexion();
        $q="select libros.*, autores.nombre, foto from libros, autores where autores.id = autor_id and libros.id = :i";
        $stmt = parent::$conexion->prepare($q);
        try{
            $stmt->execute([":i"=>$id]);
        }catch(PDOException $ex){
            die("Error en readDetalle: ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    //__________Otros Metodos___________

    public static function crearLibros($cant){
        if(self::hayLibros()) return;
        $faker = \Faker\Factory::create("es_ES");
        $ids= Autores::devolverIds();
        for($i=0; $i<$cant; $i++){
            (new Libros)
            ->setNombre($faker->unique()->name(20))
            ->setIsbn($faker->unique()->isbn13())
            ->setCategoria($faker->randomElement(['Cuentos', 'Humor', 'Aventuras', 'Suspense', 'Ciencia Ficcion', 'Romantica']))
            ->setDescripcion($faker->sentence())
            ->setPortada('img/libros/default.png')
            ->setAutor_Id($faker->randomElement($ids))
            ->create();
        }
    }

    public static function hayLibros(){
        parent::crearConexion();
        $q="select id from libros";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error en hayLibros: ". $ex->getMessage);
        }
        parent::$conexion=null;
        return $stmt->rowCount();
    }

    public static function getCategorias(){
        return ['Cuentos', 'Humor', 'Aventuras', 'Suspense', 'Ciencia Ficcion', 'Romantica'];
    }

    public static function exiteId($id){
        parent::crearConexion();
        $q = "select id from libros where id = :i";
        $stmt = parent::$conexion->prepare($q);
        try{
            $stmt->execute([':i' => $id]);
        }catch(PDOException $ex){
            die("Erro en existeID libros:".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->rowCount();
    }

    //__________Setters________________

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Set the value of isbn
     *
     * @return  self
     */ 
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Set the value of categoria
     *
     * @return  self
     */ 
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Set the value of autor_id
     *
     * @return  self
     */ 
    public function setAutor_id($autor_id)
    {
        $this->autor_id = $autor_id;

        return $this;
    }


    /**
     * Set the value of portada
     *
     * @return  self
     */ 
    public function setPortada($portada)
    {
        $this->portada = $portada;

        return $this;
    }
}