<?php
  namespace Helper\Build;

  use Container\Dic;

  class Query {

    private $database;
    private string $request;
    public function get($table){

     $this->database = Dic::get(Database::class);

     return $this->database->query("SELECT * FROM $table")->fetchAll();
    }
    
    public function fetch($table){

      $this->database = Dic::get(Database::class);

      return $this->database->query("SELECT * FROM $table")->fetch();
    }
  }
?>