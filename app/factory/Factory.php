<?php 

   namespace App\factory;
   
   class Factory
   {
       public static function factory(string $classname,string $type ="App\\Model")
       {
           $classname = $type."\\" . ucfirst($classname);
           return new $classname();
       } 
   }
?>