<?php namespace Datagrid;


use Nette\Utils\Html;

class Cell
{
    private $columnName;
    private $cellData;

    public function __construct($columnName, $cellData)
    {
        $this->columnName = $columnName;
        $this->cellData = $cellData;
    }

    /**
     * @return mixed
     */
    public function getColumnName()
    {
        return $this->columnName;
    }

    /**
     * @param mixed $columnName
     */
    public function setColumnName($columnName)
    {
        $this->columnName = $columnName;
    }

    /**
     * @return mixed
     */
    public function getCellData()
    {
        return $this->cellData;
    }

    /**
     * @param mixed $cellData
     */
    public function setCellData($cellData)
    {
        $this->cellData = $cellData;
    }

    public function renderCell()
    {
        $td = Html::el('td');
        $td->setText($this->getCellData());

        return $td;
    }
}