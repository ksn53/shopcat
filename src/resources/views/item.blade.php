@extends('layout')
@section('title', 'Товар')
@section('content')
<div><img src="http://{{ Request::server('SERVER_NAME') . '/' . $item->photo }}"></div>
<div>название: {{ $item->name }}</div>
<div>Описание: {{ $item->description }}</div>
<div>Информация: {{ $item->info }}</div>
<div>Категория: {{ $item->category()->pluck('name')[0] }}</div>
<div>Вес: {{ $item->weight }}</div>
<div>Цена: {{ $item->price }}</div>
@endsection
@section('scripts')
@endsection
