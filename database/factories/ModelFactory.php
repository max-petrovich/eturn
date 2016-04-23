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

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => Maxic\DleAuth\DleCrypt::crypt($faker->password),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Service::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->unique()->name,
        'description' => $faker->text(200),
    ];
});

$factory->define(App\Models\AdditionalService::class, function (Faker\Generator $faker) {
    return [
        'service_id' => function() {
            return factory(App\Models\Service::class)->create()->id;
        },
        'title' => $faker->name,
        'description' => $faker->text(200)
    ];
});

$factory->define(App\Models\ClosedDay::class, function (Faker\Generator $faker) {
    return [
        'closed_date' => $faker->unique()->date(),
    ];
});

$factory->define(App\Models\Order::class, function (Faker\Generator $faker) {
    return [
        'client_user_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        },
        'master_user_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        },
        'service_id' => function() {
            return factory(App\Models\Service::class)->create()->id;
        },
        'client_name' => $faker->name,
        'client_phone' => $faker->phoneNumber,
        'note' => $faker->paragraph(),
        'payment_type_id' => function() {
            return factory(App\Models\PaymentType::class)->create()->id;
        },
        'visit_datetime' => $faker->dateTime,
        'status' => $faker->numberBetween(0,10)
    ];
});

$factory->define(App\Models\CanceledOrder::class, function (Faker\Generator $faker) {
    return [
        'order_id' => function() {
            return factory(App\Models\Order::class)->create()->id;
        },
        'cancellation_time' => $faker->time(),
    ];
});

$factory->define(App\Models\HiddenOrderMonitoring::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        },
        'order_id' => function() {
            return factory(App\Models\Order::class)->create()->id;
        }
    ];
});

$factory->define(App\Models\PaymentType::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->unique()->name
    ];
});

$factory->define(App\Models\UserSchedule::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        },
        'weekday' => $faker->numberBetween(0,6),
        'time_start' => $faker->time(),
        'time_end' => $faker->time()
    ];
});

$factory->define(App\Models\UserScheduleException::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        },
        'exception_date' => $faker->date(),
        'time_start' => $faker->time(),
        'time_end' => $faker->time()
    ];
});

$factory->define(App\Models\SystemSettings::class, function (Faker\Generator $faker) {
    return [
        'key' => $faker->unique()->name,
        'value' => $faker->name
    ];
});