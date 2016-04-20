<?php

use App\Models\PaymentType;
use App\Models\Service;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DatabaseModelInteractionsTest extends TestCase
{
    use DatabaseTransactions;
    use SoftDeletes;

    public function testCreateOrder()
    {
        $users = factory(App\Models\User::class, 2)
            ->create();

        $service = factory(App\Models\Service::class)
            ->create();

        $additionalServices = factory(App\Models\AdditionalService::class, 3)
            ->make([
                'service_id' => null
            ])
            ->each(function($adService) use($service) {
                $service->additionalServices()->save($adService);
            });

        /**
         * Attach services to user-master
         */
        $client = $users[0];
        $master = $users[1];

        $master->services()->attach($service, [
            'price' => 150,
            'duration' => 30
        ]);

        /**
         * Attach additional services to user-master
         */
        $master->additionalServices()->attach($additionalServices, [
            'price' => 200,
            'duration' => 30,
        ]);

        /**
         * Payment types
         */

        $paymentTypes = factory(App\Models\PaymentType::class,3)
            ->create();

        $order = new App\Models\Order;
        $order->client()->associate($client);
        $order->master()->associate($master);
        $order->service()->associate($service);
        $order->paymentType()->associate($paymentTypes->random(1));

        $order->save();

        /**
         * Attach additional services to order
         */
        $order->additionalServices()->saveMany($master->additionalServices()->take(2)->get());

        /**
         * Soft delete order (order remains in the database, but marked as deleted)
         */

        $order->delete();

        $this->assertTrue($order->trashed());
    }
}
