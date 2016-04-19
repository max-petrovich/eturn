<?php

use App\Models\AdditionalService;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DatabaseTestModelRelations extends TestCase
{

    use DatabaseTransactions;

    public function testOrder()
    {

        $users = factory(App\Models\User::class, 2)
            ->create();

        $service = factory(App\Models\Service::class)
            ->create();

        $paymentType = factory(App\Models\PaymentType::class)
            ->create();

        $order = factory(App\Models\Order::class)
            ->create([
                'client_user_id'  => $users[0]->id,
                'master_user_id'  => $users[1]->id,
                'service_id'      => $service->id,
                'payment_type_id' => $paymentType->id
            ]);

        $this->assertEquals($users[0]->id, $order->client->id);
        $this->assertEquals($users[1]->id, $order->master->id);
        $this->assertEquals($service->id, $order->service->id);
        $this->assertEquals($paymentType->id, $order->paymentType->id);
    }

    public function testAdditionalService()
    {
        $service = factory(App\Models\Service::class)
            ->create();

        $additionalService = factory(App\Models\AdditionalService::class)
            ->create([
               'service_id' => $service->id
            ]);

        $this->assertEquals($service->id, $additionalService->service->id);

    }

    public function testCanceledOrder()
    {
        $order = factory(App\Models\Order::class)
            ->create();

        $canceledOrder = factory(App\Models\CanceledOrder::class)
            ->create([
                'order_id' => $order->id
            ]);

        $this->assertEquals($order->id, $canceledOrder->order->id);
    }

    public function testHiddenOrderMonitoring()
    {
        $order = factory(App\Models\Order::class)
            ->create();

        $user = factory(App\Models\User::class)
            ->create();

        $hiddenOrderMonitoring = factory(App\Models\HiddenOrderMonitoring::class)
            ->create([
                'user_id' => $user->id,
                'order_id' => $order->id
            ]);

        $this->assertEquals($user->id, $hiddenOrderMonitoring->user->id);
        $this->assertEquals($order->id, $hiddenOrderMonitoring->order->id);
    }

    public function testMasterSchedule()
    {
        $user = factory(App\Models\User::class)
            ->create();

        $masterSchedule = factory(App\Models\UserSchedule::class)
            ->create([
                'user_id' => $user->id
            ]);

        $this->assertEquals($user->id, $masterSchedule->user->id);
    }

    public function testMasterScheduleException()
    {
        $user = factory(App\Models\User::class)
            ->create();

        $masterScheduleException = factory(App\Models\UserScheduleException::class)
            ->create([
               'user_id' => $user->id
            ]);

        $this->assertEquals($user->id, $masterScheduleException->user->id);
    }

    public function testOrderAdditionalService()
    {
        $order = factory(App\Models\Order::class)
            ->create();

        $additionalService = factory(App\Models\AdditionalService::class)
            ->create();

        $orderAdditionalService = factory(App\Models\OrderAdditionalService::class)
            ->create([
                'order_id' => $order->id,
                'additional_service_id' => $additionalService->id
            ]);

        $this->assertEquals($order->id, $orderAdditionalService->order->id);
        $this->assertEquals($additionalService->id, $orderAdditionalService->additionalService->id);
    }

    /**
     * Test user with services, additional services
     */

    public function testUser()
    {
        $userServiceData = [
            'price' => 350,
            'duration' => 30
        ];

        // add services to user

        $user = factory(App\Models\User::class)
            ->create();

        $service = factory(App\Models\Service::class)
            ->create();

        $user->services()->attach($service, $userServiceData);

        $this->assertEquals($userServiceData['price'], $user->services->first()->pivot->price);
        $this->assertEquals($userServiceData['duration'], $user->services->first()->pivot->duration);

        // add additional services to user

        $additionalServices = factory(App\Models\AdditionalService::class, 5)
            ->create([
                'service_id' => $service->id
            ]);

        $user->additionalServices()->attach($additionalServices, $userServiceData);

        $user->additionalServices->each(function($adService) use($userServiceData) {
            $this->assertEquals($userServiceData['price'], $adService->pivot->price);
            $this->assertEquals($userServiceData['duration'], $adService->pivot->duration);
        });


    }
}
