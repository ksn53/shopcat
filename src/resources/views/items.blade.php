@extends('layout')
@section('title', 'Список товаров')
@section('content')
    <div style="max-width: 400px; float: left;">
        @section('sidebar')
            @include('layouts.sidebar')
        @show
    </div>
        <div class="container products">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row">
                @foreach($items as $item)
                    <div class="col-xs-18 col-sm-6 col-md-3">
                        <div class="thumbnail">

                            <img src="http://{{ Request::server('SERVER_NAME') . '/' . $item->photo }}" width="100" height="100">
                            <div class="caption">
                                <h4><a href="{{ route('singleitem', ['item' => $item]) }}">{{ $item->name }}</a></h4>
                                <p>{{ mb_strimwidth("strtolower($item->description)", 0, 80, "...") }}</p>
                                <p><strong>Цена: </strong> {{ $item->price }}</p>
                                <form id="deleteDataForm" method="post" action="{{ route('addItemToCartWeb', ['item' => $item]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-block text-center" id="addToCartButton">Добавить в корзину</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
@endsection
