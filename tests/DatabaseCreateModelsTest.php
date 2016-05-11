<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DatabaseCreateModelsTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateUsers()
    {
        $user = factory(App\Models\User::class)
            ->create();

        $this->seeInDatabase($user->getTable(), [
           'email' => $user->email
        ]);
    }

    public function testCreateServices()
    {
        factory(App\Models\Service::class, 2)
            ->create();
    }

    public function testCreateAdditionalServices()
    {

        factory(App\Models\Service::class)
            ->create()
            ->each(function($service) {
               $service->additionalServices()->saveMany(factory(App\Models\AdditionalService::class, 2)->make());
            });

    }

    public function testCreateClosedDays()
    {
        factory(App\Models\ClosedDate::class, 2)
            ->create();
    }

    public function testCreatePaymentType()
    {
        factory(App\Models\PaymentType::class, 2)
            ->create();
    }

    public function testCreateOrder()
    {
        $this->createOrder();
    }

    public function testCreateCanceledOrders()
    {
        $order = $this->createOrder();

        $canceledOrder = factory(App\Models\CanceledOrder::class)
            ->make();

        $canceledOrder->order()->associate($order);
        $canceledOrder->save();

        $this->assertEquals(1, App\Models\Order::has('canceled')->get()->count());


    }

    public function testCreateUserHiddenOrders()
    {
        $user = factory(App\Models\User::class)
            ->create();

        $order = $this->createOrder();

        $userHiddenOrder = factory(App\Models\OrderHiddenUser::class)
            ->make();

        $userHiddenOrder->user()->associate($user);
        $userHiddenOrder->order()->associate($order);
        $userHiddenOrder->save();

        $hiddenOrderForUser = App\Models\Order::whereHas('hiddenUser', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();;

        $this->assertEquals(1, $hiddenOrderForUser->count());
    }

    public function testCreateMasterSchedule()
    {
        $user = factory(App\Models\User::class)
            ->create();

        $weekday = 0;

        $userSchedule = factory(App\Models\UserSchedule::class, 7)
            ->make();

        foreach ($userSchedule as $schedule) {
            $schedule->weekday = $weekday++;
            $schedule->user()->associate($user)->save();
        }

        $this->assertEquals(7, $user->schedule->count());
    }

    public function testCreateMasterScheduleExceptions()
    {
        $user = factory(App\Models\User::class)
            ->create();

        $userScheduleException = factory(App\Models\UserScheduleException::class)
            ->make();

        $userScheduleException->user()->associate($user)->save();

        $this->assertEquals(1, $user->scheduleException->count());
    }

    public function testCreateSystemSettings()
    {
        factory(App\Models\SystemSettings::class, 7)
            ->create();
    }

    /**
     * Create order with all relations
     * @return App\Models\Order
     */
    private function createOrder()
    {
        $users = factory(App\Models\User::class, 10)
            ->create();

        $services = factory(App\Models\Service::class, 5)
            ->create()
            ->each(function($service) {
                $service->additionalServices()->saveMany(factory(App\Models\AdditionalService::class, rand(2,4))->make());
            });

        $paymentTypes = factory(App\Models\PaymentType::class, 3)
            ->create();

        $order = factory(App\Models\Order::class)
            ->make();

        $order->client()->associate($users->random(1));
        $order->master()->associate($users->random(1));
        $order->service()->associate($services->random(1));
        $order->paymentType()->associate($paymentTypes->random(1));

        $order->save();

        $order->additionalServices()->attach($order->service->additionalServices()->get()->random(1));

        return $order;
    }
}
