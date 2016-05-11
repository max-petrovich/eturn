<?php

use App\Entities\Procedure;
use App\Models\Order;
use App\Models\UserScheduleException;
use App\Services\ProcedureService;
use Bican\Roles\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

use App\Models\Service;
use App\Models\ClosedDate;
use App\Models\User;
use App\Models\AdditionalService;

class RealData extends Seeder
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
        $user = factory(User::class)
            ->create([
                'name' => 'Maxic',
                'email' => 'unrelaxby@gmail.com'
            ]);

        $user->attachRole(Role::where('slug', 'admin')->first());

        /**
         * Create 10 masters
         */
        $masterRole = Role::where('slug', 'master')->first();

        factory(User::class, 10)
            ->create()
            ->each(function ($user) use($masterRole){
                $user->attachRole($masterRole);
                $user->data()->save(new App\Models\UserData(['key' => 'minimum_service_duration', 'value' => collect([30,60])->random(1)]));
            });

        /**
         * Create 20 client
         */
        $clientRole = Role::where('slug', 'client')->first();

        factory(User::class, 20)
            ->create()
            ->each(function ($user) use($clientRole){
                $user->attachRole($clientRole);
            });

        /**
         * Create services
         */

        Service::create(['title' => 'Стрижка'])->additionalServices()->saveMany([
            new AdditionalService(['title' => 'Мытье головы', 'description' => 'Мытье головы теплой водой и вкусным шампунем']),
            new AdditionalService(['title' => 'Массаж головы', 'description' => 'Хорошенько помассажируем']),
            new AdditionalService(['title' => 'Подровнять усы', 'description' => 'Красота будет']),
            new AdditionalService(['title' => 'Подровнять бакенбарды', 'description' => 'Эстетически красиво']),
        ]);

        Service::create(['title' => 'Окраска волос'])->additionalServices()->saveMany([
            new AdditionalService(['title' => 'Мытье головы', 'description' => 'Мытье головы теплой водой и вкусным шампунем']),
            new AdditionalService(['title' => 'Амбре', 'description' => 'Красивый переход']),
            new AdditionalService(['title' => 'Мелирование', 'description' => 'Ещё что нибудь хорошее']),
        ]);

        Service::create(['title' => 'Макияж'])->additionalServices()->saveMany([
            new AdditionalService(['title' => 'Чистка лица', 'description' => 'Уберём чёрные точки']),
            new AdditionalService(['title' => 'Уход за лицом', 'description' => 'Сделаем классные маски']),
            new AdditionalService(['title' => 'Нарисовать пресс', 'description' => 'Ну а как ещё к лету готовиться']),
        ]);

        Service::create(['title' => 'Уход за телом'])->additionalServices()->saveMany([
            new AdditionalService(['title' => 'Антицеллюлитное обертывание', 'description' => 'Сожгем Ваш целлюлит к чертям']),
            new AdditionalService(['title' => 'Пяточки в аквариум с рыбками', 'description' => 'Пусть пощипет ножки']),
            new AdditionalService(['title' => 'Утягивающий корсет', 'description' => 'Подберём по фигурке']),
        ]);

        Service::create(['title' => 'Массаж'])->additionalServices()->saveMany([
            new AdditionalService(['title' => 'Массаж пяток', 'description' => 'Пощекочем пяточки']),
            new AdditionalService(['title' => 'Массаж головы', 'description' => 'Расслабляющий массаж']),
            new AdditionalService(['title' => 'Массаж рук и ног', 'description' => 'Ну и такое бывает']),
        ]);

        Service::create(['title' => 'Бассейн'])->additionalServices()->saveMany([
            new AdditionalService(['title' => 'Сауна', 'description' => 'На выбор финская, турецкая']),
            new AdditionalService(['title' => 'Водяные горки', 'description' => 'Можно и покататься']),
            new AdditionalService(['title' => 'Фото и видеосъёмка', 'description' => 'За отдельную плату']),
        ]);

        Service::create(['title' => 'Пилатес']);

        /**
         * Closed days
         */

        ClosedDate::create(['closed_date' => '2016-05-09']);
        ClosedDate::create(['closed_date' => '2016-05-10']);
        ClosedDate::create(['closed_date' => '2016-05-19']); // пикничок
        ClosedDate::create(['closed_date' => '2016-06-03']);

        /**
         * Masters Schedule
         */
        foreach (User::role('master')->get() as $master) {
            for ($i = 0; $i<7; $i++) {
                $userSchedule = factory(App\Models\UserSchedule::class)
                    ->make([
                        'weekday' => $i,
                        'time_start' => '08:00',
                        'time_end' => '17:00'
                    ]);
                $master->schedule()->save($userSchedule);
            }
        }

        /**
         * Masters schedule exceptions
         */

        $masters = User::role('master')->get();

        $masters[0]->scheduleException()->save(
            new UserScheduleException(['exception_date' => '2016-05-11', 'time_start' => '10:00', 'time_end' => '18:00'])
        );
        $masters[1]->scheduleException()->save(
            new UserScheduleException(['exception_date' => '2016-05-11', 'time_start' => '14:00', 'time_end' => '20:00'])
        );
        $masters[2]->scheduleException()->save(
            new UserScheduleException(['exception_date' => '2016-05-11', 'time_start' => null, 'time_end' => null]) // выходной сделал
        );


        /**
         * Associate services and additional services with masters
         */

/*        $masters[0]->services()->attach(Service::skip(0)->first(),['price' => 600, 'duration' => 60]);
        $masters[0]->additionalServices()->attach(Service::skip(0)->first()->additionalServices()->skip(0)->first(), ['price' => 200, 'duration' => 20]);
        $masters[0]->additionalServices()->attach(Service::skip(0)->first()->additionalServices()->skip(1)->first(), ['price' => 400, 'duration' => 30]);*/


        User::role('master')->get()->each(function(User $user) {
//            $servicesCount = mt_rand(0, mt_rand(0, Service::count()));
            $servicesCount = mt_rand(0, Service::count());

            if ($servicesCount > 0) {
                $user->services()->attach(Service::all()->random($servicesCount), [
                    'price' => collect([500,750,1000,1500])->random(1),
                    'duration' => collect([30,60,90,120])->random(1)
                ]);

                /**
                 * Attach additional services to user
                 */
                $user->services()->each(function(Service $userService) use($user) {
                    $userAdditionalServices = $userService->additionalServices()->get();
                    if ($userAdditionalServices->count() > 0) {
                        $user->additionalServices()->attach($userService->additionalServices, [
                            'price' => collect([100,250,300,500])->random(1),
                            'duration' => collect([10,20,30,40,50,60])->random(1)
                        ]);
                    }
                });
            }
        });

        /**
         * Create orders
         */

        $masters->take(3)->each(function ($master){
            if ($master->services->count()) {
                $this->createOrder($master->services->random(1), $master, '2016-05-11 09:00:00');
                $this->createOrder($master->services->random(1), $master, '2016-05-11 14:00:00');
                return false;
            }
        });

    }

    public function createOrder($service, $master, $visitStart)
    {
        $procedure = new Procedure($service);
        $procedureService = new ProcedureService($procedure);
        /**
         * Get additional services to order
         */
        $serviceAdditionalServices = $service->additionalServices;

        if ($serviceAdditionalServices->count()) {
            $orderAdditionalServices = $serviceAdditionalServices->random(rand(1, $serviceAdditionalServices->count()));

            if ($orderAdditionalServices instanceof AdditionalService) {
                $orderAdditionalServices = collect([$orderAdditionalServices]);
            }

            $procedure->setAdditionalServices($orderAdditionalServices);
        }
        
        $orderProcedureDuration = $procedureService->getDurationForMaster($master);

        $order = new Order([
            'client_name' => $master->fio,
            'client_phone' => '+375 44 5556911',
            'visit_start' => $visitStart,
            'visit_end' => Carbon::parse($visitStart)->addMinutes($orderProcedureDuration),
            'status' => 0
        ]);


        $order->client()->associate(User::role('client')->get()->random(1));
        $order->master()->associate($master);
        $order->service()->associate($service);
        $order->paymentType()->associate(App\Models\PaymentType::all()->random(1));
        $order->save();

        $procedure->getAdditionalServices()
            ->each(function(AdditionalService $additionalService) use($order) {
            $order->additionalServices()->attach($additionalService);
        });
    }
}
