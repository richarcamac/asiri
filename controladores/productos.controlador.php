<?php 

class ControladorProductos{

	/*=============================================
	Mostrar todos los registros
	=============================================*/

	public function index() {

        $productos = ModeloProductos::index("productos");

        return Helper::retornaRespuesta( 200, true, 'Productos', $productos, count($productos));
        
    }

	/*=============================================
	Mostrar un solo producto
	=============================================*/
	public function show($id){

        $producto = ModeloProductos::show( 'productos', $id );

        if ( $producto ) {
            return Helper::retornaRespuesta( 200, true, 'Producto', $producto);
        } else {
            return Helper::retornaRespuesta( 200, true, 'Este producto no existe');
        }

	}

	/*=============================================
	Mostrar productos por categoria
	=============================================*/
	public function categoria($categoria){

        $productos = ModeloProductos::categoria( 'productos', $categoria );

        if ( $productos ) {
            return Helper::retornaRespuesta( 200, true, 'Productos', $productos, count( $productos ));
        } else {
            return Helper::retornaRespuesta( 200, true, 'No hay productos que cumplan con este criterio');
        }

	}

}