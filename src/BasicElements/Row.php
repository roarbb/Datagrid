<?php namespace Datagrid\BasicElements;


use Nette\Utils\Html;

class Row implements \Countable, IBasicElement
{
    public $cells = array();
    public $rowActions = array();

    public function __construct($rowFields)
    {
        foreach ($rowFields as $columnName => $cellData) {
            $this->cells[] = new Cell($columnName, $cellData);
        }
    }

    public function count()
    {
        return count($this->cells);
    }

    public function render()
    {
        $tr = Html::el('tr');

        /** @var Cell $cell */
        foreach ($this->cells as $cell) {
            $td = $cell->render();
            $tr->add($td);
        }

        if(!empty($this->rowActions)) {
            $actions = new ActionCell($this->rowActions);
            $actionTd = $actions->render();

            $tr->add($actionTd);
        }

        return $tr;
    }

    public function renderHeaderRow($sortingEnabled)
    {
        $thead = Html::el('thead');
        $tr = Html::el('tr');

        $thead->add($tr);

        /** @var Cell $cell */
        foreach ($this->cells as $cell) {
            $td = $cell->renderHeaderCell($sortingEnabled);
            $tr->add($td);
        }

        return $thead;
    }

    public function getCellByCellName($cellName)
    {
        $cell = array_filter($this->cells, function (Cell $cell) use ($cellName) {
            return $cell->getColumnName() == $cellName;
        });

        return reset($cell);
    }

    public function addActions(array $rowActions)
    {
        $this->rowActions = $rowActions;
    }
}