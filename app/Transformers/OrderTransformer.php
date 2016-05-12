<?php namespace App\Transformers;

use App\Entities\Procedure;
use App\Models\Order;
use App\Services\ProcedureService;
use League\Fractal;

class OrderTransformer extends Fractal\TransformerAbstract
{

    public function transform(Order $order)
    {
        $procedure = new Procedure($order->service, $order->additionalServices);
        $procedureService = new ProcedureService($procedure);
        $procedureInfo = $procedureService->getFullInfoForMaster($order->master);

        return [
            'id' => $order->id,
            'client_id' => $order->client->id,
            'client_name' => $order->client_name,
            'client_phone' => $order->client_phone,
            'master_id' => $order->master->id,
            'master_name' => $order->master->fio,
            'master_photo' => $order->master->photoLink,
            'service_id' => $order->service->id,
            'service_name' => $order->service->title,
            'payment_type_name' => $order->paymentType->title,
            'note' => $order->note,
            'price' => $procedureInfo['all']['price'],
            'duration' => $procedureInfo['all']['duration'],
            'visit_date' => $order->visit_start->format("d.m.Y"),
            'visit_time_start' => $order->visit_start->format("H:i"),
            'visit_time_end' => $order->visit_end->format("H:i"),
            'status' => $order->status,
        ];
    }
}