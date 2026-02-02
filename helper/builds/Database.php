<?php 

  namespace Helper\Build;

  class Database{

     private $config;
     private $connexion;
     private static $instance;

    public function __construct()
     {
         $this->config = require dirname(__DIR__,2).'/config/database.php';
     }

    public static function Instance():self{
       if(self::$instance == null){
           self::$instance = new self();
       }
       return self::$instance;
     }

    public function run(){
     
        try{
            $this->connexion = new \PDO($this->config['DB_SGBD'].":host=".$this->config['DB_HOST'].";dbname={$this->config['DB_NAME']}",$this->config['DB_USER'],$this->config['DB_MDP'],[
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
                 ]);
        }
        catch(\PDOException $e){
            echo $e->getMessage();
        }
    }

    public function query(string $request){
        $smt = $this->connexion->query($request);
        return $smt;
    }

    public function prepare(string $request , $params = []){
        $smt = $this->connexion->prepare($request);
        $smt->execute($params);
        return $smt;
    }
  }
?>