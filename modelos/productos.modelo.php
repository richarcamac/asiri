<?php 

require_once "conexion.php";

class ModeloProductos{

	/*=============================================
	Mostrar todos los productos
	=============================================*/

	static public function index($tabla) {

        try{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            
            $stmt -> execute();
    
            return $stmt->fetchAll(PDO::FETCH_CLASS);
            
        } catch (PDOException $ex) {
            return 'Hubo un error al realizar la consulta: '.$ex->getMessage();
        }
            
	    $stmt -> close();

	    $stmt = null;

    }

	/*=============================================
	Mostrar un solo producto
	=============================================*/

	static public function show($tabla, $id){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE productoId = :productoId");

		$stmt -> bindParam(":productoId", $id, PDO::PARAM_INT);

		try {

			$stmt -> execute();
			return $stmt -> fetch();
			
		} catch (PDOException $ex) {
            return 'Hubo un error al realizar la consulta: '.$ex->getMessage();
        }



	    $stmt -> close();

	    $stmt -= null;

	}

	/*=============================================
	Mostrar productos por categoria
	=============================================*/

	static public function categoria($tabla, $categoria) {

        if ( $categoria == 'destacados' ) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE destacado = 1");
			
        } else if ( $categoria == '+vendidos' ) {

            $stmt = Conexion::conectar()->prepare(" SELECT a.productoId, SUM(a.cantidad), b.*
                                                    FROM compraDetalle a
                                                    INNER JOIN productos b ON (a.productoId = b.productoId )
                                                    GROUP BY a.productoId
                                                    ORDER BY SUM(a.cantidad) DESC
													LIMIT 5");

			// SELECT productoId, SUM(cantidad) FROM `compraDetalle` GROUP BY productoId ORDER BY SUM(cantidad) DESC
        } else {
			
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE categoria = :categoria");
            $stmt -> bindParam(":categoria", $categoria, PDO::PARAM_STR);
		}
		
		try {

			$stmt -> execute();
			return $stmt -> fetchAll(PDO::FETCH_CLASS);

		} catch (PDOException $ex) {
            return 'Hubo un error al realizar la consulta: '.$ex->getMessage();
        }


	    $stmt -> close();

	    $stmt -= null;

	}
}