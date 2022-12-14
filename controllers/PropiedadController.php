<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController {

    public static function index(Router $router ) {

        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all(); 
        $resultado = $_GET["resultado"]??null;

        $router->render("propiedades/admin", [
            "propiedades" => $propiedades,
            "vendedores" => $vendedores,
            "resultado" => $resultado
        ]);
    }

    public static function crear(Router $router) {

        $propiedad = new Propiedad; 
        $vendedores = Vendedor::all();        
        //Arreglo de mensajes de errores
        $errores = Propiedad::getErrores();

        if($_SERVER["REQUEST_METHOD"] === "POST"){

                /**CREAMOS UNA NUEVA INSTANCIA**/
            $propiedad = new Propiedad($_POST["propiedad"]);
            
            /**SUBIDA DE ARCHIVOS**/
            //CREAR UN NOMBRE UNICO PARA LA IMAGEN
            $nombreImagen = md5(uniqid(rand(),true)) . ".jpg";
            //SETEAMOS LA IMAGEN
            //Realiza un resize a la imagen con intervation
            if($_FILES["propiedad"]["tmp_name"]["imagen"]) {
                $image = Image::make($_FILES["propiedad"]["tmp_name"]["imagen"])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }
            //VALIDAMOS
            $errores = $propiedad->validar();        
            //Debemos revisar si nuestro arreglo de erroes esté vacío
            if (empty($errores)) {

                // CREAR LA CARPETA EN DONDE VAMOS A GUARDAR LAS IMGENES            
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }
            
                //Asignar files hacia una variable
                $imagen = $_FILES["imagen"];
                
                //Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);

                $propiedad->guardar();
            }

        }


        $router->render("propiedades/crear",[
            "propiedad" => $propiedad,
            "vendedores" => $vendedores,
            "errores" => $errores
        ]);
    }

    public static function actualizar(Router $router) {
        $id = validarORedireccionar("/admin"); 
        $propiedad = Propiedad::find($id);
        $vendedor = Vendedor::all();

        // debugear($vendedor);

        $errores = Propiedad::getErrores();

        if($_SERVER["REQUEST_METHOD"] === "POST"){

            //Asignamos los atributos
            $args = $_POST["propiedad"];
    
            $propiedad->sincronizar($args);
    
            /**SUBIDA DE ARCHIVOS**/
            //CREAR UN NOMBRE UNICO PARA LA IMAGEN
            $nombreImagen = md5(uniqid(rand(),true)) . ".jpg";
            //SETEAMOS LA IMAGEN
            //Realiza un resize a la imagen con intervation
            if($_FILES["propiedad"]["tmp_name"]["imagen"]) {
                $image = Image::make($_FILES["propiedad"]["tmp_name"]["imagen"])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }
    
            //Validamos
            $errores = $propiedad->validar();
    
            if (empty($errores)) {
                        //Realiza un resize a la imagen con intervation
                if($_FILES["propiedad"]["tmp_name"]["imagen"]) {
                    //Almacenar las imagenes en el disco
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
    
                $propiedad->guardar();
            }
    
        }

        $router->render("propiedades/actualizar", [
            "propiedad" => $propiedad,
            "errores" => $errores,
            "vendedores" => $vendedor
        ]);
        
    }

    public static function eliminar() {
        if($_SERVER["REQUEST_METHOD"]==="POST") {
            $id = $_POST["id"]; 
            $id = filter_var($id,FILTER_VALIDATE_INT);
    
    
            if ($id) {
                $tipo = $_POST["tipo"];
                if(validarTipoContenido($tipo)){                
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
            }
        }
    }

}