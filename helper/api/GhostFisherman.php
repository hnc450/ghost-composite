<?php 
  namespace Helper\Api;
  use  Helper\String\Stringy;
 
  class GhostFisherman
  {
    private $curl ;
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

    public function fetch()
    {
      \curl_exec($this->curl);
      return $this;
    }

    public function init(string $link)
    {
        $this->curl = \curl_init($link);
        return $this;
    }

    public function option(int $option,mixed $value)
    {
      \curl_setopt($this->curl,$option,$value);
      return $this;
    }
  }
?>