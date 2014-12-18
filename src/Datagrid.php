<?php namespace Datagrid;


use Datagrid\Renderer\DefaultRenderer;

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
        $tableObject = $this->renderer->getTable($this->data);

        return strval($tableObject);
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
}
