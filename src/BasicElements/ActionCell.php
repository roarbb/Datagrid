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
        $this->html = new Html();
    }

    public function render()
    {
        $tableData = $this->html->el('td', array('class' => 'row-actions'));

        /** @var ActionButton $button */
        foreach ($this->actionButtons as $button) {
            $tableData->add($button->render());
            $tableData->add('&nbsp;');
        }

        return $tableData;
    }
}
