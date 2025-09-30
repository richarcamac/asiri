<?php 

class ControladorUsuarios{

	/*=============================================
	Crear un registro
	=============================================*/

	public function create($datos) {

		/*=============================================
		Validar nombre
		=============================================*/

		if(isset($datos['nombre']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos['nombre'])){
            $response = Helper::retornaRespuesta( 404, true, 'Error en el campo nombre, sólo se permiten letras');
            return $response;
        }

		/*=============================================
		Validar correo
		=============================================*/

		if(isset($datos['correo']) && !preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $datos['correo'])){
            $response = Helper::retornaRespuesta( 404, true, 'Error en el campo email, coloca un email válido');
            return $response;
		}

		/*=============================================
		Validar que el email no esté repetido
		=============================================*/

		$usuarios  = ModeloUsuarios::index('usuarios');
		
		foreach ($usuarios as $key => $value) {
			
			if($value['correo'] == $datos['correo']){
                $response = Helper::retornaRespuesta( 404, true, 'Este correo ya existe en la base de datos');
                return $response;
			}
        }
        
		/*=============================================
		Llevar datos al modelo
		=============================================*/

		$datos = array("nombre"=>$datos["nombre"],
                        "correo"=>$datos["correo"],
                        "password"=>$datos["password"],
                        "status"=>$status,
                        "rol"=>$rol
                        );
        
        $create = ModeloUsuarios::create("usuarios", $datos);
        
        /*=============================================
        Respuesta del modelo
        =============================================*/
        
        if($create == "ok"){
            $response = Helper::retornaRespuesta( 200, true, 'Usuario creado con exito');
            return $response;
        } else {
            $response = Helper::retornaRespuesta( 500, true, 'Hubo un error en la consulta', $create);
            return $response;
        }
	}
	
	/*=============================================
	Editar un usuario
	=============================================*/

	public function update($datos) {


		/*=============================================
		Validar que el usuario exista
		=============================================*/
		
		$usuarios  = ModeloUsuarios::index('usuarios');
		$existe = false;

		for ($i=0; $i < count($usuarios); $i++) {
			if ( $usuarios[$i]['usuarioId'] == $datos['usuarioId'] ) {
                $existe = true;
			}
		}

		// return $response = Helper::retornaRespuesta( 404, true, $datos, $usuarios[1]['usuarioId']);

		if ( $existe ) {
			
			/*=============================================
			Llevar datos al modelo
			=============================================*/
	
			$update = ModeloUsuarios::update("usuarios", $datos);
			
			/*=============================================
			Respuesta del modelo
			=============================================*/
			
			if($update == "ok"){
				$response = Helper::retornaRespuesta( 200, false, 'Actualizado con éxito', $datos);
				return $response;  	
			}
		} else {
			$response = Helper::retornaRespuesta( 404, true, 'Este usuario no existe en la base de datos');
			return $response;
		}
		

	}

	/*=============================================
	Login de usuarios
	=============================================*/

	public function login($datos) {

		/*=============================================
		Validar correo
		=============================================*/
		if(isset($datos['correo']) && !preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $datos['correo'])){
            $response = Helper::retornaRespuesta( 404, true, 'Error en el campo email, coloca un email válido');
            return $response;
		}
        
		/*=============================================
		Llevar datos al modelo
		=============================================*/

		$datos = array( "correo"=>$datos["correo"],
                        "password"=>$datos["password"]);
        
        $login = ModeloUsuarios::login("usuarios", $datos);
    }
}