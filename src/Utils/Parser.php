<?php namespace Datagrid\Utils;


use Datagrid\BasicElements\ActionButton;
use Datagrid\BasicElements\Cell;
use Datagrid\BasicElements\Row;

class Parser
{
    public function dataToRows(array $data)
    {
        $rows = array();

        foreach ($data as $row) {
            $rows[] = new Row($row);
        }

        return $rows;
    }

    public function actionsToActionButtons(array $data, Row $row)
    {
        $actions = array();

        foreach ($data as $action) {
            $actions[] = new ActionButton($action[0], $action[1], $row);
        }

        return $actions;
    }

    public function rowDataToCells($rowData)
    {
        $cells = array();

        foreach ($rowData as $columnName => $cellData) {
            $cells[] = new Cell($columnName, $cellData);
        }

        return $cells;
    }
}