<?php

namespace Helper\Build;

use Container\Dic;
use Helper\String\Stringy;
use Helper\Build\Database;

class QueryBuilder
{
    private $facadeRequest;

    public function from(string $table, string $columns = "")
    {

        Stringy::filled($columns) ?
         $this->facadeRequest = "SELECT {$columns} FROM {$table}"
         :
         $this->facadeRequest = "SELECT * FROM {$table}";
        return $this;
    }

    public function where(mixed $column, mixed $value)
    {
        $this->facadeRequest .= " WHERE {$column}='{$value}'";
        return $this;
    }

    public function delete($table)
    {
        $this->facadeRequest  = "DELETE FROM {$table} ";
        return $this;
    }

    public function run()
    {
        Dic::get(Database::class)->query($this->facadeRequest);

    }

}
