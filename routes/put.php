<?php 

   $router->put('/users/[i:id]',function($id){
        $datas = json_decode(file_get_contents('php://input'),true);
        $userController = \Controller\FactoryController::factory('user','user');
        $userController->updateAccount($id,$datas);
   });
?>