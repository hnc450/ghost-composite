<?php

session_start();
use Container\Dic;
use Helper\Build\Database;
use Helper\Log\LogManagement;
use Router\Router;

require dirname(__DIR__). DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

require dirname(__DIR__). DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'web.php';
require dirname(__DIR__). DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'api.php';

Dic::set(Database::class, Database::Instance());
Dic::set(LogManagement::class, LogManagement::Instance());

Database::Instance()->run();

Router::matcher();