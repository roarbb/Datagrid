<?php namespace Datagrid;


use Nette\Utils\Html;

class DefaultRenderer
{
    public function getTable($data)
    {
        $rows = (new Parser)->parseData($data);
        $table = $this->buildTable($rows);

        return $table;
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