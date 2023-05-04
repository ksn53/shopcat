<div class="col-lg-14 col-sm-14 col-14 main-section">
    <div class="dropdown">
        <button type="button" class="btn btn-info" data-toggle="dropdown">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i> Корзина <span class="badge badge-pill badge-danger">
                {{ $order->itemsCount() }}
            </span>
        </button>
        <div class="dropdown-menu px-1" style="width: 220px;">
            <div class="row total-header-section">
                <div class="col-lg-6 col-sm-6 col-6">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger">
                        {{ $order->itemsCount() }}
                    </span>
                </div>
                <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                    <p>Всего: <span class="text-info">{{ $order->itemsCount() }}</span></p>
                </div>
            </div>
                @foreach($order->items()->get() as $item)
                    <div class="row cart-detail">
                        <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                            <img src="{{ $item->photo }}" />
                        </div>
                        <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                            <p>{{ $item->name }}</p>
                            <span class="price text-info">{{ $item->price }}</span> <span class="count"> Количество:{{ $item->pivot->quantity }}</span>
                        </div>
                    </div>
                @endforeach

            <div class="row">
                <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                    <a href="{{ route('cart') }}" class="btn btn-primary btn-block">Товаров в корзине</a>
                </div>
            </div>
        </div>
    </div>
</div>

