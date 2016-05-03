<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitProject extends Migration
{

    private $dleUserTable = '';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->dleUserTable = config('dleconfig.db_connection.database') . '.' . config('dleconfig.db_connection.prefix') . 'users';

        /**
         * Payment types
         */
        Schema::create('payment_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });

        /**
         * Services
         */
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        /**
         * Additional Services
         */
        Schema::create('additional_services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services');
        });

        /**
         * Orders
         */
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_user_id')->unsigned();
            $table->integer('master_user_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->string('client_name');
            $table->string('client_phone');
            $table->text('note');
            $table->integer('payment_type_id')->unsigned();
            $table->timestamp('visit_datetime');
            $table->tinyInteger('status');
            $table->timestamps();
            $table->softDeletes();

//            $table->foreign('client_user_id')->references('user_id')->on($this->dleUserTable);
//            $table->foreign('master_user_id')->references('user_id')->on($this->dleUserTable);
            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
        });

        /**
         * PIVOT table for AdditionalService & Order
         */
        Schema::create('additional_service_order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('additional_service_id')->unsigned();
            $table->timestamps();

            $table->unique(['order_id', 'additional_service_id']);

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('additional_service_id')->references('id')->on('additional_services');
        });

        /**
         * PIVOT table for AdditionalService & User
         */
        Schema::create('additional_service_user', function (Blueprint $table) {
//            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('additional_service_id')->unsigned();
            $table->decimal('price',10, 2);
            $table->integer('duration');
            $table->timestamps();

            $table->unique(['user_id', 'additional_service_id']);

//            $table->foreign('user_id')->references('user_id')->on($this->dleUserTable);
            $table->foreign('additional_service_id')->references('id')->on('additional_services');

        });

        /**
         * Canceled Orders - orders that client has canceled
         */
        Schema::create('canceled_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->timestamp('cancellation_time');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
        });

        /**
         * Closed Days - dates in which institution is closed
         */
        Schema::create('closed_days', function (Blueprint $table) {
            $table->date('closed_date')->unique();
            $table->timestamps();
        });

        /**
         * Orders that hidden from monitoring for specified user
         */
        Schema::create('order_hidden_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->timestamps();

            $table->unique(['user_id', 'order_id']);
//            $table->foreign('user_id')->references('user_id')->on($this->dleUserTable);
            $table->foreign('order_id')->references('id')->on('orders');
        });

        /**
         * Pivot table for Services & Users
         */
        Schema::create('service_user', function (Blueprint $table) {
//            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->decimal('price', 10, 2);
            $table->integer('duration');
            $table->timestamps();

            $table->unique(['user_id', 'service_id']);

//            $table->foreign('user_id')->references('user_id')->on($this->dleUserTable);
            $table->foreign('service_id')->references('id')->on('services');
        });

        /**
         * Services
         */
        Schema::create('system_settings', function (Blueprint $table) {
            $table->string('key')->unique();
            $table->string('value');
            $table->timestamps();
        });

        /**
         * User Schedule exceptions
         */
        Schema::create('user_schedule_exceptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->date('exception_date');
            $table->time('time_start');
            $table->time('time_end');
            $table->timestamps();

//            $table->foreign('user_id')->references('user_id')->on($this->dleUserTable);
        });

        /**
         * User Schedule
         */
        Schema::create('user_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('weekday');
            $table->time('time_start');
            $table->time('time_end');
            $table->timestamps();

//            $table->foreign('user_id')->references('user_id')->on($this->dleUserTable);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('additional_service_order');
        Schema::drop('additional_service_user');
        Schema::drop('additional_services');
        Schema::drop('canceled_orders');
        Schema::drop('closed_days');
        Schema::drop('order_hidden_users');
        Schema::drop('orders');
        Schema::drop('payment_types');
        Schema::drop('service_user');
        Schema::drop('services');
        Schema::drop('system_settings');
        Schema::drop('user_schedule_exceptions');
        Schema::drop('user_schedules');

    }
}
