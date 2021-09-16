<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/usuarios.class.php';

$_respuestas = new respuestas;
$_usuarios = new usuarios;


if($_SERVER['REQUEST_METHOD'] == "POST"){

   
        $postBody = file_get_contents("php://input");
    
        $datosArray = $_usuarios->post_usuarios($postBody);
    
     header('Content-Type: application/json');
     if(isset($datosArray["result"]["error_id"])){
         $responseCode = $datosArray["result"]["error_id"];
         http_response_code($responseCode);
     }else{
         http_response_code(200);
     }
     echo json_encode($datosArray);
    
     
       

}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}


?>