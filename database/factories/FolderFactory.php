<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Folder;
use Faker\Generator as Faker;

$factory->define(Folder::class, function (Faker $faker) {
    return [
        'numFolder' => 4848,
        'name' => $faker->name,
        'piece' => 3,
        'status' => 'on_step',
        'dateArrive' => new \DateTime(),
        'achat' => 0,
        'vente' => 0,
        'facture' => 0,
        'banque' => 0,
        'divers' => 0,
        'user_id' => 1
    ];
});
