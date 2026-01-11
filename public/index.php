<?php

use Router\Router;

   require dirname(__DIR__). DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
   $router = new AltoRouter();
   $route = new Router($router);
   $route->get('/test',function(){
      require dirname(__DIR__). DIRECTORY_SEPARATOR . 'tests/StringyTest.php';
   });

   $route->matcher();
?>