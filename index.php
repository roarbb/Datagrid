<?php

use Datagrid\Datagrid;
use Tracy\Debugger;

require_once('vendor/autoload.php');
Debugger::enable();
Debugger::$maxDepth = 10;

tryToOutputJson();

$data = getData(120);
//$data = getStaticData();

$datagrid = new Datagrid();
$datagrid->setData($data);
//$datagrid->setData('http://localhost/datagrid/?getJson');
$datagrid->setTableClass('table');
$datagrid->addHeader(['name' => 'First name', 'surname' => 'Surname', 'age' => 'Age', 'position' => 'Position', 'pin' => 'PIN Code']);
$datagrid->isSortable();
$datagrid->hideColumns(['pin']);
$datagrid->setPagination(10);

$datagrid->addAction('Edit Row', 'http://localhost/datagrid/editRow/{name}/{surname}/{age}');
$datagrid->addAction('Delete Row', 'http://localhost/datagrid/delete/{name}');

$latte = new Latte\Engine;
$latte->render(__DIR__ . '/templates/template.latte', array('datagrid' => $datagrid));

// ---------------------------------------------------------------------------------------

function getData($rowsCount) {
    $faker = \Faker\Factory::create();
    $rows = array();

    for ($i = 0; $i < $rowsCount; $i++) {
        $rows[] = array(
            'name' => $faker->firstName,
            'surname' => $faker->lastName,
            'age' => $faker->numberBetween(20, 45),
            'position' => $faker->randomElement(array('developer', 'sales', 'management')),
            'pin' => $faker->numberBetween(1000,9999),
        );
    }

    return $rows;
}

function getStaticData()
{
    $rows[] = array(
        'name' => 'Matej',
        'surname' => 'Sajgal',
        'age' => '28',
        'position' => 'Software Developer',
        'pin' => '1234',
    );
    $rows[] = array(
        'name' => 'Veronika',
        'surname' => 'Poduskova',
        'age' => '22',
        'position' => 'Software Developer',
        'pin' => '1234',
    );
    $rows[] = array(
        'name' => 'Tomas',
        'surname' => 'Sajgal',
        'age' => '27',
        'position' => 'Software Developer',
        'pin' => '1234',
    );
    $rows[] = array(
        'name' => 'Helena',
        'surname' => 'Oravcova',
        'age' => '43',
        'position' => 'Software Developer',
        'pin' => '1234',
    );
    $rows[] = array(
        'name' => 'Pavel',
        'surname' => 'Oravec',
        'age' => '17',
        'position' => 'Software Developer',
        'pin' => '1234',
    );

    return $rows;
}

function tryToOutputJson()
{
    if(!isset($_GET['getJson'])) {
        return false;
    }

    Debugger::enable(Debugger::PRODUCTION);
    echo json_encode(getData(120));
    Debugger::enable();
    exit;
}