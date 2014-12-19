<?php namespace Datagrid\Renderer;


use Datagrid\BasicElements\Row;
use Datagrid\BasicElements\ActionCell;
use Datagrid\Service\HttpService;
use Datagrid\Sorter\RowSorter;
use Datagrid\Utils\Parser;
use Nette\Utils\Html;

class DefaultRenderer
{
    private $htmlTableClass = '';
    private $headerLabels = array();
    private $sortingEnabled = false;
    private $rowActions = array();

    public function getTable($data)
    {
        $parser = new Parser();
        $rows = $parser->dataToRows($data);
        $table = $this->buildTable($rows);

        return $table;
    }

    private function buildTable(array $rows)
    {
        $table = Html::el('table');

        $this->buildTableClass($table);
        $this->buildHeaderRow($table);
        $this->buildTableRows($table, $rows);

        return $table;
    }

    private function buildTableClass($table)
    {
        if (!empty($this->htmlTableClass)) {
            $table->addAttributes(array('class' => $this->htmlTableClass));
        }
    }

    private function buildHeaderRow($table)
    {
        if (!empty($this->headerLabels)) {
            $headerRow = new Row($this->headerLabels);
            $thead = $headerRow->renderHeaderRow($this->sortingEnabled);

            $table->add($thead);
        }
    }

    private function buildTableRows($table, $rows)
    {
        $httpService = new HttpService();

        if ($this->sortingEnabled && $httpService->sortingGetParamsAreSet()) {
            $rowSorter = new RowSorter($rows);
            $rows = $rowSorter->sortRowsByCell($httpService->getSortByValue(), $httpService->getSortDirection());
        }

        /** @var Row $row */
        foreach ($rows as $row) {
            $row->addActions($this->rowActions);
            $tr = $row->render();
            $table->add($tr);
        }
    }

    public function setHtmlTableClass($htmlTableClass)
    {
        $this->htmlTableClass = $htmlTableClass;
    }

    public function setHeader(array $headerLabels)
    {
        $this->headerLabels = $headerLabels;
    }

    public function enableSorting()
    {
        $this->sortingEnabled = true;
    }

    public function addtAction($label, $actionUrl)
    {
        $this->rowActions[] = array($label, $actionUrl);
    }
}