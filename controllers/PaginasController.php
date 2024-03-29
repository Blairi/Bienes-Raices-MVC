<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController{
    public static function index( Router $router ){

        $propiedades = Propiedad::get(3);
        $inicio = true;

        $router->render("paginas/index", [
            "propiedades" => $propiedades,
            "inicio" => $inicio
        ]);
    }

    public static function nosotros(Router $router){
        $router->render("paginas/nosotros", []);
    }

    public static function propiedades(Router $router){

        $propiedades = Propiedad::all();

        $router->render("paginas/propiedades", [
            "propiedades" => $propiedades
        ]);
    }

    public static function propiedad(Router $router){

        $id = validarORediccionar("/propiedades");

        // Buscar la propiedad por id
        $propiedad = Propiedad::find($id);

        $router->render("paginas/propiedad", [
            "propiedad" => $propiedad
        ]);
    }

    public static function blog(Router $router){
        $router->render("paginas/blog", []);
    }

    public static function entrada(Router $router){
        $router->render("paginas/entrada", []);
    }

    public static function contacto(Router $router){

        $mensaje = null;

        if($_SERVER["REQUEST_METHOD"] === "POST"){

            $respuestas = $_POST["contacto"];
            
            // Crear una nueva instancia de PHPMailer
            $mail = new PHPMailer();

            // Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '527672c9ae1331';
            $mail->Password = 'e85b4e1fdd44ed';
            $mail->SMTPSecure = 'tls';
            $mail->Port = '2525';

            // Configurar el contenido del email
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', "BienesRaices.com");
            $mail->Subject = 'Tienes Un Nuevo Mensaje';

            // Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            // Definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje xd</p>';
            $contenido .= '<p>Nombre: ' . $respuestas["nombre"] . ' </p>';
            
            // Enviar de forma condicional algunos campos de email o teléfono
            if($respuestas["contacto"] === "telefono"){
                $contenido .= "<p>Eligió ser contactado por teléfono</p>";
                $contenido .= '<p>Teléfono: ' . $respuestas["telefono"] . ' </p>';
                $contenido .= '<p>Fecha Contacto: ' . $respuestas["fecha"] . ' </p>';
                $contenido .= '<p>Hora: ' . $respuestas["hora"] . ' </p>';
            }
            else{
                // Es email, campo de email
                $contenido .= "<p>Eligió ser contactado por email</p>";
                $contenido .= '<p>Email: ' . $respuestas["email"] . ' </p>';
            }
            
            $contenido .= '<p>Mensaje: ' . $respuestas["mensaje"] . ' </p>';
            $contenido .= '<p>Vende o Compra: ' . $respuestas["tipo"] . ' </p>';
            $contenido .= '<p>Precio o presupuesto: $' . $respuestas["precio"] . ' </p>';

            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = "Esto es texto alternativo sin HTML";

            // Enviar el email
            if($mail->send()){
                $mensaje = "Mensaje Enviado Correctamente";
            }
            else{
                $mensaje = "Error en mandar Mensaje";
            }

        }

        $router->render("paginas/contacto",[
            'mensaje' => $mensaje
        ]);

    }
}