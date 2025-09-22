<?php 
    namespace Controller;
    
   class FactoryController
   {
           
       /**
        * factory
        *
        * @param  mixed $classname : la classe  controller à instancier
        * @param  mixed $modelname : le model à passer au controller en foction de sa classe
        * @return CLASS instance de la classe controller
        */
       public static function factory(string $classname, string $modelname)
       {
           $classname = "Controller\\" . ucfirst($classname)."Controller";
           $modelname = "Model\\" . ucfirst($modelname)."Model";
           return new $classname(new $modelname());
       } 
   }
?>