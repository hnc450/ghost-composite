<?php

use App\controllers\HomeController;
use Router\Router;

Router::get('/', [HomeController::class,'index']);

Router::get('/test', [HomeController::class,'test']);

Router::get('/regex', [\Tests\RegexTest::class,'test']);
