<?php

use App\Models\AdditionalService;
use App\Models\Service;
use App\Models\User;
use Bican\Roles\Models\Role;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DatabaseTestModelRelations extends TestCase
{

    use DatabaseTransactions;
    use SoftDeletes;

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
            ->make()
            ->each(function($adService) use ($service) {{
                $adService->service()->associate($service)->save();
            }});

        $user->additionalServices()->attach($additionalServices, $userServiceData);

        $user->additionalServices->each(function($adService) use($userServiceData) {
            $this->assertEquals($userServiceData['price'], $adService->pivot->price);
            $this->assertEquals($userServiceData['duration'], $adService->pivot->duration);
        });
        
    }

    /**
     * Create and delete order.
     * Associate related models
     * @throws Exception
     */

    public function testCreateOrder()
    {
        $users = factory(App\Models\User::class, 2)
            ->create();

        $service = factory(App\Models\Service::class)
            ->create();

        $additionalServices = factory(App\Models\AdditionalService::class, 3)
            ->make()
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

        $order = factory(App\Models\Order::class)->make();
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

    public function testUserServices()
    {
        $service = factory(App\Models\Service::class)
            ->create();

        $user = factory(App\Models\User::class)
            ->create();

        $user->attachRole(Role::find(3));

        $user->services()->attach($service);
    }

    public function testUserAdditionalServices()
    {

        $services = factory(App\Models\Service::class, 30)
            ->create()
            ->each(function(Service $service) {
                $service->additionalServices()->saveMany(factory(App\Models\AdditionalService::class, 2)->make());
            });

        $users = factory(App\Models\User::class, 10)
            ->create()
            ->each(function ($user){
                $user->attachRole(Role::find(3));
            });


        /**
         * Attach services and additional services to users
         */

        User::role('master')->doesntHave('services')->get()->each(function(User $user) use($services) {
            $servicesCount = rand(0, $services->count());

            if ($servicesCount > 0) {
                $user->services()->attach(Service::all()->random($servicesCount), [
                    'price' => 100,
                    'duration' => 30
                ]);

                /**
                 * Attach additional services to user
                 */
                $user->services()->each(function(Service $userService) use($user) {
                    $userAdditionalServices = $userService->additionalServices()->get();
                    if ($userAdditionalServices->count() > 0) {
                        $attachRandomCount = rand(0, $userAdditionalServices->count());
                        if ($attachRandomCount > 0) {
                            $user->additionalServices()->attach($userService->additionalServices()->get()->random($attachRandomCount), [
                                'price' => 100,
                                'duration' => 30
                            ]);
                        }
                    }
                });
            }
        });
    }
}
