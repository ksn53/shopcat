@extends('layout')
@section('title', 'Заказ')
@section('content')
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Товар</th>
            <th>цена</th>
            <th>Количество</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($order->items()->get() as $item)
            <tr>
                <td><a href="{{ route('singleitem', ['item' => $item]) }}">{{ $item->name }}</a></td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->pivot->quantity }}</td>
            </tr>
        @endforeach
        <tfoot>
            <tr class="visible-xs">
                <td class="text-center"><strong>Итого {{ $order->total() }}</strong></td>
            </tr>
        </tfoot>
        </tbody>
    </table>

Заказчик:
<div>Имя: {{ $order->name }}</div>
<div>Email: {{ $order->email }}</div>
<div>Телефон: {{ $order->phone }}</div>
@endsection
@section('scripts')
@endsection
