<?php namespace Datagrid\BasicElements;

use Datagrid\Service\HttpService;
use Nette\Utils\Html;

class Cell implements IBasicElement
{
    private $columnName;
    private $cellData;
    private $html;

    public function __construct($columnName, $cellData)
    {
        $this->columnName = $columnName;
        $this->cellData = $cellData;
        $this->html = new Html();
    }

    public function render()
    {
        $tableData = $this->html->el('td');
        $tableData->setText($this->getCellData());

        return $tableData;
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

    public function renderHeaderCell($sortingEnabled)
    {
        $tableHeader = $this->html->el('th');

        $cellContent = $this->getCellData();

        if ($sortingEnabled) {
            $cellContent = $this->getSortingAnchor();
        }

        $tableHeader->setText($cellContent);

        return $tableHeader;
    }

    private function getSortingAnchor()
    {
        $httpService = new HttpService();
        $anchor = $this->html->el('a');

        $attributes = array();
        $attributes['href'] = $httpService->getSortUrl($this->getColumnName());

        $anchor->addAttributes($attributes);

        $anchor->setText($this->getCellData());

        return $anchor;
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
}
