<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Conference::class, function( Faker\Generator $faker){

    $title = $faker->sentence;

    return [
        'title' => $title,
        'youtube_id' => $faker->url,
        'description' => $faker->paragraphs(3, true),
        'slug' => str_slug($title),
        'is_valid' => 1
    ];

});

$factory->define(App\Models\Category::class, function( Faker\Generator $faker){

    return [
        'name' => $faker->word
    ];

});

$factory->define(App\Models\Tuto::class, function(Faker\Generator $faker){
    return [
        'title' => $faker->sentence,
        'youtube_id' => "BF12mRFeyL4",
        'langue_id' => 1,
        'description' => $faker->paragraphs(3, true),
        'channel_name' => "Great Channel",
        'is_valid' => 1
    ];
});

$factory->define(App\Models\TutoPart::class, function(Faker\Generator $faker){
    return [
        'youtube_id' => "fOTpxUCF30o",
        'title' => $faker->sentence
    ];
});