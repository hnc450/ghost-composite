<?php 
   $router->get('/',function(){
      header("Content-Type: application/json");
      
      echo  json_encode([
            'message' => 'Welchome'
      ]);
   });

   $router->get('/test',function(){
      //require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'tests/formData.php';
      $model = new \Model\MysqlDatabase(); ;
      $model->query("SELECT * FROM utilisateur");
   });


?>