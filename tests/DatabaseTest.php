<?php
 namespace Tests;
use \Helper\Build\Database;

    class DatabaseTest{

        public function testingDb(){

            $database = Database::Instance();
            $database->run();
            var_dump($database->query('SELECT * FROM users')->fetch());
        }
    }
?>