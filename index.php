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
        'password' => 'pass',
    ),
    'row2' => array(
        'name' => 'Max',
        'surname' => 'Pak',
        'age' => 32,
        'position' => 'Team Leader',
        'password' => 'pass2',
    ),
);

$datagrid = new \Datagrid\Datagrid();
$datagrid->setData($data);


$latte = new Latte\Engine;
$latte->render(__DIR__ . '/templates/template.latte', array('table' => $datagrid));