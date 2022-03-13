<?php
declare(strict_types=1);

use nerodemiurgo\data_processing\CsvImporter;

require_once '../../vendor/autoload.php';

$loader_categories = new CsvImporter('\categories.csv', 'category', ['name', 'icon']);
$categories_sql = $loader_categories->makeSql();

$loader_cities = new CsvImporter('\cities.csv', 'city', ['name', 'lat', 'lng']);
$cities_sql = $loader_cities->makeSql();


