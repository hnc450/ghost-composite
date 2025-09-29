<?php 
     namespace Controller;

     class AdminController extends \Controller\UserController
     {
        public function deleteUser($id){
            $this->model->deleteUser($id);
        }

        public function deleteAllUsers(){
             $this->model->deleteAllUser();
        }
        
     }
?>