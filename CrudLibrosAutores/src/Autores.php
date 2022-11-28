<?php

namespace Src;

use PDO;
use PDOException;

class Autores extends Conexion{

    private int $id;
    private string $nombre;
    private string $apellidos;
    private string $fecha_nacimiento;
    private string $foto;

    public function __construct(){
        parent::__construct();
    }


//________________Grud____________________
public function create(){
    $q="insert into autores (nombre,apellidos, fecha_nacimiento, foto) values (:n, :a, :fn, :f)";
    $stmt=parent::$conexion->prepare($q);

    try{
        $stmt->execute([
            ":n" => $this->nombre,
            ":a" => $this->apellidos,
            ":fn" => $this->fecha_nacimiento,
            ":f" => $this->foto ?? 'img/autores/default.png'
        ]);
    }catch(PDOException $ex){
        die("Error en crear Autores: ".$ex->getMessage);
    }
    parent::$conexion=null;
    return $stmt->rowCount();
}

public function read(){
    $q = "select * from autores where id = :i";
    $stmt=parent::$conexion->prepare($q);
    try{
        $stmt->execute([
            ":i" => $this->id
        ]);
    }catch(PDOException $ex){
        die("Error en read Autores: ".$ex->getMessage);
    }
    return $stmt->fetch(PDO::FETCH_OBJ);
}

public function update($id){
    $q = "update autores set nombre=:n, apellidos=:a, fecha_nacimiento=:fn, foto=:f where id=:i";
    $stmt=parent::$conexion->prepare($q);
    try{
        $stmt->execute([
            ":n" => $this->nombre,
            ":a" => $this->apellidos,
            ":fn" => $this->fecha_nacimiento,
            ":f" => $this->foto,
            ":i" => $id
        ]);
    }catch(PDOException $ex){
        die("Error en update Autores: ".$ex->getMessage());
    }
}

public static function delete($id){
    parent::crearConexion();
    $q="delete from autores where id = :i";
    $stmt = parent::$conexion->prepare($q);
    try{
    $stmt->execute([':i'=>$id]);
    }catch(PDOException $ex){
        die("Error en delete: ".$ex->getMessage());
    }
    parent::$conexion=null;
}

public static function readAll(?int $modo=null){
    parent::crearConexion();
    $q= ($modo == null )?"select * from autores order by id" : "select id, nombre from autores order by id";
    $stmt=parent::$conexion->prepare($q);
    try{
        $stmt->execute();
    }catch(PDOException $ex){
        die("Error en readAll: ".$ex->getMessage);
    }
    parent::$conexion=null;
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

//_____________Otros Metodos______________
public function crearAutor($cant){
    if(self::hayAutores()) return;
    $faker = \Faker\Factory::create("es_ES");
    for($i=0; $i<$cant; $i++){
        (new Autores)
        ->setNombre($faker->firstname)
        ->setApellidos($faker->lastname)
        ->setFecha_nacimiento($faker->date('Y-m-d'))
        ->setFoto('img/autores/default.png')
        ->create();
    }
    parent::$conexion=null;
}

public static function hayAutores(){
    parent::crearConexion();
    $q="select id from autores";
    $stmt=parent::$conexion->prepare($q);
    try{
        $stmt->execute();
    }catch(PDOException $ex){
        die("Error en hayAutores: ".$ex->getMessage);
    }
    parent::$conexion=null;
    return $stmt->rowCount();
}

public static function devolverIds(){
    parent::crearConexion();
    $q="select id from autores";
    $stmt=parent::$conexion->prepare($q);
    try{
        $stmt->execute();
    }catch(PDOException $ex) {
        die("Error en devolverIds: ".$ex->getMessage);
    }
    parent::$conexion=null;
    return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
}

public static function existeId($id){
    parent::crearConexion();
    $q="select id from autores where id = :i";
    $stmt=parent::$conexion->prepare($q);
    try{
        $stmt->execute([':i'=>$id]);
    }catch(PDOException $ex){
        die("Error en existeId: ".$ex->getMessage);
    }
    parent::$conexion=null;
    return $stmt->rowCount();
}

//_____________Setters____________________
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Set the value of fecha_nacimiento
     *
     * @return  self
     */ 
    public function setFecha_nacimiento($fecha_nacimiento)
    {
        $this->fecha_nacimiento = $fecha_nacimiento;

        return $this;
    }

    /**
     * Set the value of foto
     *
     * @return  self
     */ 
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }
}