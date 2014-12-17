<?php


namespace Datagrid;


class Datagrid
{
    private $rawData = array();

    public function setData($data)
    {
        $this->rawData = $data;
    }

    public function __toString()
    {
        $renderer = new DefaultRenderer;
        return $renderer->getHtmlTable($this->rawData);
    }
}
