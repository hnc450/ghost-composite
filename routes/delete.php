<?php 
  // delete user route
    $router->delete('/api/users/[i:id]', function($id){
         $user = \Controller\FactoryController::factory('User','User');
        
        $user->deleteAccount($id['id']);
    });
?>