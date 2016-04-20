<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DatabaseCreateModelsTest extends TestCase
{

    use DatabaseTransactions;

    public function testCreateUsers()
    {
        factory(App\Models\User::class, 1)
            ->create();
    }

    public function testCreateServices()
    {
        factory(App\Models\Service::class, 2)
            ->create();
    }

    public function testCreateAdditionalServices()
    {
        factory(App\Models\AdditionalService::class, 2)
            ->create();
    }

    public function testCreateClosedDays()
    {
        factory(App\Models\ClosedDay::class, 2)
            ->create();
    }

    public function testCreatePaymentType()
    {
        factory(App\Models\PaymentType::class, 2)
            ->create();
    }

    public function testCreateOrders()
    {
        factory(App\Models\Order::class, 2)
            ->create();
    }

    public function testCreateCanceledOrders()
    {
        factory(App\Models\CanceledOrder::class, 2)
            ->create();
    }

    public function testCreateHiddenMonitoringOrders()
    {
        factory(App\Models\HiddenOrderMonitoring::class, 2)
            ->create();
    }

    public function testCreateMasterSchedule()
    {
        $user = factory(App\Models\User::class)->create();
        factory(App\Models\UserSchedule::class, 7)
            ->create([
                'user_id' => $user->id
            ]);
    }

    public function testCreateMasterScheduleExceptions()
    {
        factory(App\Models\UserScheduleException::class, 7)
            ->create();
    }

    public function testCreateSystemSettings()
    {
        factory(App\Models\SystemSettings::class, 7)
            ->create();
    }
}
