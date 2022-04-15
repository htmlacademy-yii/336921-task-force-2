<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
$faker = Faker\Factory::create('ru_RU');
return [
    'executor_id' => $faker->numberBetween(1,10),
    'task_id' => $faker->numberBetween(1,20),
    'mark' => $faker->numberBetween(0,5),
    'comment' => $faker->text($maxNbChars = 250)
];