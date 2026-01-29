<?php 
  namespace App\controllers;
  class Controller
  {
    protected function sanitaze(string $input):string
    {
       return strip_tags(htmlspecialchars($input));
    }
  }
?>