<?php

use Tracy\Debugger;

require_once('vendor/autoload.php');
Debugger::enable();
Debugger::$maxDepth = 10;

function getData($rowsCount) {
    $faker = \Faker\Factory::create();
    $rows = array();

    for ($i = 0; $i < $rowsCount; $i++) {
        $rows[] = array(
            'name' => $faker->firstName,
            'surname' => $faker->lastName,
            'age' => $faker->numberBetween(20, 45),
            'position' => $faker->randomElement(array('developer', 'sales', 'management')),
            'pass' => 'pass',
        );
    }

    return $rows;
}

$data = getData(20);

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