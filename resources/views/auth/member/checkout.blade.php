@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/auth/checkout.css') }}">
@endpush
@section('content')
<div class="content limiter">
    <div class="checkout col-12">
        <div class="title">
            Checkout
        </div>
        @if($cart->isEmpty())
        <div id="empty">
            <h3>Wah, Kerenjang belanjamu kosong</h3>
            <br>
            <h5>Yuk mulai belanja sekarang!</h5>
        </div>
        @else
        <div class="summary col-12">
            <div class="detail">
                <div class="total">
                        Total Harga ({{ $totalitems }} 
                        @if ($totalitems > 1)
                            produk)
                        @else
                            produk)
                        @endif 
                    <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="action">
                <form action="{{ route('transaction-create') }}" method="POST" class="row">
                    @csrf
                    <div class="act-pad col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <select name="delivery" id="delivery" class="form-select" aria-label="Default select example">
                            @foreach ($deliveries as $deliver)
                            <option value="{{ $deliver->id }}">{{ $deliver->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="act-pad col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <input type="submit" value="Confirm" id="checkout">
                    </div>
                </form>
            </div>
        </div>
        <div class="products">
            @foreach ($cart as $order)
                <div class="product-pad col-12">
                    <div class="row product">
                        <div class="image col-xl-2 col-lg-2 col-md-3 col-sm-4 col-12">
                            <img src="{{ asset('assets/images/product/'.$order->product->image)}}">
                        </div>
                        <div class="description col-xl-10 col-lg-10 col-md-9 col-sm-8 col-12">
                            <div class="name">
                                {{ $order->product->name }}
                            </div>
                            <div class="quantity">
                                {{ $order->quantity }} butir
                            </div>
                            <div class="price">
                                Rp{{ number_format($order->product->price, 0, ',', '.') }}
                            </div>
                            <hr>
                            <div class="subtotal">
                                Subtotal
                                <span>Rp{{ number_format(($order->product->price * $order->quantity), 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
@push('js')
@endpush