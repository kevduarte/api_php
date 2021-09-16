<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/publicaciones.class.php';

$_respuestas = new respuestas;
$_publicaciones = new publicaciones;


if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(isset($_GET["pag"])){

        $pagina = $_GET["pag"];
        $listaPublicaciones = $_publicaciones->listaPublicaciones($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaPublicaciones);
        http_response_code(200);
    }


    else if(isset($_GET['id'])){
        
        $publicacionid = $_GET['id'];
        $datosPublicacion = $_publicaciones->obtenerPublicacion($publicacionid);
        header("Content-Type: application/json");
        echo json_encode($datosPublicacion);
        http_response_code(200);
    }
    
}else if($_SERVER['REQUEST_METHOD'] == "POST"){

     
    $postBody = file_get_contents("php://input");
    
    $datosArray = $_publicaciones->post_publicaciones($postBody);
    
     header('Content-Type: application/json');
     if(isset($datosArray["result"]["error_id"])){
         $responseCode = $datosArray["result"]["error_id"];
         http_response_code($responseCode);
     }else{
         http_response_code(200);
     }
     echo json_encode($datosArray);
  
    
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){

     
      $postBody = file_get_contents("php://input");
     
      $datosArray = $_publicaciones->put_publicacion($postBody);
      
     header('Content-Type: application/json');
     if(isset($datosArray["result"]["error_id"])){
         $responseCode = $datosArray["result"]["error_id"];
         http_response_code($responseCode);
     }else{
         http_response_code(200);
     }
     echo json_encode($datosArray);
     

}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){


    //recibimos los datos enviados
            $postBody = file_get_contents("php://input");
        
        
        //enviamos datos al manejador
        $datosArray = $_publicaciones->delete($postBody);
        //delvovemos una respuesta 
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