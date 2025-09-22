<?php
   // constante pour remonter un dossier à un autre
   define("PATH", dirname(__DIR__));
   require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
   
   use AltoRouter as Route;

   $route = new Route();
   $database = new \Model\Database();

   $path = isset($_SERVER['BASE_URI']) ? $_SERVER['BASE_URI'] : '';
   $database->connect();
   
 
   // Injection de dependance 
   // design qui permet de passer une classe en dependance à une autre 
   $router = new Router\Router($route);
   
   $router->origin($path);
   
   require PATH . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR. 'get.php';
   require PATH . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR. 'post.php';
   require PATH . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR. 'put.php';
   require PATH . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR. 'delete.php';

   // methode pour matcher le params avec les donnés  à envoyer 
   // dans les callables (fonctions anonyme)
   $router->matcher();
?>