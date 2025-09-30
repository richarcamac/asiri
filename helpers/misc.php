<?php

class Helper {

    public static function retornaRespuesta( $responseCode, $error, $mensaje, $data = null, $total = null ) {
        
        $respuesta = array(
            http_response_code($responseCode),
            'error' => $error,
            'mensaje' => $mensaje,
            'data' => $data,
            'total' => $total
          );

        echo json_encode($respuesta);
            
    }
}

