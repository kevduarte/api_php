<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <meta name="author" content="Ángel Kevin Pérez Duarte" />
    <link rel="stylesheet" href="assets/css/style.css" />

    
    <title>API</title>
     <!-- Fontawesome -->
    <script src="https://use.fontawesome.com/8e08875e32.js"></script>

   

   <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  </head>
  <body>
    

<div class="container mt-4" id="font1">

  <h2>Iniciar Sesión</h2>
                <!-- Icon -->
                
                  <img src="assets/img/login.jpg" alt="image" height="50" width="50" />
            

   <form method="post" enctype="multipart/form-data" class="form-signin" id="noteForm">

     <div class="mb-3">
       <div class="note-box">
        <label for="exampleFormControlInput1" class="form-label"><i class="fa fa-envelope" aria-hidden="true"></i> Correo</label>
           <input type="email" class="form-control" name="correo" required />
         </div>
         <div class="mb-3">
           <label for="exampleFormControlTextarea1" class="form-label"><i class="fa fa-key" aria-hidden="true"></i> Contraseña</label>
             <input type="password" class="form-control" name="password" required /> 
           </div>
         </div>

         <div class="mb-3"> <button type="button" class="btn btn-success" id="button">login</button> </div>
    </form>

    <a href="registro.php"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> registrarse</a>
</div>





    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    -->


      <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </body>



  <script>
    
$("#button").click(function(){
        var formData=$('#noteForm').serializeArray();
        var jsonObj={};
      for(var i in formData){
    jsonObj[formData[i].name]=formData[i].value;
  }

  var dataJson = JSON.stringify(jsonObj);
  
  $.ajax({
  type: 'POST',
  url: 'http://localhost/php_api/api/acceso',
  dataType: 'json',
  data: dataJson,
  success: function(data) {

 var ok="ok";

  if (data.status === ok) {

    var tokenid=data.result.token;

    localStorage.setItem("token", tokenid);

    var permiso=data.result.id_permiso;

    console.log(permiso);

    if (permiso==1) {
      location.href='inicio_basico.php';

    }else{

      if (permiso==2) {
        location.href='inicio_medio.php';

      }else{

        if (permiso==3) {
          location.href='inicio_medioalto.php';

        }else{

          if (permiso==4) {
            location.href='inicio_altomedio.php';

          }else{

            if (permiso==5) {
              location.href='inicio_alto.php';

            }else{
              alert("nivel de acceso no existe");
            }
          }
        }
      }


    }

    
  }else{

   alert(data.result.error_msg);
  }


  }
});

});

     



  </script>


</html>