<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Widget;
use Faker\Generator as Faker;

$factory->define(Widget::class, function (Faker $faker) {
    return [
        'name'=> $faker->name,
        'category_id' => function () {
            $category_id = factory(App\Models\Category::class)->create()->id;
            return $category_id;
        }
    ];
});
