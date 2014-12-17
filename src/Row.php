<?php namespace Datagrid;


use Nette\Utils\Html;

class Row implements \Countable
{
    public $columns = array();

    public function __construct($rowFields)
    {
        foreach ($rowFields as $columnName => $cellData) {
            $this->columns[] = new Cell($columnName, $cellData);
        }
    }

//    public function __call($method, $arguments)
//    {
//
//    }

    public function count()
    {
        return count($this->columns);
    }

    public function renderRow()
    {
        $tr = Html::el('tr');

        foreach ($this->columns as $cell) {
            $td = $cell->renderCell();
            $tr->add($td);
        }

        return $tr;
    }
}