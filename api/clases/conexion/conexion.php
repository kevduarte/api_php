<?php

class conexion {


//variables de conexion
    private $servidor;
    private $usuario;
    private $password;
    private $database;
    private $port;
    private $conexion;


    function __construct(){

        $listadatos = $this->datosConexion();
        foreach ($listadatos as $key => $value) {
            $this->servidor = $value['servidor'];
            $this->usuario = $value['usuario'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port = $value['port'];
        }
        $this->conexion = new mysqli($this->servidor,$this->usuario,$this->password,$this->database,$this->port);
        if($this->conexion->connect_errno){
            echo "error al conectar a la base de datos.";
            die();
        }

    }

//metodo para obtener los valores de la base de datos del archivo config
    private function datosConexion(){
        $direccion = dirname(__FILE__);
        $jsondata = file_get_contents($direccion . "/" . "config");
        return json_decode($jsondata, true);//se convierte a array asociativo
    }


    private function convertirUTF8($array){
        array_walk_recursive($array,function(&$item,$key){
            if(!mb_detect_encoding($item,'utf-8',true)){
                $item = utf8_encode($item);
            }
        });
        return $array;
    }

    //end metodos privado


    public function obtenerDatos($consulta){
        $results = $this->conexion->query($consulta);
        $resultArray = array();
        foreach ($results as $key) {
            $resultArray[] = $key;
        }
        return $this->convertirUTF8($resultArray);

    }



//nos regresa las filas
    public function insertarFila($consulta){
        $results = $this->conexion->query($consulta);
        return $this->conexion->affected_rows;
    }


    //nos devuelve el id de la fila afectada
    public function insertarFilaId($consulta){
        $results = $this->conexion->query($consulta);
         $filas = $this->conexion->affected_rows;
         if($filas >= 1){
            return $this->conexion->insert_id;
         }else{
             return 0;
         }
    }
     
    //encriptar

    protected function encriptar_contrasena($contrasena){
        return md5($contrasena);
    }





}



?>