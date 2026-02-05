<?php

use Container\Dic;
use Helper\Build\Database;
use Router\Router;

   require dirname(__DIR__). DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

   require dirname(__DIR__). DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'web.php';
   require dirname(__DIR__). DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'api.php';
   Database::Instance()->run();

   Dic::set(Database::class, Database::Instance());
   
   Router::matcher();
?>