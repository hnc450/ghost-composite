<?php 
  namespace Controller;

  class UserController extends BaseController
  {
      private string $nameRegex = "/^[a-zA-Z\s'-]+$/";
      private string $emailRegex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
      private string $passwordRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";

      public function sign($datas = [])
      {}

      public function login($datas = [])
      {}
    
  }
?>