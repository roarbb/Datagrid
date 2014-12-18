<?php namespace Datagrid\Utils;


use Datagrid\BasicElements\ActionButton;
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

    public function actionsToActionButtons(array $data)
    {
        $actions = array();

        foreach ($data as $action) {
            $actions[] = new ActionButton($action[0], $action[1]);
        }

        return $actions;
    }
}