<?php 
   namespace Model;

   class FactoryModel
   {
       public static function factory(string $classname)
       {
           $database = new \Model\MysqlDatabase();
           $classname = "Model\\" . ucfirst($classname)."Model";
           return new $classname($database);
       } 
   }
?>