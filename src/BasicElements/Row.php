<?php namespace Datagrid\BasicElements;


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

    public function count()
    {
        return count($this->columns);
    }

    public function renderRow()
    {
        $tr = Html::el('tr');

        /** @var Cell $cell */
        foreach ($this->columns as $cell) {
            $td = $cell->renderCell();
            $tr->add($td);
        }

        return $tr;
    }

    public function renderHeaderRow($enabledSorting)
    {
        $thead = Html::el('thead');
        $tr = Html::el('tr');

        $thead->add($tr);

        /** @var Cell $cell */
        foreach ($this->columns as $cell) {
            $td = $cell->renderHeaderCell($enabledSorting);
            $tr->add($td);
        }

        return $thead;
    }
}