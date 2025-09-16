<?php 
   $router->get('/',function(){
      header("Content-Type: application/json");
      
      echo  json_encode([
            'message' => 'Welchome'
      ]);
   });
?>