<?php namespace Datagrid\Service;

use Nette\Utils\Html;

class MessageService
{
    private $message;
    private $type;

    public function __construct($message, $type = 'success')
    {
        $this->message = $message;
        $this->type = $type;
    }

    public function __toString()
    {
        $attributes = array(
            'class' => 'alert alert-' . $this->type,
            'role' => 'alert',
        );
        $div = Html::el('div')->addAttributes($attributes)->setText($this->message);

        return strval($div);
    }
}
