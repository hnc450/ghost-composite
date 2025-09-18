<?php 

   $router->post('/sign',function(){
      $userController = new \Controller\UserController();
      $userController->login([],['mail','password']);
   });

   $router->post('/login',function(){
      $userController = new \Controller\UserController();
      $userController->sign([],['name','mail','password']);
   });
   
?>