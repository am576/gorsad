<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $faker->word(),
        'code'  => $faker->ean8(),
        'description' => $faker->sentence(6),
        'category_id' => App\Category::first(),
        'price' =>      $faker->numberBetween(10, 1000),
        'discount' => 0,
        'status' => $faker->boolean(80),
        'quantity' => $faker->numberBetween(0,100)
    ];
});
