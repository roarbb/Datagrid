<?php namespace Datagrid\Tests;

use Datagrid\BasicElements\Row;
use Datagrid\Utils\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    private $data;

    /** @var Parser */
    private $parser;

    public function setUp()
    {
        $data = array();
        $data[] = array('name' => 'Matej', 'age' => 28);
        $data[] = array('name' => 'Mark', 'age' => 45);

        $this->data = $data;
        $this->parser = new Parser();
    }

    public function testShouldBeAbleProduceArrayOfRows()
    {
        $parsed = $this->parser->dataToRows($this->data, array());

        $this->assertEquals(count($this->data), count($parsed));
        $this->assertInstanceOf("Datagrid\\BasicElements\\Row", $parsed[0]);
    }

    public function testShouldBeAbleProduceArrayOfActionButtons()
    {
        $actionData = array(
            array('label', 'url'),
            array('label2', 'url2'),
        );
        $row = new Row($this->data, array());

        $actionButtonsArray = $this->parser->actionsToActionButtons($actionData, $row);

        $this->assertEquals(count($actionButtonsArray), count($actionData));
        $this->assertInstanceOf("Datagrid\\BasicElements\\ActionButton", $actionButtonsArray[0]);
    }

    public function testShouldBeAbleToProduceArrayOfCells()
    {
        $cellData = $this->data[0];

        $cellsArray = $this->parser->rowDataToCells($cellData);

        $this->assertEquals(count($cellData), count($cellsArray));
        $this->assertInstanceOf("Datagrid\\BasicElements\\Cell", $cellsArray[0]);
    }
}
