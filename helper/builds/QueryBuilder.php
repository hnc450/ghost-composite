<?php

namespace Helper\Build;

use Container\Dic;
#use Helper\String\Stringy;
use Helper\Build\Database;

class QueryBuilder
{
    private $facadeRequest;

    public function from(string $table, string $columns = "")
    {
        $this->facadeRequest = "SELECT " . ($columns == "" ? "*" : $columns) . " FROM {$table} ";
        return $this;
    }

    public function where(string $column, mixed $value)
    {
        $this->facadeRequest .= " WHERE {$column}='{$value}'";
        return $this;
    }

    public function delete(string $table)
    {
        $this->facadeRequest  = "DELETE FROM {$table} ";
        return $this;
    }

    public function run()
    {
        Dic::get(Database::class)->query($this->facadeRequest);
    }

}
