<?php namespace Datagrid\Utils;


use Datagrid\BasicElements\Row;

class Parser
{
    private $rows;

    public function parseData($data)
    {
        foreach ($data as $row) {
            $this->rows[] = new Row($row);
        }

        return $this->rows;
    }
}