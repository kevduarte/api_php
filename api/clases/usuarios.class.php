<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";


class usuarios extends conexion {

private $table = "usuarios";
    private $nombre = "";
    private $apellido_paterno = "";
    private $apellido_materno = "";
    private $correo = "";
    private $password = "";
    private $id_rol = "";

   
public function post_usuarios($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
      
                if(!isset($datos['nombre']) || !isset($datos['apellido_paterno']) || !isset($datos['apellido_materno']) || !isset($datos['correo']) || !isset($datos['password'])){
                    return $_respuestas->error_400();
                }else{
                    $this->nombre = $datos['nombre'];
                    $this->apellido_paterno = $datos['apellido_paterno'];
                    $this->apellido_materno = $datos['apellido_materno'];
                     $this->correo = $datos['correo'];
                      $this->password = $datos['password'];
                       $this->id_rol = 1;
               
                    $resp = $this->insertarUsuario();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "id_usuario" => $resp
                        );
                        return $respuesta;
                    }else{
                        return $_respuestas->error_500();
                    }
                }



    }


       private function insertarUsuario(){
        $query = "INSERT INTO " . $this->table . " (nombre,apellido_paterno,apellido_materno,correo,password,id_rol)
        values
        ('" . $this->nombre . "','" . $this->apellido_paterno . "','" . $this->apellido_materno ."','" . $this->correo . "','"  . $this->password . "','" . $this->id_rol . "')"; 
        $resp = parent::insertarFilaId($query);
        if($resp){
             return $resp;
        }else{
            return 0;
        }
    }

   


}





?>