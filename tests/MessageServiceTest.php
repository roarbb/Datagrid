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
        $messageText = 'Msg';
        $message = new MessageService($messageText, $msgType);

        $this->assertEquals(
            sprintf('<div class="alert alert-%s" role="alert">%s</div>', $msgType, $messageText),
            strval($message)
        );
    }
}
