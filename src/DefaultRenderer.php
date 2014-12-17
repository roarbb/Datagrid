<?php namespace Datagrid;


use Nette\Utils\Html;

class DefaultRenderer
{
    private $rows = array();

    public function getTable($data)
    {
        $this->parseData($data);
        $table = $this->buildTable($this->rows);

        return $table;
    }

    private function parseData($data)
    {
        foreach ($data as $row) {
            $this->rows[] = new Row($row);
        }
    }

    private function buildTable(array $rows)
    {
        $table = Html::el('table');

        foreach ($rows as $row) {
            $tr = $row->renderRow();
            $table->add($tr);
        }

        return $table;
    }
}