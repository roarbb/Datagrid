<?php namespace Datagrid\BasicElements;


use Nette\Utils\Html;

class ActionButton implements IBasicElement
{
    /**
     * @var Row
     */
    private $row;
    private $label;
    private $rawUrl;

    public function __construct($label, $rawUrl, Row $row)
    {
        $this->label = $label;
        $this->rawUrl = $rawUrl;
        $this->row = $row;
    }

    public function render()
    {
        $a = Html::el('a');

        $attributes = array();
        $attributes['type'] = 'button';
        $attributes['class'] = 'btn btn-primary btn-xs';
        $attributes['href'] = $this->getTranslatedUrl($this->rawUrl);

        $a->addAttributes($attributes);

        $a->setText($this->label);

        return $a;
    }

    private function getTranslatedUrl($rawUrl)
    {
        return preg_replace_callback(
            '/{([A-Za-z0-9_]+)}/',
            array($this, 'translateMatch'),
            $rawUrl
        );
    }

    private function translateMatch($matches)
    {
        $cellName = $matches[1];

        /** @var Cell $cell */
        $cell = $this->row->getCellByCellName($cellName);

        if(!$cell) {
            return $matches[0];
        }

        return $cell->getCellData();
    }

}