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
        $steps = app()->make('BookingSteps')->getSteps();

        $view->with('steps', $steps);
    }
}