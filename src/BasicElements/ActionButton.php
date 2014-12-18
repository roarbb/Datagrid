<?php namespace Datagrid\BasicElements;


use Nette\Utils\Html;

class ActionButton implements IBasicElement
{
    private $label;
    private $rawUrl;

    public function __construct($label, $rawUrl)
    {
        $this->label = $label;
        $this->rawUrl = $rawUrl;
    }

    public function render()
    {
        $a = Html::el('a');

        $attributes = array();
        $attributes['type'] = 'button';
        $attributes['class'] = 'btn btn-primary btn-xs';
        $attributes['href'] = $this->rawUrl;

        $a->addAttributes($attributes);

        $a->setText($this->label);

        return $a;
    }
}