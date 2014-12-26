<?php namespace Datagrid\Utils;


use Datagrid\BasicElements\ActionButton;
use Datagrid\BasicElements\Cell;
use Datagrid\BasicElements\Row;

class Parser
{
    /**
     * Transforms array to array of Rows
     *
     * @param array $data
     * @param array $hidedColumns
     * @return array
     */
    public function dataToRows(array $data, array $hidedColumns)
    {
        $rows = array();

        foreach ($data as $row) {
            $rows[] = new Row($row, $hidedColumns);
        }

        return $rows;
    }

    /**
     * Transforms array to array of ActionButtons
     *
     * @param array $data
     * @param Row $row
     * @return array
     */
    public function actionsToActionButtons(array $data, Row $row)
    {
        $actions = array();

        foreach ($data as $action) {
            $actions[] = new ActionButton($action[0], $action[1], $row);
        }

        return $actions;
    }

    /**
     * Transforms array to array of Cells
     *
     * @param $rowData
     * @return array
     */
    public function rowDataToCells($rowData)
    {
        $cells = array();

        foreach ($rowData as $columnName => $cellData) {
            $cells[] = new Cell($columnName, $cellData);
        }

        return $cells;
    }
}