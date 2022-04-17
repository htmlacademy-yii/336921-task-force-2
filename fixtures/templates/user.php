<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
$faker = Faker\Factory::create('ru_RU');
return [

    'registered_at' => $faker->dateTimeBetween('2021-01-01 00:00:00', '2022-04-14 23:00:00')->format('Y-m-d H:i:s'),
    'status' => $faker->numberBetween(0, 1),
    'role' => $faker->randomElement($array = ['ROLE_CUSTOMER','ROLE_EXECUTOR']),
    'email' => $faker->unique()->email,
    'password' => $faker->unique()->password,
    'name' => $faker->name,
    'telephone' => $faker->unique()->numberBetween(79000000000, 79999999999),
    'telegram' => $faker->unique()->word,
    'birthday' => $faker->dateTimeBetween('1990-01-01', '2004-01-01')->format('Y-m-d'),
    'about' => $faker->realTextBetween($minNbChars = 160, $maxNbChars = 200, $indexSize = 2),
    'city_id' => $faker->numberBetween(1, 1000),
    'avatar' => $faker->imageUrl,
    'show_contact' => $faker->numberBetween(0, 1)

];