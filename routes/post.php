<?php 

   $router->post('/login',function(){
      $datas = json_decode(file_get_contents('php://input'),true);
      // $userController = new \Controller\UserController();
      // $userController->login($datas,['mail','password']);
   });

   $router->post('/sign',function(){
      $datas = json_decode(file_get_contents('php://input'),true);
      // $userController = new \Controller\UserController();
      // $userController->sign($datas,['name','mail','password']);
   });
   
?>