<?php

use Illuminate\Database\Seeder;

class InitProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = factory(App\Models\Service::class, 30)
            ->create();

        $additionalServices = factory(App\Models\AdditionalService::class, 100)
            ->create([
                'service_id' => 0
            ])->each(function($adService) use($services) {
                $adService->service()->associate($services->random(1))->save();
            });

        $paymentTypes = factory(App\Models\PaymentType::class, 3)
            ->create();
    }
}
