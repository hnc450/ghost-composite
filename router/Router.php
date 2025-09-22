<?php
 namespace Router;
   class Router
   {
       private $router;

       public function __construct(\AltoRouter $router)
       {
            $this->router = $router;
       }

       public function get(string $route, $target, string $name = '')
       {
          $this->router->map('GET',$route,$target,$name);
       }

       public function post(string $route, $target, string $name = '')
       {
          $this->router->map('POST',$route,$target,$name);
       }

       public function delete(string $route, $target, string $name = '')
       {
          $this->router->map('DELETE',$route,$target,$name);
       }

       public function put(string $route, $target, string $name = '')
       {
          $this->router->map('PUT',$route,$target,$name);
       }
       public function origin($path)
       {
         $this->router->setBasePath($path);
       }

       public function matcher()
       {
          $match = $this->router->match();
   
          if($match && is_callable($match['target'])){
            call_user_func($match['target'],$match['params']);
          }
         else{
            $this->respondNotFound();
         }
       }

       private function respondNotFound()
       {
           http_response_code(404);
           echo json_encode([
               'status' => 404,
               'message' => 'Route introuvable'
           ]);
       }

   }
?>