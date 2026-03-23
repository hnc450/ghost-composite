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
      
      public static function randUUID(int $length = 20):string
      {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
      }
   }
?>