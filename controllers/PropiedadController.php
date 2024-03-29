<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;

use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController {
    // Le pasamos el mismo objeto para no perder la referencia
    public static function index(Router $router){

        $propiedades = Propiedad::all();

        $vendedores = Vendedor::all();

        // Muestra mensaje condicional
        $resultado = $_GET["resultado"] ?? null;

        $router->render("propiedades/admin",[
            "propiedades" => $propiedades,
            "resultado" => $resultado,
            "vendedores" => $vendedores
        ]);
    }
    public static function crear(Router $router){

        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        // Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            /** Crea una nueva Instancia */
            $propiedad = new Propiedad($_POST["propiedad"]);

            /** SUBIDA DE ARCHIVOS */
        
            // Genera un nombre único
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            
            // Setear la imagen si existe
            if($_FILES["propiedad"]["tmp_name"]["imagen"]){
                
                // Realiza un resize a la imagen con Intervention
                $image = Image::make($_FILES["propiedad"]["tmp_name"]["imagen"])->fit(800,600);

                // Solo almacen el nombre en la DB
                $propiedad->setImagen($nombreImagen);
            }

            // Validar
            $errores = $propiedad->validar();


            if(empty($errores)){

                // Crear carpeta de imagenes si no existe
                if(!is_dir(CARPETA_IMAGENES)){
                    mkdir(CARPETA_IMAGENES);
                }

                //Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);

                // Guarda en la DB
                $propiedad->guardar();
                
            }
        }

        $router->render("propiedades/crear", [
            "propiedad" => $propiedad,
            "vendedores" => $vendedores,
            "errores" => $errores
        ]);
    }


    public static function actualizar(Router $router){
        
        $id = validarORediccionar("/admin/");
        $propiedad = Propiedad::find($id);

        $vendedores = Vendedor::all();
        
        $errores = Propiedad::getErrores();

        // Metodo post para actualizar
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            // Asignar los atributos
            $args = $_POST["propiedad"];
    
            $propiedad->sincronizar($args);
    
            // Validación
            $errores = $propiedad->validar();
            
            // Subida de archivos
    
            // Genera un nombre único
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
    
            if($_FILES["propiedad"]["tmp_name"]["imagen"]){
    
                // Realiza un resize a la imagen con Intervention
                $image = Image::make($_FILES["propiedad"]["tmp_name"]["imagen"])->fit(800,600);
    
                // Solo almacen el nombre en la DB
                $propiedad->setImagen($nombreImagen);
            }
    
            if(empty($errores)){
                if($_FILES["propiedad"]["tmp_name"]["imagen"]){
                    // Almacenar la imagen
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
    
                $propiedad->guardar();
            }
        }

        $router->render("propiedades/actualizar", [
            "propiedad" => $propiedad,
            "errores" => $errores,
            "vendedores" => $vendedores
        ]);
    }


    public static function eliminar(){
        if($_SERVER["REQUEST_METHOD"] === "POST"){
        
            // Validar id
            $id = $_POST["id"];    
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if($id){
    
                $tipo = $_POST["tipo"];
    
                if(validarTipoContenido($tipo)){
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
            }
        }
    }
}