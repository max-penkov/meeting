<?php

/** @var Factory $factory */

use App\Event;
use App\Member;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Member::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name'  => $faker->lastName,
        'email'      => $faker->email,
        'event_id'   => function () {
            return factory(Event::class)->create()->id;
        },
    ];
});
