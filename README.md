# Datagrid

Datagrid is PHP component to creating tables from a set of data.

## Installation

The recommended way to install Datagrid is through
[Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of Datagrid:

```bash
composer require roarbb/datagrid
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

## Basic usage

Let's have some array of data:
```php
$data = array(
    'row1' => array(
        'name' => 'Tyree',
        'surname' => 'Schmidt',
        'age' => '35',
        'position' => 'Developer',
        'pin' => '7366',
    ),
    'row2' => array(
        'name' => 'Cleve',
        'surname' => 'Streich',
        'age' => '38',
        'position' => 'Management',
        'pin' => '7290',
    ),
    'row3' => array(
        'name' => 'Mossie',
        'surname' => 'Lesch',
        'age' => '41',
        'position' => 'Sales',
        'pin' => '6521',
    ),
    'row4' => array(
        'name' => 'Kayla',
        'surname' => 'Paucek',
        'age' => '21',
        'position' => 'Developer',
        'pin' => '9478',
    ),
    'row5' => array(
        'name' => 'Elva',
        'surname' => 'Haley',
        'age' => '17',
        'position' => 'Management',
        'pin' => '4532',
    ),
);
```

Basic implementation of Datagrid:
```php
$datagrid = new Datagrid();
$datagrid->setData($data);
```

Then in template file:
```html
<h1>Datagrid</h1>
<?php echo $datagrid ?>
```

## More Options

### Json source
If you want to build table from valid JSON REST API response:
```php
$datagrid->setData('http://datagrid.sajgal.com/?getJson');
```

### Table html class attribute
If you are using [Bootstrap](http://getbootstrap.com/css/#tables) you may need to set css class to Datagrid.
```php
$datagrid->setTableClass('table');
```

### Header Row
You can set header row of Datagrid
```php
$datagrid->addHeader(['name' => 'First name', 'surname' => 'Surname', 'age' => 'Age', 'position' => 'Position', 'pin' => 'PIN Code']);
```

### Sorting
If you want to enable sorting of Datagrid rows
```php
$datagrid->isSortable();
```

### Hiding Columns
If you want to hide some of columns with sensitive content
```php
$datagrid->hideColumns(['pin']);
```

### Pagination
You can also enable pagination. You should pass **rows per page** integer as first argument. 
```php
$datagrid->setPagination(10);
```

### Action Buttons
If you want to add some buttons at the end of each row. You can use placeholders: `{name}` will be translated to `Tyree` etc.
```php
$datagrid->addAction('Delete Row', 'http://datagrid.sajgal.com/delete/{name}');
```