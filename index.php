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
        'position' => 'Junior',
        'position' => 'Developer',
        'password' => 'pass',
    ),
    'row2' => array(
        'name' => 'Max',
        'surname' => 'Pak',
        'age' => 32,
        'position' => 'Senior',
        'position' => 'Team Leader',
        'password' => 'pass2',
    ),
);

$datagrid = new \Datagrid\Datagrid();
$datagrid->setData($data);

echo $datagrid;