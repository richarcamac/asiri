<?php 

class ControladorCompras{

	/*=============================================
	Mostrar todos los registros
	=============================================*/

	public function index() {

        $compras = ModeloCompras::index("compras");

        return Helper::retornaRespuesta( 200, true, 'compras', $compras, count($compras));
        
    }

	/*=============================================
	Mostrar un solo compra
	=============================================*/
	public function show($id){

        $compra = ModeloCompras::show( 'compras', $id );

        if ( $compra ) {
            return Helper::retornaRespuesta( 200, true, 'Compras', $compra);
        } else {
            return Helper::retornaRespuesta( 200, true, 'Esta compra no existe');
        }

	}

	/*=============================================
	Crear un registro
	=============================================*/

	public function create($datos) {
        
		/*=============================================
		Llevar datos al modelo
		=============================================*/

		$datos = array (
            'usuarioId' => $datos['usuarioId'] ,
            'ids' => $datos['ids'],
            'cantidades' => $datos['cantidades'],
            'total' => $datos['total'],
            'transactionId' => $datos['transactionId']
        );
        
        $create = ModeloCompras::create("compras", $datos);
        
        /*=============================================
        Respuesta del modelo
        =============================================*/
        
        if($create == "ok"){
            $response = Helper::retornaRespuesta( 200, true, 'Compras realizada con exito');
            return $response;
        } else {
            $response = Helper::retornaRespuesta( 500, true, 'Hubo un error en la consulta', $create);
            return $response;
        }
	}

}