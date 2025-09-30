<?php 

require_once "conexion.php";

class ModeloCompras{

	/*=============================================
	Mostrar todos los compras
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
	Mostrar un solo compra
	=============================================*/

	static public function show($tabla, $id){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE compraId = :compraId");

		$stmt -> bindParam(":compraId", $id, PDO::PARAM_INT);

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
	Crear un registro
	=============================================*/

	static public function create($tabla, $datos) {

        $tablaDetalle = 'compraDetalle';

        try {

            $pdo = Conexion::conectar();
            
            $query = $pdo -> prepare("INSERT INTO $tabla( transactionId, usuarioId, total)
                        VALUES ( :transactionId, :usuarioId, :total )" );
    
            $query -> bindParam(":usuarioId", $datos["usuarioId"], PDO::PARAM_STR);
            $query -> bindParam(":transactionId", $datos["transactionId"], PDO::PARAM_STR);
            $query -> bindParam(":total", $datos["total"], PDO::PARAM_STR);
            
            $query -> execute();
            
            $lastID = $pdo -> lastInsertId();
            // $response = Helper::retornaRespuesta( 200, true, 'LastId', $lastID );

            for ( $i=0; $i < count( $datos['ids'] ); $i++ ) {

                try {

                    $stmt = Conexion::conectar()->prepare("INSERT INTO $tablaDetalle( compraId, productoId, cantidad )
                                VALUES ( :compraId, :productoId, :cantidad )" );
            
                    $stmt -> bindParam(":compraId", $lastID, PDO::PARAM_STR);
                    $stmt -> bindParam(":productoId", $datos["ids"][$i], PDO::PARAM_STR);
                    $stmt -> bindParam(":cantidad", $datos["cantidades"][$i], PDO::PARAM_STR);
                    
                    $stmt -> execute();

                } catch (PDOException $ex) {
                    return 'Hubo un error al realizar la consulta: '.$ex->getMessage();
                }
            }
            return 'ok';

        } catch (PDOException $ex) {
             return 'Hubo un error al realizar la consulta: '.$ex->getMessage();
        }
        
        $stmt-> close();
        $stmt = null;

    }
}