<?php namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Route;

class BookingComposer
{

    public function compose(View $view)
    {
        $this->steps($view);
    }

    private function steps(View $view)
    {
        /**
         * Data for steps
         */
        $steps = [
            'booking' => [
                'step'  => 1,
                'title' => trans('booking.steps_booking'),
                'name'  => 'booking',
                'route' => 'booking',
                'active' => true,
            ],
            'aservices' => [
                'step'  => 2,
                'title' => trans('booking.steps_aservices'),
                'name'  => 'aservices',
                'route' => 'booking.aservices.index',
                'active' => true,
            ],
            'master' => [
                'step'  => 3,
                'title' => trans('booking.steps_master'),
                'name'  => 'master',
                'route' => 'booking.aservices.master.index',
                'active' => true,
            ],
            'date' => [
                'step'  => 4,
                'title' => trans('booking.steps_date'),
                'name'  => 'date',
                'route' => 'booking.aservices.master.date.index',
                'active' => true,
            ],
            'payment' => [
                'step'  => 5,
                'title' => trans('booking.steps_payment'),
                'name'  => 'payment',
                'route' => 'booking.aservices.master.date.payment.index',
                'active' => true,
            ],
            'confirm' => [
                'step'  => 6,
                'title' => trans('booking.steps_confirm'),
                'name'  => 'confirm',
                'route' => 'booking.aservices.master.date.payment.confirm.index',
                'active' => true,
            ],
        ];

        // Process steps
        if (Route::current()->hasParameter('aservices')) {
            if (Route::input('aservices') == 0) {
                $steps['aservices']['active'] = false;
            }
        }

        $view->with('steps', $steps);
    }
}