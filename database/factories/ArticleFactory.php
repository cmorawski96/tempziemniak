<?php
/**
 * Created by PhpStorm.
 * User: cmora
 * Date: 28.04.2019
 * Time: 00:49
 */

$factory->define(App\Article::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'tags' => $faker->sentence,
        'links' => $faker->sentence
    ];
});
