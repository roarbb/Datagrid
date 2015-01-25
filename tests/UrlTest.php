<?php namespace Datagrid\Tests;

use Datagrid\Utils\Url;

class UrlTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['SERVER_NAME'] = 'www.google.com';
        $_SERVER['REQUEST_URI'] = '/?search=name&format=json';
    }

    public function testShouldReturnFullUrlBasedOnServerVariable()
    {
        $url = new Url();
        $this->assertEquals('http://www.google.com/?search=name&format=json', strval($url));
    }

    public function testShouldReturnQueryAsArray()
    {
        $url = new Url();

        $expectedQuery = array(
            'search' => 'name',
            'format' => 'json',
        );

        $this->assertEquals($expectedQuery, $url->getQuery());
    }

    public function testQueryCanBeReplaced()
    {
        $newQuery = array(
            'search' => 'age',
            'format' => 'json',
            'exclude' => 'nothing',
        );

        $url = new Url();
        $url->setNewQuery($newQuery);

        $this->assertEquals('http://www.google.com/?search=age&format=json&exclude=nothing', strval($url));
    }
}
