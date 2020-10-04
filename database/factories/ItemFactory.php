<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Item;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'item_name' => $faker->randomElement($array = array('Microwave','Lamp','Shoes', 'Hairbrush', 'Hamster Wheel', 'Nintendo', 'Sega Genesis')),
        'description' => $faker->text($maxNbChars=200),
        'image' => $faker->randomElement($array = ['https://source.unsplash.com/random', 'https://source.unsplash.com/users/erondu']),
        'price' => $faker->numberBetween(1, 200),
        'number_available' => $faker->numberBetween(1, 10)
    ];
});
