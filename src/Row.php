<?php


namespace Datagrid;




class Row implements \Countable
{
    public $columns = array();

    public function __construct($rowFields)
    {
        foreach ($rowFields as $columnName => $cellData) {
            $this->columns[] = new Cell($columnName, $cellData);
        }
    }

    public function __call($method, $arguments)
    {

    }

    public function count()
    {
        return count($this->columns);
    }
}