<?php
declare(strict_types=1);

use nerodemiurgo\data_processing\CsvImporter;
use nerodemiurgo\ex\FileFormatException;

require_once "vendor/autoload.php";

$loader_categories = new CsvImporter('\categories.csv', 'category', ['name', 'icon']);
try {
    $categories_sql = $loader_categories->makeSql();
} catch (FileFormatException $e) {
    print_r("Ошибка: ".$e);
}

$loader_cities = new CsvImporter('\cities.csv', 'city', ['name', 'lat', 'lng']);
try {
    $cities_sql = $loader_cities->makeSql();
} catch (FileFormatException $e) {
    print_r("Ошибка: ".$e);
}


