<?php 
  namespace App\controllers;
  class Controller
  {
    private static $controller;
    
    private static function instance():self{
        if(is_null(self::$controller))
        {
          self::$controller = new Controller();
        }
        return self::$controller;
    }
    
    protected function sanitaze(string $input):string
    {
       return strip_tags(htmlspecialchars($input));
    }
     public static function error(int $error)
    {
      \http_response_code($error);
     return self::instance();
    }
    
    public static function json($array)
    {
      echo json_encode($array,JSON_PRETTY_PRINT);
    }

    public function inputs(){
      $datas = \file_get_contents('php://input');
      return $datas;
    }
  }
?>
