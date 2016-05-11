<?php namespace App\Entities;

class BookingSteps
{

    protected $steps = [];

    public function __construct()
    {
        $this->steps = [
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
    }

    public function setActive($stepName)
    {
        if (isset($this->steps[$stepName])) {
            $this->steps[$stepName]['active'] = true;
        }
    }

    public function setNotActive($stepName)
    {
        if (isset($this->steps[$stepName])) {
            $this->steps[$stepName]['active'] = false;
        }
    }

    /**
     * @return array
     */
    public function getSteps()
    {
        return $this->steps;
    }


}