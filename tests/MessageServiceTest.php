<?php namespace Datagrid\Tests;

use Datagrid\Service\MessageService;

class MessageServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testObjectCanBeConstructedwithoutType()
    {
        $message = new MessageService('test');
        $this->assertInstanceOf('Datagrid\\Service\\MessageService', $message);
    }

    public function testStringValShouldReturnDiv()
    {
        $msgType = 'type';
        $message = new MessageService('Msg', $msgType);

        $this->assertEquals(
            '<div class="alert alert-' . $msgType . '" role="alert">Msg</div>',
            strval($message)
        );
    }
}
