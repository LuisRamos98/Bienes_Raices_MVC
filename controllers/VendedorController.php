<?php 

namespace Controllers;
use MVC\Router;
use Model\Vendedor;

class VendedorController {

    public static function crear ( Router $router) {
        
        $vendedor = new Vendedor;
        $vendedor = Vendedor::all();
        //Arreglo de mensajes de errores
        $errores = Vendedor::getErrores();

        if($_SERVER["REQUEST_METHOD"] === "POST"){

            /**CREAMOS UNA NUEVA INSTANCIA**/
            $vendedor = new Vendedor($_POST["vendedor"]);
            // debugear($vendedor);
            $errores = $vendedor->validar();
            //Debemos revisar si nuestro arreglo de erroes esté vacío
            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render("vendedores/crear",[
            "vendedor" => $vendedor,
            "errores" => $errores
        ]);
    }

    public static function actualizar(Router $router) {
        $id = validarORedireccionar("/admin");
        $vendedor = Vendedor::find($id);
        
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            //ASIGNAMOS LOS ATRIBUTOS
            $args = $_POST["vendedor"];

            $vendedor->sincronizar($args);

            /* Validamos */
            $errores = $vendedor->validar();

            if(empty($errores)) {
                $vendedor->guardar();
            }

        }

        $router->render("vendedores/actualizar",[
            "vendedor" => $vendedor,
            "errores" => $errores
        ]);
    }

    public static function eliminar() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {

            $id = $_POST["id"];
            $id = filter_var($id, FILTER_VALIDATE_INT);


            if($id) {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }

        }
    }
    

}