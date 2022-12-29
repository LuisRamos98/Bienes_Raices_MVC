<?php

namespace MVC;

class Router {

    public $rutasPrivadas = [];

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn) {
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn) {
        $this->rutasPOST[$url] = $fn;
    }

    public function comprobarRutas(){

        session_start();
        $auth = $_SESSION["login"] ?? null;

        //Arreglo de rutas privadas
        $rutasPrivadas = ["/admin", "/propiedades/crear", "/propiedades/actualizar", "/propiedades/eliminar", 
                          "/vendedores/crear", "/vendedores/actualizar", "/vendedores/eliminar"];

        $urlActual = $_SERVER["PATH_INFO"] ?? $_SERVER["REQUEST_URI"];
        $metodo = $_SERVER["REQUEST_METHOD"];
        if($metodo === "GET") {
           $fn = $this->rutasGET[$urlActual] ?? null; 
        } else {
            $fn = $this->rutasPOST[$urlActual] ?? null;      
        }


        //Proteger Rutas
        if(in_array($urlActual,$rutasPrivadas) && !$auth) {
            header("Location: /");
        }

        if ($fn) {
            #si existe la funcion
            call_user_func($fn,$this);

        } else {
            echo "Página No Encontrada";
        }
    }

    public function render($view, $datos = []) {

        foreach($datos as $key => $value) {
            $$key = $value;
        }

        ob_start(); //Almacenamiento en memoria por un momento
        include_once __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); // Limpia el buffer
        include_once __DIR__ . "/views/layout.php";
    }
}