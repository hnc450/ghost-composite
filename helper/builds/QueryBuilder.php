<?php
   namespace Helper\Build;

use Helper\String\Stringy;

   class QueryBuilder
   {
      private $facadeRequest;

      public function from(string $table, string $columns = ""){
      
         Stringy::filled($columns) ?
          $this->facadeRequest = "SELECT $columns FROM $table" 
          : 
          $this->facadeRequest = "SELECT * FROM $table";
        return $this;
      }

      public function where(){
         $this->facadeRequest .= " WHERE ";
         return $this;
      }
     
   }
?>