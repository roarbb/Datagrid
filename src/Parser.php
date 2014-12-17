<?php namespace Datagrid;


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