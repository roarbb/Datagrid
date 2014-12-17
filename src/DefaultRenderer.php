<?php


namespace Datagrid;


use Tracy\Debugger;

class DefaultRenderer
{
    private $rows = array();

    public function getHtmlTable($data)
    {
        $this->parseData($data);
        return "Datatable";
    }

    private function parseData($data)
    {
        foreach ($data as $row) {
            $this->rows[] = new Row($row);
        }

        Debugger::dump($this->rows);
    }
}