<?php 
   class Integer{
    
      public static function randId(int $length = 5):int
      {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return (int)$randomString;
      }
   }

?>