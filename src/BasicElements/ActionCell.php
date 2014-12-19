<?php namespace Datagrid\BasicElements;


use Datagrid\Utils\Parser;
use Nette\Utils\Html;

class ActionCell implements IBasicElement
{
    private $actionButtons;

    public function __construct(array $actions, Row $row)
    {
        $parser = new Parser();
        $this->actionButtons = $parser->actionsToActionButtons($actions, $row);
    }

    public function render()
    {
        $td = Html::el('td', array('class' => 'row-actions'));

        /** @var ActionButton $button */
        foreach ($this->actionButtons as $button) {
            $td->add($button->render());
            $td->add('&nbsp;');
        }

        return $td;
    }
}