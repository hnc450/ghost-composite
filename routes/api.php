<?php

use App\controllers\Controller;
use Router\Router;

  Router::get('/api',function(){
    Controller::status(200)->json(['message' => 'home api']);
  })
?>