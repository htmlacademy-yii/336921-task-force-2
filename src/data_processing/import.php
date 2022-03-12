<?php
declare(strict_types=1);

use nerodemiurgo\ex\FileFormatException;
use nerodemiurgo\ex\SourceFileException;
use nerodemiurgo\data_processing\CsvImporter;

require_once '../../vendor/autoload.php';

$loader_categories = new CsvImporter('\categories.csv', 'category', ['name', 'icon']);
$categories_sql = $loader_categories->makeSql();
//print $categories_sql;

$loader_cities = new CsvImporter('\cities.csv', 'city', ['name', 'lat', 'long']);
//$cities_sql = $loader_cities->makeSql();
var_dump($loader_cities);
//print $cities_sql;


