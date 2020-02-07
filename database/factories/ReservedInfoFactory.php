<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\reserved_info;
use Faker\Generator as Faker;

$factory->define(App\ReservedInfo::class, function (Faker $faker) {
    return [
        'name' => '大阪太郎',
        'reserved_date' => '2020/02/10',
        'reserved_time' => '5',
        'price' => '3000',
        'mail_address' => 'hogehoge@gmail.com',
    ];
});
