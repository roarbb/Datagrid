<?php namespace Datagrid\Tests;

use Datagrid\BasicElements\Row;
use Datagrid\Sorter\RowSorter;

class RowSorterTest extends \PHPUnit_Framework_TestCase
{
    public function testAscSorting()
    {
        $rows = array();
        $rows[] = new Row(array('name' => 'b', 'age' => 28), array());
        $rows[] = new Row(array('name' => 'a', 'age' => 35), array());

        $rowSorter = new RowSorter($rows);
        $sortedRows = $rowSorter->sortRowsByCell('name', 'ASC');

        $this->assertNotEquals($rows[0], $sortedRows[0]);
    }

    public function testDescSorting()
    {
        $rows = array();
        $rows[] = new Row(array('name' => 'a', 'age' => 35), array());
        $rows[] = new Row(array('name' => 'b', 'age' => 28), array());

        $rowSorter = new RowSorter($rows);
        $sortedRows = $rowSorter->sortRowsByCell('name', 'DESC');

        $this->assertNotEquals($rows[0], $sortedRows[0]);
    }
}
