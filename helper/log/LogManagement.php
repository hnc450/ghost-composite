<?php 
   namespace Helper\Log;
   class LogManagement 
   {
      # date log
      # hour log
      # title log
      # content log
  
      public static $instance;

      public function __construct()
      {
         
      }
      
      public function create(string $content):void
      {

      // var_dump(dirname(__DIR__, 2).DIRECTORY_SEPARATOR."logs" . DIRECTORY_SEPARATOR ."error.log");
      // die;
          
          if(file_exists(dirname(__DIR__, 2).DIRECTORY_SEPARATOR."logs" . DIRECTORY_SEPARATOR ."error.log"))
          {
            file_put_contents( dirname(__DIR__, 2).DIRECTORY_SEPARATOR."logs" . DIRECTORY_SEPARATOR ."error.log", "[". $this->date()."] ".$content."\n", FILE_APPEND);
          }
      
        
      } 

      public function date():string
      {
         return"". date('Y-m-d')." | ". $this->hour()."";
      }

      public function hour():string
      {
         return date('H:i:s');
      }
      public static function Instance():self
      {
         if(self::$instance == null)
         {    
            self::$instance = new self();
         }
         return self::$instance;
      }
   }

?>