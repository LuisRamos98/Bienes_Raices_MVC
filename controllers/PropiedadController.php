<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;

class PropiedadController {

    public static function index(Router $router ) {
        $router->render("propiedades/admin", [
            "mensaje" => "Desde la vista",
            "propiedades" => [1,2,3,4],
        ]);
    }

    public static function crear() {
        echo "Crear Propiedad";
    }

    public static function actualizar() {
        echo "Actualizar Propiedad";
    }

}