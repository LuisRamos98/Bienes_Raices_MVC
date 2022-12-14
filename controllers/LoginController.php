<?php

namespace Controllers;

use MVC\Router;
use Model\Admin;


class LoginController {

    static function login(Router $router) {

        $errores = [];

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $auth = new Admin($_POST);

            $errores = $auth->validar();

            if(empty($errores)) {
                // Verificar si el usuario existe
                $resultado = $auth->existeUsuario();

                if(!$resultado) {
                    $errores = Admin::getErrores();
                } else {
                    //Verificar el password
                    $autenticacion = $auth->comprobarPassword($resultado);
                    
                    if($autenticacion) {
                        //Autenticar al usuario
                        $auth->autenticar();
                    } else {
                        $errores =  Admin::getErrores();
                    }                    
                }               
                
            }
         
        }
        
        $router->render("auth/login",[
            "errores" => $errores
        ]);
    }

    static function logout() {
        
        session_start();

        $_SESSION = [];

        header("Location: /");
    }
}