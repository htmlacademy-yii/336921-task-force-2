<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

return [
    'task_id' => $faker->numberBetween(1,100),
    'file_url' => $faker->file('data/files', 'data/uploads', false)
];