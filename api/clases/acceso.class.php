<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';


class acceso extends conexion {

    public function login($json){
      
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

        if(!isset($datos['correo']) || !isset($datos["password"])){
            //error
            return $_respuestas->error_400();
        }else{


            //verificamos los datos enviados
            
            $correo = $datos['correo'];
            $password = $datos['password'];
            $datos = $this->obtenerDatosUsuario($correo);

            //si hay datos de la consulta obtener datos
            if($datos){

                 if($password == $datos[0]['password']){

                    //crear el token
                                $verificar  = $this->insertarToken($datos[0]['id_usuario']);
                                if($verificar){
                                        // si se guardo el token
                                        $result = $_respuestas->response;
                                        $result["result"] = array(
                                            "token" => $verificar,
                                            "rol" => $datos[0]['rol'],
                                            "permiso" => $datos[0]['permiso'],
                                            "id_permiso" => $datos[0]['id_permiso']

                                        );
                                        return $result;
                                }else{
                                        //error al guardar
                                        return $_respustas->error_500("Error interno, No hemos podido guardar el token");
                                }

                 }else{
                    //la contraseña no es igual
                        return $_respuestas->error_200("El password es invalido");
                 }

            }else{

                 return $_respuestas->error_200("El usuaro $correo no existe ");

            }

        }
    }



//obtenemos con el correo los datos del usuario
    private function obtenerDatosUsuario($correo){
        $query = "SELECT * FROM usuarios 
                   INNER JOIN roles ON usuarios.id_rol=roles.id_rol 
                   INNER JOIN permisos ON roles.id_permiso=permisos.id_permiso 
                   WHERE usuarios.correo='$correo'";

        $datos = parent::obtenerDatos($query);
        if(isset($datos[0]["id_usuario"])){
            return $datos;
        }else{
            return 0;
        }
    }

      private function insertarToken($idusuario){
        $val = true;
        $token = bin2hex(openssl_random_pseudo_bytes(16,$val));
        
        $estado = "activo";
        $query = "INSERT INTO usuarios_token (token,estado,fecha,id_usuario)VALUES('$token','$estado',now(),'$idusuario')";
        $verifica = parent::insertarFila($query);
        if($verifica){
            return $token;
        }else{
            return 0;
        }
    }





}




?>