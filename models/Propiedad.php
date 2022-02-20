<?php

namespace Model;

class Propiedad extends ActiveRecord{

    protected static $tabla = "propiedades";

    protected static $columnasDB = ["id", "titulo", "precio", "imagen", "descripcion", "habitaciones", "wc", "estacionamiento", "creado", "vendedorId"];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

    public function __construct($args = []){

        $this->id = $args["id"] ?? NULL;
        $this->titulo = $args["titulo"] ?? "";
        $this->precio = $args["precio"] ?? "";
        $this->imagen = $args["imagen"] ?? "";
        $this->descripcion = $args["descripcion"] ?? "";
        $this->habitaciones = $args["habitaciones"] ?? "";
        $this->wc = $args["wc"] ?? "";
        $this->estacionamiento = $args["estacionamiento"] ?? "";
        $this->creado = date("Y/m/d");
        $this->vendedorId = $args["vendedorId"] ?? "";
    }

    public function validar(){
        if(!$this->titulo){
            self::$errores[] = "Debes añadir un titulo.";
        }
        if(!$this->precio){
            self::$errores[] = "El Precio es Obligatorio.";
        }
        if(strlen($this->descripcion) < 50){
            self::$errores[] = "La Descripcion es Obligatoria y debe tener al menos 50 caracteres.";
        }
        if(!$this->habitaciones){
            self::$errores[] = "El Número de Habitaciones es Obligatorio.";
        }
        if(!$this->wc){
            self::$errores[] = "El Número de Baños es Obligatorio.";
        }
        if(!$this->estacionamiento){
            self::$errores[] = "El Número de Estacionamientos es Obligatorio.";
        }
        if(!$this->vendedorId){
            self::$errores[] = "Elige un Vendedor.";
        }

        if(!$this->imagen){
            self::$errores[] = "La Imagen es de la propiedad es obligatoria";
        }

        return self::$errores;
    }

}