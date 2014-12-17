<?php namespace Datagrid;


class Datagrid
{
    private $data = array();

    public function setData($data)
    {
        $this->data = $data;
    }

    public function __toString()
    {
        $renderer = new DefaultRenderer;
        $tableObject = $renderer->getTable($this->data);

        return strval($tableObject);
    }
}
