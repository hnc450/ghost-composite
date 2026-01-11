<?php 
  namespace Helper\Api;
  use  Helper\String\Stringy;
 
  class GhostFisherman
  {

    private string $apiKey = "";
    
    public function key(string $keyApi)
    {
        if(Stringy::empty($keyApi))
        {
             $this->apiKey = $keyApi;
             return $this;
        }
        
       die;
    }

    public function fetch(string $fetchUri)
    {

    }
  }
?>