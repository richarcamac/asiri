<?php 

require_once "conexion.php";

class ModeloUsuarios{

	/*=============================================
	Mostrar todos los registros
	=============================================*/

	static public function index($tabla) {

    try {
      
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
  
      $stmt -> execute();
  
      return $stmt -> fetchAll();
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

        $status =  isset( $datos['status'] ) ? $datos['status'] : '1';
        $rol =  isset( $datos['rol'] ) ? $datos['rol'] : 'USER';
        $password = password_hash($datos['password'], PASSWORD_BCRYPT, ['cost' => 4]);

        try {

            $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, correo, password, rol, status)
                        VALUES (:nombre, :correo, :password, :rol, :status)");
    
            $stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $stmt -> bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
            $stmt -> bindParam(":password", $password, PDO::PARAM_STR);
            $stmt -> bindParam(":rol", $rol, PDO::PARAM_STR);
            $stmt -> bindParam(":status", $status, PDO::PARAM_STR);
            $stmt -> execute();

            return 'ok';

        } catch (PDOException $ex) {
             return 'Hubo un error al realizar la consulta: '.$ex->getMessage();
        }
        
        $stmt-> close();
        $stmt = null;

    }

    /*=============================================
    Actualización de un usuario
    =============================================*/
  
    static public function update($tabla, $datos) {
      

      try {

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre=:nombre, direccion=:direccion, correo=:correo, telefono=:telefono WHERE usuarioId = :usuarioId");
    
        $stmt -> bindParam(":usuarioId", $datos["usuarioId"], PDO::PARAM_INT);
        $stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt -> bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt -> bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
        $stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);

        $stmt -> execute();
        return "ok";
        
      } catch (PDOException $ex) {
        return 'Hubo un error al realizar la consulta: '.$ex->getMessage();
      }
  
      $stmt-> close();
  
      $stmt = null;
  
    }
    
	/*=============================================
	Login
	=============================================*/

	static public function login($tabla, $datos) {

        try {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios  WHERE correo = :correo");
    
            $stmt -> bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
            
            $stmt -> execute();

        } catch (PDOException $ex) {
             return Helper::retornaRespuesta( 500, true, 'Hubo un error al realizar la consulta: '.$ex->getMessage());
        }

        $login_ok = false;
        
        $row = $stmt->fetch();
        
        if($row){

            $password = $datos['password'];
            
            $verify = password_verify($password, $row['password']);
      
          if($verify){
      
            if( $row['status'] === '0') {
                return Helper::retornaRespuesta( 400, true, 'Tu cuenta a sido suspendida, por favor contacta con el administrador.');
            } else {
      
              $login_ok = true;
      
            }
      
          }
        }

        if($login_ok){
      
          unset($row['password']);
      
          date_default_timezone_set('America/Monterrey');
      
          $ultimoIngreso = date('Y-m-d H:i:s');
          $usuarioId = $row['usuarioId'];

          
          try{
            
            $stmt = Conexion::conectar()->prepare("UPDATE usuarios SET ultimoIngreso = :ultimoIngreso WHERE usuarioId = :usuarioId");
            
            $stmt -> bindParam(":usuarioId", $usuarioId, PDO::PARAM_STR);
            $stmt -> bindParam(":ultimoIngreso", $ultimoIngreso, PDO::PARAM_STR);
            
            $stmt -> execute();
            
            return Helper::retornaRespuesta( 200, false, 'Login correcto', $row);
      
          } catch(PDOException $ex){
            return Helper::retornaRespuesta( 500, true, 'Hubo un error al realizar la consulta: '.$ex->getMessage());
          }
          return $row;
      
        } else{
      
          return Helper::retornaRespuesta( 401, true, 'Usuario y/o contraseña incorrectos' );
        }

        $stmt-> close();
        $stmt = null;

    }


}