@extends('layout')

@section('title', 'Заказ')

@section('content')
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>автор</th>
            <th>Создано</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($orders as $order)
            <tr>
                <td><a href="{{ route('singleorder', ['order' => $order]) }}">Просмотр заказа {{ $order->id }}</a></td>
                <td>{{ $order->name }}</td>
                <td>{{ $order->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
@section('scripts')
@endsection
