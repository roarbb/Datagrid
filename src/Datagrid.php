<?php namespace Datagrid;


use Datagrid\Renderer\DefaultRenderer;
use Nette\Utils\Paginator;

class Datagrid
{
    private $data = array();

    /** @var DefaultRenderer */
    private $renderer;

    public function __construct()
    {
        $this->renderer = new DefaultRenderer();
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function __toString()
    {
        $datagridHtmlObject = $this->renderer->getDatagrid($this->data);

        return strval($datagridHtmlObject);
    }

    public function setTableClass($htmlClass)
    {
        $this->renderer->setHtmlTableClass($htmlClass);
    }

    public function addHeader(array $headerLabels)
    {
        $this->renderer->setHeader($headerLabels);
    }

    public function isSortable()
    {
        $this->renderer->enableSorting();
    }

    public function addAction($label, $actionUrl)
    {
        $this->renderer->addtAction($label, $actionUrl);
    }

    public function hideColumns($columns)
    {
        $this->renderer->hideColumns($columns);
    }

    public function setPagination($rowsPerPage = 20)
    {
        $paginator = new Paginator();
        $paginator->setItemsPerPage($rowsPerPage);
        $this->renderer->setPaginator($paginator);
    }
}
