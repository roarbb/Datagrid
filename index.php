<?php

use Tracy\Debugger;

require_once('vendor/autoload.php');
Debugger::enable();
Debugger::$maxDepth = 10;

$data = array(
    'row1' => array(
        'name' => 'Matej',
        'surname' => 'Sajgal',
        'age' => 28,
        'position' => 'Developer',
        'pass' => 'pass',
    ),
    'row2' => array(
        'name' => 'Max',
        'surname' => 'Pak',
        'age' => 32,
        'position' => 'Team Leader',
        'pass' => 'pass2',
    ),
    array(
        'name' => 'John',
        'surname' => 'Doe',
        'age' => 30,
        'position' => 'Developer',
        'pass' => '',
    ),
);

$datagrid = new \Datagrid\Datagrid();
$datagrid->setData($data);
$datagrid->setTableClass('table');
$datagrid->addHeader(['name' => 'First name', 'surname' => 'Surname', 'age' => 'Age', 'position' => 'Position', 'pass' => 'Password']);
$datagrid->isSortable();
$datagrid->hideColumns(['pass']);

$datagrid->addAction('Edit Row', 'http://localhost/datagrid/editRow/{name}/{surname}/{age}');
$datagrid->addAction('Delete Row', 'http://localhost/datagrid/delete/{name}');

$latte = new Latte\Engine;
$latte->render(__DIR__ . '/templates/template.latte', array('table' => $datagrid));