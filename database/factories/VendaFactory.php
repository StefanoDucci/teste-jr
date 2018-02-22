<?php

use Faker\Generator as Faker;

$factory->define(App\Venda::class, function (Faker $faker) {
    return [
        'nome' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'valor_venda' => $faker->randomFloat($nbMaxDecimals = 2, $min = 100, $max = 1000)
    ];
});
