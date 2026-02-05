<?php 
   namespace Helper\String;

   class Stringy 
   {
      public static function empty(string $str):string | bool
      {
        return $str ? $str : false;
      }

      public static function filled(string $str):bool
      {
        return !self::empty($str);
      }

      public static function concate(string $first = " ",string $second = " "):string
      {
        return $first . $second;
      }

      public static function lengthError(string $str, int $minLength = 3,int $maxLength = 8):string
      {
        return strlen($str) < $minLength || strlen($str) > $maxLength ?
                "The string must have  >" . $minLength ."  and   <= ". $maxLength : $str;
      }
   }
?>