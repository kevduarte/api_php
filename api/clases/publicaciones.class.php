<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";


class publicaciones extends conexion {

    private $table = "publicaciones";
    private $id_publicacion="";
    private $titulo = "";
    private $descripcion = "";
    private $fecha_creacion = "0000-00-00";
    private $id_usuario = "";
    private $token = "";

   

    public function listaPublicaciones($pagina = 1){
        $inicio  = 0 ;
        $cantidad = 10;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina - 1)) +1 ;
            $cantidad = $cantidad * $pagina;
        }


        $query = "SELECT * FROM " . $this->table . " INNER JOIN usuarios ON usuarios.id_usuario=publicaciones.id_usuario INNER JOIN roles ON roles.id_rol=usuarios.id_rol limit $inicio,$cantidad";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }

    public function obtenerPublicacion($id){
        $query = "SELECT * FROM " . $this->table . " INNER JOIN usuarios ON usuarios.id_usuario=publicaciones.id_usuario INNER JOIN roles ON roles.id_rol=usuarios.id_rol WHERE publicaciones.id_publicacion = '$id'";
        return parent::obtenerDatos($query);

    }



    public function post_publicaciones($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

           if(!isset($datos['token'])){
                return $_respuestas->error_401();
        }else{
            $this->token = $datos['token'];
            $arrayToken =   $this->buscarToken();
            if($arrayToken){

                if(!isset($datos['titulo']) || !isset($datos['descripcion']) || !isset($datos['fecha_creacion'])){
                    return $_respuestas->error_400();
                }else{
                    $this->titulo = $datos['titulo'];
                    $this->descripcion = $datos['descripcion'];
                    $this->fecha_creacion = $datos['fecha_creacion'];
                       $this->id_usuario = 1;
               
                    $resp = $this->insertarPublicacion();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "id_publicacion" => $resp
                        );
                        return $respuesta;
                    }else{
                        return $_respuestas->error_500();
                    }
                }


                }else{
                return $_respuestas->error_401("El Token que envio es invalido o ha caducado");
            }
      
                



    }

}


       private function insertarPublicacion(){
        $query = "INSERT INTO " . $this->table . " (titulo,descripcion,fecha_creacion,id_usuario)
        values
        ('" . $this->titulo . "','" . $this->descripcion . "','" . $this->fecha_creacion ."','" . $this->id_usuario . "')"; 
        $resp = parent::insertarFilaId($query);
        if($resp){
             return $resp;
        }else{
            return 0;
        }
    }




     public function put_publicacion($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

        if(!isset($datos['token'])){
                return $_respuestas->error_401();
        }else{
            $this->token = $datos['token'];
            $arrayToken =   $this->buscarToken();
            if($arrayToken){

                 if(!isset($datos['id_publicacion'])){
                    return $_respuestas->error_400();
                }else{
                    $this->id_publicacion = $datos['id_publicacion'];
                    if(isset($datos['titulo'])) { $this->titulo = $datos['titulo']; }
                    if(isset($datos['descripcion'])) { $this->descripcion = $datos['descripcion']; }
                    if(isset($datos['id_usuario'])) { $this->id_usuario = $datos['id_usuario']; }
                    if(isset($datos['fecha_creacion'])) { $this->fecha_creacion = $datos['fecha_creacion']; }
                    
        
                    $resp = $this->modificarPublicacion();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "id_publicacion" => $this->id_publicacion
                        );
                        return $respuesta;
                    }else{
                        return $_respuestas->error_500();
                    }
                }
                

                }else{
                return $_respuestas->error_401("El Token que envio es invalido o ha caducado");
            }
      
                



    }

    
               


    }


    private function modificarPublicacion(){
        $query = "UPDATE " . $this->table . " SET titulo ='" . $this->titulo . "',descripcion = '" . $this->descripcion . "', fecha_creacion = '" . $this->fecha_creacion . "', id_usuario = '" . $this->id_usuario . "' WHERE id_publicacion = '" . $this->id_publicacion . "'"; 
        $resp = parent::insertarFila($query);
        if($resp >= 1){
             return $resp;
        }else{
            return 0;
        }
    }



     public function delete($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);


        if(!isset($datos['token'])){
                return $_respuestas->error_401();
        }else{
            $this->token = $datos['token'];
            $arrayToken =   $this->buscarToken();
            if($arrayToken){
                 if(!isset($datos['id_publicacion'])){
                    return $_respuestas->error_400();
                }else{
                    $this->id_publicacion = $datos['id_publicacion'];
                    $resp = $this->eliminarPublicacion();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "id_publicacion" => $this->id_publicacion
                        );
                        return $respuesta;
                    }else{
                        return $_respuestas->error_500();
                    }
                }


                }else{
                return $_respuestas->error_401("El Token que envio es invalido o ha caducado");
            }
      
                



    }

    

               
     
    }



    private function eliminarPublicacion(){
        $query = "DELETE FROM " . $this->table . " WHERE id_publicacion= '" . $this->id_publicacion . "'";
        $resp = parent::insertarFila($query);
        if($resp >= 1 ){
            return $resp;
        }else{
            return 0;
        }
    }



     private function buscarToken(){
        $query = "SELECT  id_token,id_usuario,estado from usuarios_token WHERE token = '" . $this->token . "' AND estado = 'activo'";
        $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp;
        }else{
            return 0;
        }
    }

       private function actualizarToken($tokenid){
        $date = date("Y-m-d H:i");
        $query = "UPDATE usuarios_token SET fecha = '$date' WHERE id_token = '$tokenid' ";
        $resp = parent::insertarFila($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
    }

   


}





?>