<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */

$factory->define(App\Program::class, function (Faker $faker){

    return [

        'name'=>$faker->name,
        'desc'=>$faker->desc,
        'email'=>$faker->email,
        'password'=>$faker->password_hash
    ];
});