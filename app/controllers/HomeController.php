<?php

   namespace App\controllers;

   use Helper\Build\Query;

  class HomeController  extends Controller
  {

    public function index()
    {
       $query = new Query();
       
       var_dump($query->fetch('users'));
    }
    
    public function test(){

    }
    
  }

?>