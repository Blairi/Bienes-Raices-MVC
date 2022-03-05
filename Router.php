<?php

namespace MVC;

class Router{

    public $rutasGET = [];
    public $rutasPOST =[];

    public function get($url, $fn){
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn){
        $this->rutasPOST[$url] = $fn;
    }


    public function comprobarRutas(){

        session_start();

        $auth = $_SESSION["login"] ?? null;

        //Areglo de rutas protegidas...
        $rutas_protegidas = ["/admin/", "/propiedades/crear", "/propiedades/actualizar", "/propiedades/eliminar", "/vendedores/crear", "/vendedores/actualizar", "/vendedores/eliminar"];

        $urlActual = $_SERVER["PATH_INFO"] ?? "/";
        $metodo = $_SERVER["REQUEST_METHOD"];

        if($metodo === "GET"){
            $urlActual = explode("?", $urlActual)[0];
            $fn = $this->rutasGET[$urlActual] ?? null;
        }
        else{
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }

        // Proteger las rutas
        if(in_array($urlActual, $rutas_protegidas) && !$auth){
            header("Location: /");
        }

        // La URL existe y hay una función asociada
        if($fn){
            // Nos permite llamar una funcion cunado no sabemos como se va llamar esa funcion
            call_user_func($fn, $this);
        }
        else{
            echo "Página no encontrada";
        }
    }

    // Muestra una vista
    public function render($view, $datos = []){

        foreach ($datos as $key => $value) {
            $$key = $value;
        }

        //Iniciar almacenamiento en memoria
        ob_start();

        include __DIR__ . "/views/$view.php";
        // Limpiamos memoria
        $contenido = ob_get_clean();
        include __DIR__ . "/views/layout.php";
    }
    
}