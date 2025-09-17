<?php 
    namespace Controller;

    abstract class BaseController
    {
        protected function matcherString(string $string, $match):bool
        {
           return  preg_match($match, $string) ? true : false;
        }

        protected function valideLength(string $string, int $min, int $max):bool
        {
            $length = strlen($string);
            return ($length >= $min && $length <= $max) ? true : false;
        }

        public  function isNotEmpty($data):bool
        {
            return !empty($data) ? true : false;
        }
    }
?>