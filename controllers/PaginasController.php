<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;
 
class PaginasController {
    
    public static function index(Router $router) {
    
        $propiedades = Propiedad::get(3);

        $inicio = true;
        
        $router->render("paginas/index",[
            "propiedades" => $propiedades,
            "inicio" => $inicio
        ]);
    }

    public static function nosotros(Router $router) {
        $router->render("paginas/nosotros");
    }

    public static function propiedades(Router $router) {
        
        $propiedades = Propiedad::all();

        $router->render("paginas/propiedades",[
            "propiedades" => $propiedades
        ]);
    }

    public static function propiedad(Router $router) {

        $id = validarORedireccionar("/propiedad");
        
        $propiedad = Propiedad::find($id);

        $router->render("paginas/propiedad",[
            "propiedad" => $propiedad
        ]);
        
    }

    public static function blog(Router $router) {
        $router->render("paginas/blog");
    }

    public static function entrada(Router $router) {
        $router->render("paginas/entrada");
    }

    public static function contacto(Router $router) {

        $mensaje = null;
        $error = null;

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $respuestas = $_POST["contacto"];

            // debugear($respuestas);

            //Creamos una instancia de phpmailer
            $mail = new PHPMailer();

            //Configurar el SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '6131ce6d119fa2';
            $mail->Password = '6c58d3d944a899';
            $mail->SMTPSecure = 'tls';

            //Configurar el contenido del email
            $mail->setFrom("admin@bienesraices.com");
            $mail->addAddress("admin@bienesraices.com","BienesRaices.com");
            $mail->Subject = "Tienes un nuevo mensaje";
            
            //Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = "UTF-8";

            //Definir contenido
            $contenido = '<html> <p> Tienes un nuevo mensaje </p>';
            $contenido .= '<p> Nombre: '. $respuestas["nombre"] . ' </p>';

            //Enviar de forma condicional algunos campos email o telefono
            if($respuestas["contacto"] === "telefono") {
                $contenido .= '<p> *** Eligió se contactado por teléfono *** </p>';
                $contenido .= '<p> Teléfono: '. $respuestas["telefono"] . ' </p>';
                $contenido .= '<p> Fecha: '. $respuestas["fecha"] . ' </p>';
                $contenido .= '<p> Hora: '. $respuestas["hora"] . ' </p>';
            } else {
                $contenido .= '<p> *** Eligió se contactado por email *** </p>';
                $contenido .= '<p> Email: '. $respuestas["email"] . ' </p>';
            }
            
            $contenido .= '<p> Mensaje: '. $respuestas["mensaje"] . ' </p>';
            $contenido .= '<p> Precio o Presupuesto: $'. $respuestas["presupuesto"] . ' </p>';
            $contenido .= '</html>';


            $mail->Body = $contenido;
            $mail->AltBody = "Esto es texto alternativo sin HTML";

            //Enviar mail
            if($mail->send()) {
                $mensaje = "Mensaje enviado Correctamente";
                
            } else {
                $error = "El mensaje no se pudo enviar";
            }


        }

        $router->render("paginas/contacto", [
            "mensaje" => $mensaje,
            "error" => $error
        ]);
    }
}