<?php

   $router->post('/login', function() {
      $datas = json_decode(file_get_contents('php://input'), true);
      if (!is_array($datas)) $datas = [];
      $userController = \Controller\FactoryController::factory('User', 'User');
      $userController->login($datas, ['mail', 'password']);
   });

   $router->post('/sign', function() {
      $datas = json_decode(file_get_contents('php://input'), true);
      if (!is_array($datas)) $datas = [];
      $userController = \Controller\FactoryController::factory('User', 'User');
      $userController->sign($datas, ['name', 'mail', 'password']);
   });
   
?>