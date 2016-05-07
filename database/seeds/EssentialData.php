<?php

use Bican\Roles\Models\Role;
use Illuminate\Database\Seeder;

class EssentialData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Create user roles
         */
        Role::create([
            'name' => 'Администратор',
            'slug' => 'admin'
        ]);

        Role::create([
            'name' => 'Мастер',
            'slug' => 'master'
        ]);

        Role::create([
            'name' => 'Клиент',
            'slug' => 'client'
        ]);


        /**
         * Payments methods
         */

        factory(App\Models\PaymentType::class)->create(['title' => trans('payment.credit_card')]);
        factory(App\Models\PaymentType::class)->create(['title' => trans('payment.bank_card')]);
        factory(App\Models\PaymentType::class)->create(['title' => trans('payment.cash')]);
    }
}
