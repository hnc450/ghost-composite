<?php 
    namespace Controller;

    abstract class BaseController
    {
        protected $model;
        protected array $messages = [];

        public function __construct($model)
        {
            $this->model = $model;
        }

        public function getModel(){
          return $this->model;
        }

        protected function matcherString(string $string, $match):bool
        {
           return  preg_match($match, $string) ? true : false;
        }

        protected function valideLength(string $string, int $min = 6, int $max = 12):bool
        {
            $length = strlen($string);
            return ($length >= $min && $length <= $max) ? true : false;
        }

        public  function isNotEmpty($data):bool
        {
            return !empty($data) ? true : false;
        }

        public function verifyFields(array $datas, array $fields):bool
        {
            foreach ($fields as $field) {
                if (!isset($datas[$field]) || empty($datas[$field])) {
                    return false; 
                }
            }
            return true; 
        }

        private function echoJson($value):void
        {
            echo json_encode($value);
        }

        public function jsonResponse($array = [])
        {
           header('Content-Type: application/json');
            if($array !== null && is_array($array))
            {
               $this->messages = $array;
               http_response_code($this->messages['status']);
               $this->echoJson($this->messages);
            }
           
            $this->echoJson(['' => '']);
        }
    }
?>