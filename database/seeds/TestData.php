<?php

use App\Models\AdditionalService;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Bican\Roles\Models\Role;
use Illuminate\Database\Seeder;

class TestData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        /**
         * Create users
         */
        $user = factory(App\Models\User::class)
            ->create([
                'name' => 'Maxic',
                'email' => 'unrelaxby@gmail.com'
            ]);

        $user->attachRole(Role::where('slug', 'admin')->first());

        /**
         * Create 10 masters
         */
        $masterRole = Role::where('slug', 'master')->first();
        factory(App\Models\User::class, 10)
            ->create()
            ->each(function ($user) use($masterRole){
                $user->attachRole($masterRole);
                $user->data()->save(new App\Models\UserData(['key' => 'minimum_service_duration', 'value' => 60]));
            });

        /**
         * Create 20 client
         */
        $clientRole = Role::where('slug', 'client')->first();

        factory(App\Models\User::class, 20)
            ->create()
            ->each(function ($user) use($clientRole){
                $user->attachRole($clientRole);
            });


        /**
         * Create services
         */

        $services = factory(App\Models\Service::class, 30)
            ->create();

        $additionalServices = factory(App\Models\AdditionalService::class, 70)
            ->make()
            ->each(function($adService) use($services) {
                $adService->service()->associate($services->random(1))->save();
            });

        $closedDays = factory(App\Models\ClosedDay::class, 5)
            ->create();

        $systemSettings = factory(App\Models\SystemSettings::class, 10)
            ->create();



        /**
         * Get client user
         * Get or create master user
         */
        $clients = App\Models\User::role('client')->get();

        $masters = App\Models\User::role('master')->get();

        /**
         * Masters Schedule
         */
        foreach ($masters as $masterObj) {
            for ($i = 0; $i<7; $i++) {
                $userSchedule = factory(App\Models\UserSchedule::class)
                    ->make([
                        'weekday' => $i
                    ]);
                $masterObj->schedule()->save($userSchedule);
            }
        }


        /**
         * Masters Schedule exceptions
         */
        $userScheduleException = factory(App\Models\UserScheduleException::class, 3)
            ->make()
            ->each(function($scheduleException) use($masters) {
                $masters->random(1)->scheduleException()->save($scheduleException);
            });

        /**
         * Simple data for services
         */
        $serviceSimpleData = [
            'price' => [150,300,450,600,1000,5000,10000],
            'duration' => [30,60,90,120,180]
        ];


        /**
         * Associate services and additional services with masters
         */

        User::role('master')->get()->each(function(User $user) use($serviceSimpleData) {
            $servicesCount = rand(0, Service::count());

            if ($servicesCount > 0) {
                $user->services()->attach(Service::all()->random($servicesCount), [
                    'price' => $serviceSimpleData['price'][array_rand($serviceSimpleData['price'])],
                    'duration' => $serviceSimpleData['duration'][array_rand($serviceSimpleData['duration'])]
                ]);

                /**
                 * Attach additional services to user
                 */
                $user->services()->each(function(Service $userService) use($user, $serviceSimpleData) {
                    $userAdditionalServices = $userService->additionalServices()->get();
                    if ($userAdditionalServices->count() > 0) {
                        $user->additionalServices()->attach($userService->additionalServices, [
                            'price' => $serviceSimpleData['price'][array_rand($serviceSimpleData['price'])],
                            'duration' => $serviceSimpleData['duration'][array_rand($serviceSimpleData['duration'])]
                        ]);
                    }
                });
            }
        });


        /**
         * Orders
         */


        $orders = factory(App\Models\Order::class, 20)
            ->make()
            ->each(function(Order $order){
                $master = User::role('master')->has('services')->get()->random(1);
                $order->client()->associate(User::role('client')->get()->random(1));
                $order->master()->associate($master);
                $order->service()->associate($master->services->random(1));
                $order->paymentType()->associate(App\Models\PaymentType::all()->random(1));
                $order->save();
            });

        // Attach additional services to orders
        $randomOrders = $orders->random(13);

        $randomOrders->each(function(Order $order) {
            $orderServiceAdditionalServices = $order->service->additionalServices;
            if ($orderServiceAdditionalServices->count()) {
                $orderServiceAdditionalServices->random(rand(1,$orderServiceAdditionalServices->count()))
                    ->each(function(AdditionalService $additionalService) use($order) {
                        $order->additionalServices()->attach($additionalService);
                    });
            }
        });


    }
}
