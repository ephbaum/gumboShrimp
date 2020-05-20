<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Item;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'item_name' => $faker->randomElement($array = array('Microwave','Lamp','Shoes', 'Hairbrush', 'Hamster Wheel', 'Nintendo', 'Sega Genesis')),
        'description' => $faker->text($maxNbChars=200),
        'image' => 'http://via.placeholder.com/150',
        'price' => $faker->numberBetween(1, 200),
        'number_available' => $faker->numberBetween(1, 10)
    ];
});
