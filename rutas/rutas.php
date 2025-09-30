<?php

$arrayRutas = explode("/", $_SERVER['REQUEST_URI']);

$idx = 4;
// $response = Helper::retornaRespuesta( 500, true, 'TEST1', array_filter($arrayRutas));

if(count(array_filter($arrayRutas)) == $idx - 1 ) {
    
    /*=============================================
    Cuando no se hace ninguna petición a la API
    =============================================*/
    $response = Helper::retornaRespuesta( 500, true, 'Ruta no válida');

} else {

    if ( array_filter($arrayRutas)[$idx] == "usuarios" ) {
        
        if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {

            if ( count(array_filter($arrayRutas) ) == $idx ) {

                /*==============================================
                    Obtener todos los usuarios
                ==============================================*/
                $response = Helper::retornaRespuesta( 404, true, 'Metodo no implementado aún');

            } else if ( count(array_filter($arrayRutas) ) == $idx + 1 && is_numeric(array_filter($arrayRutas)[$idx + 1 ]) ) {

                /*==============================================
                    Obtener un solo usuario
                ==============================================*/
                $response = Helper::retornaRespuesta( 404, true, 'Metodo no implementado aún');

            } else {
                $response = Helper::retornaRespuesta( 404, true, 'Ruta no válida');
            }


        } else if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

            if ( array_filter($arrayRutas)[$idx + 1 ] == "update") {

                /*==============================================
                    Actualizar
                ==============================================*/
                $datos = array( 
                    "usuarioId"=>$_POST["usuarioId"],
                    "nombre"=>$_POST["nombre"],
                    "direccion"=>$_POST["direccion"],
                    "correo"=>$_POST["correo"],
                    "telefono"=>$_POST["telefono"],
                    "fechaRegistro"=>$_POST["fechaRegistro"],
                );
                
                // return $response = Helper::retornaRespuesta( 404, true, 'Metodo no implementado aún', $datos);
                
                $update = new ControladorUsuarios();
                $update -> update($datos);

            } 

        } else if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {


        } else if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {

        }

    } else if ( array_filter($arrayRutas)[$idx] == "productos" ) {
        
        if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {

            if ( count(array_filter($arrayRutas) ) == $idx ) {

                /*==============================================
                    Obtener todos los productos
                ==============================================*/
                $productos = new ControladorProductos();
                $productos -> index();

            } else if ( count(array_filter($arrayRutas) ) == $idx + 1 && is_numeric(array_filter($arrayRutas)[$idx + 1 ]) ) {

                /*==============================================
                    Obtener un solo producto
                ==============================================*/

                $producto = new ControladorProductos();
                $producto -> show(array_filter($arrayRutas)[ $idx + 1 ]);

            } else if ( count(array_filter($arrayRutas) ) == $idx + 1 ) {

                /*==============================================
                    Obtener productos por categorias
                ==============================================*/

                $categoria = new ControladorProductos();
                $categoria -> categoria( array_filter($arrayRutas)[$idx + 1 ] );

            } else {
                $response = Helper::retornaRespuesta( 404, true, 'Ruta no válida');
            }

        } else if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

        } else if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {

        } else if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {

        }

    } else if ( array_filter($arrayRutas)[$idx] == "compras" ) {
        
        if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {

            if ( count(array_filter($arrayRutas) ) == $idx ) {

                /*==============================================
                    Obtener todas las compras
                ==============================================*/

            } else if ( count(array_filter($arrayRutas) ) == $idx + 1 && is_numeric(array_filter($arrayRutas)[$idx + 1 ]) ) {

                /*==============================================
                    Obtener una compra
                ==============================================*/

            } else if ( count(array_filter($arrayRutas) ) == $idx + 1 ) {

            } else {
                $response = Helper::retornaRespuesta( 404, true, 'Ruta no válida');
            }
            
        } else if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
            
            if ( array_filter($arrayRutas)[$idx + 1 ] == "realizar" ) {
                
                $ids = explode( ',', $_POST['ids'] );
                $cantidades = explode( ',', $_POST['cantidades'] );

                $datos = array (
                    'usuarioId' => $_POST['usuarioId'] ,
                    'ids' => $ids,
                    'cantidades' => $cantidades,
                    'total' => $_POST['total'],
                    'transactionId' => $_POST['transactionId']
                );

                // $response = Helper::retornaRespuesta( 404, true, 'Compras POST', $datos );
                

                $realizarCompra = new ControladorCompras();
                $realizarCompra -> create($datos);

            } else {
                $response = Helper::retornaRespuesta( 404, true, 'Ruta no válida');
            }




        } else if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {

        } else if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {

        }

    } else if ( array_filter($arrayRutas)[$idx] == "login" ) {

        /*=============================================
        Login
        =============================================*/
        
        if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

            $datos = array( "correo"=>$_POST["correo"], "password"=>$_POST["password"] );

            $login = new ControladorUsuarios();
            $login -> login($datos);

        }else{
            $response = Helper::retornaRespuesta( 500, true, 'Ruta no válida');
        }

    }  else if ( array_filter($arrayRutas)[$idx] == "registro" ) {
            
        if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
            
            /*=============================================
            Capturar datos
            =============================================*/

            $datos = array( "nombre"=>$_POST["nombre"],
                            "correo"=>$_POST["correo"],
                            "password"=>$_POST["password"],
                            "rol"=>$_POST["rol"],
                            "status"=>$_POST["status"],
                        );


            $registro = new ControladorUsuarios();
            $registro -> create($datos);

        } else {
            $response = Helper::retornaRespuesta( 500, true, 'Ruta no válida');
        }

    } else {
        $response = Helper::retornaRespuesta( 404, true, 'Ruta no válida' );
    }
}
return $response;