<?php

namespace App\Http\Controllers;

use App\Entities\Procedure;
use App\Models\Order;
use App\Models\PaymentType;
use App\Models\Service;
use App\Models\User;
use App\Services\BookingService;
use App\Services\ProcedureService;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Route;

class BookingConfirm extends Controller
{
    /**
     * @var BookingService
     */
    private $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        $master = User::find(Route::input('master'));
        $service = Service::find(Route::input('booking'));
        $additionalServices = $this->bookingService->getAdditionalServicesFromInput();

        $procedure = new Procedure($service, $additionalServices);
        $procedureInfo = with(new ProcedureService($procedure))->getFullInfoForMaster($master);

        $visitDate = Carbon::parse(Route::input('date'))->format('d-m-Y H:i');

        $paymentType = PaymentType::find(Route::input('payment'));

        return view('booking.confirm',[
            'pageTitle' => trans('booking.steps_confirm'),
            'procedureInfo' => $procedureInfo,
            'master' => $master,
            'paymentType' => $paymentType,
            'visitDate' => $visitDate
        ]);
    }

    public function store(Request $request)
    {
        $master = User::find(Route::input('master'));
        $service = Service::find(Route::input('booking'));
        $paymentType = PaymentType::find(Route::input('payment'));
        $visitDateStart = Carbon::parse(Route::input('date'));

        $additionalServices = $this->bookingService->getAdditionalServicesFromInput();

        $procedure = new Procedure($service, $additionalServices);
        $procedureInfo = with(new ProcedureService($procedure))->getFullInfoForMaster($master);


        /**
         * Create order
         */
        $order = new Order();
        $order->fill($request->all());
        $order->client()->associate($request->user());
        $order->master()->associate($master);
        $order->service()->associate($service);
        $order->paymentType()->associate($paymentType);
        $order->visit_start = $visitDateStart;
        $order->visit_end = $visitDateStart->addMinutes($procedureInfo['all']['duration']);
        $order->status = 0;

        $order->save();

        // attach additional services
        if (!is_null($additionalServices) && $additionalServices->count()) {
            $order->additionalServices()->attach($additionalServices);
        }

        $bookingCompletedMessage = trans('bookingMessages.booking_completed_' . $paymentType->name, [
            'service_title' => $service->title,
            'date' => $order->visit_start->format("d-m-Y"),
            'time' => $order->visit_start->format("H:i"),
            'price' => $procedureInfo['all']['price']
        ]);

        return redirect('/')->with('message', $bookingCompletedMessage);
    }

}
