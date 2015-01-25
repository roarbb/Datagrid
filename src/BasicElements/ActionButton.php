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
    private $html;

    public function __construct($label, $rawUrl, Row $row)
    {
        $this->label = $label;
        $this->rawUrl = $rawUrl;
        $this->row = $row;
        $this->html = new Html();
    }

    public function render()
    {
        $anchor = $this->html->el('a');

        $attributes = array();
        $attributes['type'] = 'button';
        $attributes['class'] = 'btn btn-primary btn-xs ' . Strings::webalize($this->label);
        $attributes['href'] = $this->getTranslatedUrl($this->rawUrl);

        $anchor->addAttributes($attributes);

        $anchor->setText($this->label);

        return $anchor;
    }

    private function getTranslatedUrl($rawUrl)
    {
        return preg_replace_callback(
            '/{([A-Za-z0-9_]+)}/',
            array($this, 'translateMatch'),
            $rawUrl
        );
    }

    /**
     * @param $matches
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     */
    private function translateMatch($matches)
    {
        $cellName = $matches[1];

        /** @var Cell $cell */
        $cell = $this->row->getCellByCellName($cellName);

        if (!$cell) {
            return $matches[0];
        }

        return $cell->getCellData();
    }
}
