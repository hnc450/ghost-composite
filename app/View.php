<?php
  namespace App;

  class View
 {
   
    public static function view($template) 
    {
       $template = str_replace('.',DIRECTORY_SEPARATOR,$template);
       require dirname(__DIR__) . '/views/' . $template . '.php';
    }
  }
?>