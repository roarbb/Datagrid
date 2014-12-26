<?php namespace Datagrid;


use Datagrid\Renderer\DefaultRenderer;
use Datagrid\Service\DownloadService;
use Datagrid\Service\MessageService;
use Nette\Utils\Paginator;

class Datagrid
{
    private $data = array();

    /** @var DefaultRenderer */
    private $renderer;

    /** @var MessageService */
    private $message;

    public function __construct()
    {
        $this->renderer = new DefaultRenderer();
    }

    public function setData($data, $format = "json")
    {
        if(!is_array($data)) {
            $downloader = new DownloadService($data, $format);
            $data = $downloader->getData();
        }

        if($data instanceof MessageService) {
            $this->message = $data;
            $data = array();
        }

        $this->data = $data;
    }

    public function __toString()
    {
        if($this->message) {
            return strval($this->message);
        }

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
