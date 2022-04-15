<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
$faker = Faker\Factory::create('ru_RU');
return [
    'created_at' => $faker->dateTimeBetween('2021-01-01 00:00:00', '2022-04-14 23:00:00')->format('Y-m-d H:i:s'),
    'name' => $faker->sentence($nbWords = 2, $variableNbWords = true),
    'description' => $faker->realTextBetween($minNbChars = 160, $maxNbChars = 250, $indexSize = 2),
    'category_id' => $faker->numberBetween(1,8),
    'budget' => $faker->numberBetween(300,10000),
    'finished_at' =>$faker->dateTimeBetween('2021-01-10 00:00:00', '2022-12-31 23:00:00')->format('Y-m-d H:i:s'),
    'status'=> $faker->randomElement($array = ['STATUS_NEW', 'STATUS_DONE', 'STATUS_CANCELED', 'STATUS_PROGRESS', 'STATUS_FAILED']),
    'city_id' => $faker->numberBetween(1, 1000),
    'customer_user_id' => $faker->numberBetween(1,10),
    'executor_user_id' => $faker->numberBetween(11,20),

];