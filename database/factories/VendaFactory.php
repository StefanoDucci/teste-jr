<?php

use Faker\Generator as Faker;

$factory->define(App\Venda::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'comissao' => rand(100, 1000) * 0.085
    ];
});
