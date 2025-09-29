<?php

   $router->post('/login', function() {
      $userController = \Controller\FactoryController::factory('User', 'User');
      $datas = json_decode(file_get_contents('php://input'), true);
      if (!is_array($datas)) $datas = [];

      $userController->login($datas, ['email', 'mot_de_passe']);
   });

   $router->post('/sign', function() {
      $datas = json_decode(file_get_contents('php://input'), true);
      if (!is_array($datas)) $datas = [];
      $userController = \Controller\FactoryController::factory('User', 'User');
      $userController->sign($datas, ['nom', 'email', 'mot_de_passe']);
   });
   
?>