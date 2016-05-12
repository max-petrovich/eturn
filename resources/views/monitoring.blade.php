@extends('layouts.app')

@section('content')
    @if($orders)
        <div style="padding:20px;font-size:13px;">
            <table class="table table-bordered">
                <thead>
                    <th>ID</th>
                    <th>{{ trans('monitoring.master') }}</th>
                    <th>{{ trans('monitoring.service') }}</th>
                    <th>{{ trans('monitoring.visit_date') }}</th>
                    <th>{{ trans('monitoring.price') }} {{ trans('all.rub') }}</th>
                    <th>{{ trans('monitoring.payment_type') }}</th>
                    <th>{{ trans('monitoring.note') }}</th>
                    <th>{{ trans('monitoring.phone') }}</th>
                    <th>{{ trans('monitoring.client') }}</th>
                    <th>{{ trans('monitoring.status') }}</th>
                </thead>
                @foreach($orders as $order)
                    <tr {!! $order['status'] == 1 ? 'class="success"' : '2' !!}>
                        <td>{{ $order['id'] }}</td>
                        <td>{{ $order['master_name'] }}</td>
                        <td>{{ $order['service_name'] }}</td>
                        <td class="text-center">
                            {{ $order['visit_date'] }}<br/>
                            {{ $order['visit_time_start'] }} - {{ $order['visit_time_end'] }}
                        </td>
                        <td>{{ (int)$order['price'] }}</td>
                        <td>{{ $order['payment_type_name'] }}</td>
                        <td>{{ $order['note'] }}</td>
                        <td>{{ $order['client_phone'] }}</td>
                        <td>{{ $order['client_name'] }}</td>
                        <td>{{ trans('orderStatus.' . $order['status']) }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @else
        <div class="alert alert-info">
            {{ trans('all.no_orders') }}
        </div>
    @endif

@endsection