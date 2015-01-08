<?php namespace Datagrid\Renderer;


use Datagrid\BasicElements\Footer;
use Datagrid\BasicElements\Row;
use Datagrid\Service\HttpService;
use Datagrid\Sorter\RowSorter;
use Datagrid\Utils\ArrayHandler;
use Datagrid\Utils\Parser;
use Nette\Utils\Html;
use Nette\Utils\Paginator;

class DefaultRenderer
{
    private $htmlTableClass = '';
    private $headerLabels = array();
    private $sortingEnabled = false;
    private $rowActions = array();
    private $hidedColumns = array();
    /** @var Paginator */
    private $paginator;
    private $html;

    public function __construct()
    {
        $this->html = new Html();
    }

    public function getDatagrid($data)
    {
        $parser = new Parser();

        $output = $this->html->el('div')->addAttributes(array('class' => 'datagride'));
        $rows = $parser->dataToRows($data, $this->hidedColumns);
        $this->buildTable($rows, $output);
        $this->buildFooter($output);

        return $output;
    }

    private function buildTable(array $rows, Html $output)
    {
        $table = $this->html->el('table');

        $this->buildTableClass($table);
        $this->buildHeaderRow($table);
        $this->buildTableRows($table, $rows);

        $output->add($table);
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
            $headerRow = new Row($this->headerLabels, $this->hidedColumns);
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

        if ($this->paginator) {
            $this->paginator->setPage($httpService->getPaginatorPage());
            $this->paginator->setItemCount(count($rows));

            $rows = array_slice($rows, $this->paginator->offset, $this->paginator->itemsPerPage);
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

    public function setHeader(array $headerLabels, array $columnNames)
    {
        $combined = array_combine($columnNames, $headerLabels);

        if(!$combined) {
            throw new \InvalidArgumentException('Header row names count does not match row cells count.');
        }

        $this->headerLabels = $combined;
    }

    public function enableSorting()
    {
        $this->sortingEnabled = true;
    }

    public function addtAction($label, $actionUrl)
    {
        $this->rowActions[] = array($label, $actionUrl);
    }

    public function hideColumns($columns)
    {
        $this->hidedColumns = $columns;
    }

    public function setPaginator($paginator)
    {
        $this->paginator = $paginator;
    }

    private function buildFooter(Html $output)
    {
        $footer = new Footer($this->paginator);
        $footerObject = $footer->render();

        $output->add($footerObject);
    }
}