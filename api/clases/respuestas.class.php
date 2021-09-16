<?php 

class respuestas{

    public  $response = [
        'status' => "ok",
        "result" => array()
    ];



//el error 405 metodo no permitido
    public function error_405(){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "405",
            "error_msg" => "Metodo no permitido. Por favor comprueba la cabecera Allow por los metodos HTTP permitidos."
        );
        return $this->response;
    }

    public function error_200($valor = "Datos incorrectos"){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "200",
            "error_msg" => $valor
        );
        return $this->response;
    }


//400: Petición errónea. Esto puede estar causado por varias acciones de el usuario, como proveer un JSON no válido en el cuerpo de la petición, proveyendo parámetros de acción no válidos, etc.
    public function error_400(){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "400",
            "error_msg" => "Datos enviados con formato incorrecto, JSON no valido, datos error"
        );
        return $this->response;
    }


    public function error_500($valor = "Error interno del servidor"){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "500",
            "error_msg" => $valor
        );
        return $this->response;
    }


    public function error_401($valor = "No hay token"){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "401",
            "error_msg" => $valor
        );
        return $this->response;
    }
    
    

}

?>