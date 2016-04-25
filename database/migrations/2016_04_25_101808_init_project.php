<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Pivot table for AdditionalService & Order
         */
        Schema::create('additional_service_order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('additional_service_id');
            $table->timestamps();
        });

        /**
         * Pivot table for AdditionalService & User
         */
        Schema::create('additional_service_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('additional_service_id');
            $table->decimal('price',10, 2);
            $table->integer('duration');
            $table->timestamps();
        });

        /**
         * Additional Services
         */
        Schema::create('additional_services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_id');
            $table->string('title');
            $table->text('description');
            $table->timestamps();
        });

        /**
         * Canceled Orders - orders that client has canceled
         */
        Schema::create('canceled_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->timestamp('cancellation_time');
            $table->timestamps();
        });

        /**
         * Closed Days - dates in which institution is closed
         */
        Schema::create('closed_days', function (Blueprint $table) {
            $table->date('closed_date')->unique();
            $table->timestamps();
        });

        /**
         * hidden_order_monitoring PIVOT table
         * TODO description
         */
        Schema::create('hidden_order_monitoring', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('order_id');
            $table->timestamps();
        });

        /**
         * Orders
         */
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_user_id');
            $table->integer('master_user_id');
            $table->integer('service_id');
            $table->string('client_name');
            $table->string('client_phone');
            $table->text('note');
            $table->integer('payment_type_id');
            $table->timestamp('visit_datetime');
            $table->tinyInteger('status');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * Payment types
         */
        Schema::create('payment_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });

        /**
         * Pivot table for Services & Users
         */
        Schema::create('service_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('service_id');
            $table->decimal('price', 10, 2);
            $table->integer('duration');
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
            $table->integer('user_id');
            $table->date('exception_date');
            $table->time('time_start');
            $table->time('time_end');
            $table->timestamps();
        });

        /**
         * User Schedule
         */
        Schema::create('user_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->tinyInteger('weekday');
            $table->time('time_start');
            $table->time('time_end');
            $table->timestamps();
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
        Schema::drop('hidden_order_monitoring');
        Schema::drop('orders');
        Schema::drop('payment_types');
        Schema::drop('service_user');
        Schema::drop('services');
        Schema::drop('system_settings');
        Schema::drop('user_schedule_exceptions');
        Schema::drop('user_schedules');

    }
}
