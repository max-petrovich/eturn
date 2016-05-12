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

use Carbon\Carbon;


$factory->define(App\Models\Role::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->userName,
        'display_name' => $faker->name,
        'description' => $faker->text(),
    ];
});

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->userName,
        'email' => $faker->safeEmail,
        'password' => bcrypt(123456),
        'remember_token' => str_random(10),
    ];
});

/*$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->userName,
        'email' => $faker->safeEmail,
        'user_group' => rand(3,4),
        'fullname' => $faker->name,
        'password' => Maxic\DleAuth\DleCrypt::crypt($faker->password),
        'remember_token' => str_random(10),
    ];
});*/

$factory->define(App\Models\Service::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->unique()->sentence(4),
        'description' => $faker->text(200),
    ];
});

$factory->define(App\Models\AdditionalService::class, function (Faker\Generator $faker) {
    return [
//        'service_id' => function() {
//            return factory(App\Models\Service::class)->create()->id;
//        },
        'title' => $faker->name,
        'description' => $faker->text(200)
    ];
});

$factory->define(App\Models\ClosedDate::class, function (Faker\Generator $faker) {
    return [
        'closed_date' => $faker->unique()->date
    ];
});

$factory->define(App\Models\Order::class, function (Faker\Generator $faker) {
    return [
//        'client_user_id' => function() {
//            return factory(App\Models\User::class)->create()->id;
//        },
//        'master_user_id' => function() {
//            return factory(App\Models\User::class)->create()->id;
//        },
//        'service_id' => function() {
//            return factory(App\Models\Service::class)->create()->id;
//        },
        'client_name' => $faker->userName,
        'client_phone' => $faker->phoneNumber,
        'note' => $faker->paragraph(),
//        'payment_type_id' => function() {
//            return factory(App\Models\PaymentType::class)->create()->id;
//        },
        'visit_start' => $faker->dateTime,
        'visit_end' => $faker->dateTime,
        'status' => $faker->numberBetween(0,10)
    ];
});

$factory->define(App\Models\CanceledOrder::class, function (Faker\Generator $faker) {
    return [
//        'order_id' => function() {
//            return factory(App\Models\Order::class)->create()->id;
//        },
        'cancellation_time' => Carbon::now()
    ];
});

$factory->define(App\Models\OrderHiddenUser::class, function (Faker\Generator $faker) {
    return [
//        'user_id' => function() {
//            return factory(App\Models\User::class)->create()->id;
//        },
//        'order_id' => function() {
//            return factory(App\Models\Order::class)->create()->id;
//        }
    ];
});

$factory->define(App\Models\PaymentType::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->unique()->name,
        'name'  => $faker->unique()->name
    ];
});

$factory->define(App\Models\UserSchedule::class, function (Faker\Generator $faker) {
    return [
//        'user_id' => function() {
//            return factory(App\Models\User::class)->create()->id;
//        },
        'weekday' => $faker->numberBetween(0,6),
        'time_start' => Carbon::createFromTime(rand(7,9),0,0)->toTimeString(),
        'time_end' => Carbon::createFromTime(rand(16,20),0,0)->toTimeString()
    ];
});

$factory->define(App\Models\UserScheduleException::class, function (Faker\Generator $faker) {
    return [
//        'user_id' => function() {
//            return factory(App\Models\User::class)->create()->id;
//        },
        'exception_date' => Carbon::now()->addDays(rand(1,40))->toDateString(),
        'time_start' => Carbon::createFromTime(rand(7,9),0,0)->toTimeString(),
        'time_end' => Carbon::createFromTime(rand(16,20),0,0)->toTimeString()
    ];
});

$factory->define(App\Models\SystemSettings::class, function (Faker\Generator $faker) {
    return [
        'key' => str_slug($faker->unique()->name),
        'value' => $faker->name
    ];
});