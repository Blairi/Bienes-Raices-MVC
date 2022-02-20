<?php

namespace Model;

class ActiveRecord{
    // Base de Datos
    // Para no instanciarla cada vez que la usemos
    // usamos static
    protected static $db;

    protected static $columnasDB = [""];

    protected static $tabla = "";

    // Validación
    protected static $errores = [];

    // Definir la conexión a la DB
    public static function setDB($database){
        self::$db = $database;
    }

    public function guardar(){
        if(!is_null($this->id)){
            // Actualizar
            $this->actualizar();
        }else{
            // Creando un nuevo registro
            $this->crear();
        }
    }

    public function crear(){

        // Sanitizar los datos
        $atributos = $this->sanitizarDatos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " '); ";


        // Al ya estar definido tenemos acceso a los metodos del objeto mysqli
        $resultado = self::$db->query($query);
        
        if($resultado){
            // Rediccionerando al usuario.
            header("Location: /admin?resultado=1");
        }

    }

    public function actualizar(){
        // Sanitizar los datos
        $atributos = $this->sanitizarDatos();
        $valores = [];
        foreach($atributos as $key => $value){
            $valores[] = "{$key}='{$value}'";
        }

        $query = " UPDATE " . static::$tabla ." SET ";
        $query .=  join(", ", $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado){
            // Rediccionerando al usuario.
            header("Location: /admin?resultado=2");
        }
        
    }

    // Eliminar un registro
    public function eliminar(){
        $query = "DELETE FROM " . static::$tabla ." WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado){
            $this->borrarImagen();
            // Rediccionerando al usuario.
            header("Location: /admin?resultado=3");
        }
    }

    public function atributos() : array {
        $atributos = [];
        foreach(static::$columnasDB as $columna){
            if($columna === "id"){ continue; } 
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarDatos() : array{
        $atributos = $this->atributos();
        $satinizado = [];


        foreach ($atributos as $key => $value) {
            $satinizado[$key] = self::$db->escape_string($value);
        }

        return $satinizado;
    }

    // Suiba de archivos
    public function setImagen($imagen){
        // Eliminar la imagen previa
        if( !is_null($this->id) ){
            $this->borrarImagen();
        }

        // Asignar al atributo de imagen el nombre de la imagen
        if($imagen){
            $this->imagen = $imagen;
        }
    }

    // Eliminar el archivo
    public function borrarImagen(){
        // Comprobar su existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if($existeArchivo){
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    // Validación
    public static function getErrores(){
        return static::$errores;
    }

    public function validar(){
        static::$errores = [];
        return static::$errores;
    }

    // Lista todos los registros
    public static function all(){
        // static busca el atributo en la clase que se esta heredando
        $query = "SELECT * FROM " . static::$tabla;


        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // Obtiene determinado número de registros
    public static function get($cantidad){
        // static busca el atributo en la clase que se esta heredando
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id){
        $query = "SELECT * FROM " . static::$tabla ." WHERE id = ${id}";

        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }


    public static function consultarSQL($query){
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array[] = static::crearObjeto($registro);
        }

        // Liberar la memoria
        $resultado->free();

        // Retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro){
        $objeto = new static;
        foreach($registro as $key => $value){
            if( property_exists($objeto, $key) ){
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar( $args = [] ){
        foreach ($args as $key => $value) {

            if(property_exists($this, $key) 
            && !is_null($value)){

                $this->$key = $value;

            }
        }
    }
}