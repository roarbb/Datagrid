<?php namespace Datagrid\BasicElements;


use Datagrid\Service\HttpService;
use Nette\Utils\Html;

class Cell implements IBasicElement
{
    private $columnName;
    private $cellData;

    public function __construct($columnName, $cellData)
    {
        $this->columnName = $columnName;
        $this->cellData = $cellData;
    }

    public function render()
    {
        $td = Html::el('td')->addAttributes(array('class' => 'cell'));
        $td->setText($this->getCellData());

        return $td;
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
        $th = Html::el('th');

        if ($sortingEnabled) {
            $cellContent = $this->getSortingAnchor();
        } else {
            $cellContent = $this->getCellData();
        }

        $th->setText($cellContent);

        return $th;
    }

    private function getSortingAnchor()
    {
        $httpService = new HttpService();
        $a = Html::el('a');

        $attributes = array();
        $attributes['href'] = $httpService->getSortUrl($this->getColumnName());

        $a->addAttributes($attributes);

        $a->setText($this->getCellData());

        return $a;
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