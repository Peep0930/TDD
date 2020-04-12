<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'date' => $faker->dateTimeBetween('-30 days', '+30 days'),
        'content' => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'is_Public' => 1,
        'user_id' => factory(User::class),
    ];
});
