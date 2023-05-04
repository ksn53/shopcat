@extends('layout')

@section('title', 'Корзина')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table id="cart" class="table table-hover table-condensed">
        <thead>
        <tr>
            <th style="width:50%">Товар</th>
            <th style="width:10%">Цена</th>
            <th style="width:8%">Количество</th>
            <th style="width:22%" class="text-center">Всего</th>
            <th style="width:10%"></th>
        </tr>
        </thead>
        <tbody>

            @foreach($order->items()->get() as $item)
                <tr>
                    <td data-th="Product">
                        <div class="row">
                            <div class="col-sm-3 hidden-xs"><img src="{{ $item->photo }}" width="100" height="100" class="img-responsive"/></div>
                            <div class="col-sm-9">
                                <h4 class="nomargin">{{ $item->name }}</h4>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price">{{ $item->price }}</td>
                    <td data-th="Quantity">{{ $item->pivot->quantity }}</td>
                    <td data-th="Subtotal" class="text-center">{{ $item->price * $item->pivot->quantity }}</td>
                    <td class="actions" data-th="">
                        <form id="patchDataForm" method="post" action="{{ route('updateCartWeb', ['item' => $item]) }}">
                            @csrf
                            @method('PATCH')
                            <input type="text" name="quantity" style="float: left;" value="{{ $item->pivot->quantity }}" class="form-control quantity" />
                            <button type="submit" class="mr-1 btn btn-info btn-sm update-cart" id="updateCartButton"><i class="fa fa-refresh"></i></button>
                        </form>
                    </td>
                    <td class="actions" data-th="">
                        <form id="deleteDataForm" method="post" action="{{ route('removeFromCartWeb', ['item' => $item]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm remove-from-cart" id="delFromCartButton"><i class="fa fa-trash-o"></i></button>
                        </form>

                    </td>
                </tr>
            @endforeach

        </tbody>
        <tfoot>
            <tr>
                <td><a href="{{ route('mainpage') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i>К списку товаров</a></td>
                <td colspan="2" class="hidden-xs"></td>
                <td class="hidden-xs text-center"><strong>Итого {{ $order->total() }}</strong></td>
            </tr>
        </tfoot>
    </table>
    <hr>
    <form id="editDataForm" method="post" action="{{ route('createorder', ['order' => $order]) }}" class="m-3">
        @csrf
        <div class="form-group">
            <label for="nameInput">Имя</label>
            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" placeholder='Введите имя' value="{{ old('name', $user->name) }}" required autocomplete="name">
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="emailInput">Email</label>
            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="emailInput" placeholder='Введите email' value="{{ old('email', $user->email) }}" required autocomplete="email">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="phoneInput">телефон</label>
            <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" id="phoneInput" placeholder='Введите номер телефона' value="{{ old('phone', $user->phone) }}" required autocomplete="phone">
            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary" id="editButton">Создать заказ</button>
    </form>
@endsection
