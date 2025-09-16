<?php
   // constante pour remonter un dossier à un autre
   define("PATH", dirname(__DIR__));
   require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

   use AltoRouter as Route;
   $route = new Route();
   $path = isset($_SERVER['BASE_URI']) ? $_SERVER['BASE_URI'] : '';
   // Injection de dependance 
   // design qui permet de passer une classe en dependance à une autre 
   $router = new Router\Router($route);

   // $router->origin($path);
   
   require PATH . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR. 'get.php';

   // methode pour matcher le params avec les donnés  à envoyer 
   // dans les callables (fonctions anonyme)
   $router->matcher();
?>