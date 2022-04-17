<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
$faker = Faker\Factory::create('ru_RU');
return [
    'task_id' => $faker->numberBetween(1,9),
    'executor_id' => $faker->numberBetween(1,10),
    'comment' => $faker->text($maxNbChars = 250),
    'price' => $faker->numberBetween(100,10000)
];