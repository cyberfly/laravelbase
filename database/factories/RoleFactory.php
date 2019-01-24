<?php

use App\Models\SpatiePermission\WebRole;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(WebRole::class, function (Faker $faker) {

    $name = $faker->domainWord;
    $display_name = $name;
    $description = $name;

    return [
        'name' => $name,
        'display_name' => $display_name,
        'description' => $description,
    ];

});
