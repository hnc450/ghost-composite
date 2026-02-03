<?php 
    namespace Container;

    class Dic{
   
        private static array $container;

        public static function get(string $key){

          if(isset(self::$container[$key])){
            return self::$container[$key];
          }
            return;
        }

        public static function set(string $key, $class){

            if(!isset(self::$container[$key])){
                self::$container[$key] = $class; 
            }
          
            return;
        }
    }
?>