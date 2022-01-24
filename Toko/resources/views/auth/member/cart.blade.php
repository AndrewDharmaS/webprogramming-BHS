@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/auth/cart.css') }}">
@endpush
@section('content')
<div class="modal fade" id="modalConfirmClear" tabindex="-1" role="dialog" aria-labelledby="modalConfirmClear" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Membersihkan Keranjang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah anda yakin ingin membersihkan keranjang belanja anda?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="{{ route('cart-clear') }}" class="btn btn-primary">Confirm</a>
            </div>
        </div>
    </div>
</div>
<div class="content limiter">
    <div class="cart col-12">
        <div class="title">
            Keranjang
        </div>
        @if($cart->isEmpty())
        <div id="empty">
            <h3>Wah, Kerenjang belanjamu kosong</h3>
            <br>
            <h5>Yuk mulai belanja sekarang!</h5>
        </div>
        @else
        <div class="checkout col-12">
            <div class="title">
                Ringkasan Belanja
            </div>
            <div class="detail">
                @foreach ($cart as $summary)
                    <div class="item" id="summary-{{ $summary->id }}">
                        {{ $summary->product->name }} &times; <span class="volume" id="volume-{{ $summary->id }}">{{ $summary->quantity }}</span>
                        <span class="subtotal" id="subtotal-{{ $summary->id }}" >Rp{{ number_format(($summary->product->price * $summary->quantity), 0, ',', '.') }}</span>
                    </div>
                @endforeach
                <div class="total" id="total">
                    Total: Rp{{ number_format($total, 0, ',', '.') }}
                </div>
            </div>
            <div class="row action">
                <div class="act-pad col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <a href="{{ route('transaction-checkout') }}" id="checkout">Checkout</a>
                </div>
                <div class="act-pad col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <a id="clear" data-toggle="modal" data-target="#modalConfirmClear">Clear</a>
                </div>
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
                            <div class="category">
                                {{ $order->product->category->name }}
                            </div>
                            <div class="price">
                                Rp{{ number_format($order->product->price, 0, ',', '.') }}
                            </div>
                            <div class="quantity">
                                <div class="amount">
                                    <form action="ajaxCartOrderDecrement" method="POST">@csrf <button type="submit" class="order-decrement" data-id="{{ $order->id }}">&minus;</button></form>
                                    <form action="ajaxCartOrderInput" method="POST">@csrf <input type="number" name="id" value="{{ $order->id }}" style="display: none;"><input type="number" name="quantity" class="quantity-holder" data-id="{{ $order->id }}" id="quantity-{{ $order->id }}" value="{{ $order->quantity }}" min="0" max="{{ $order->product->quantity }}"></form>
                                    <form action="ajaxCartOrderIncrement" method="POST">@csrf <button type="submit" class="order-increment" data-id="{{ $order->id }}">&plus;</button></form>
                                </div>
                            </div>
                            <div class="total" id="product-total-{{ $order->id }}">
                                <span class="mobile">Subtotal: </span>
                                Rp{{ number_format(($order->product->price * $order->quantity), 0, ',', '.') }}
                            </div>
                        </div>
                        <a href="{{ route('remove-from-cart', $order->id)}}" class="remove">&#128473;</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
@push('js')
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup ({
            headers: {
                'X-CSRF-TOKEN': $('[name="csrf-token"]').attr('content')
            }
        });
        
        $('.quantity-holder').change(function(e) {
            if (parseInt($(this).val()) < parseInt($(this).attr('min'))) $(this).val($(this).attr('min'));
            if (parseInt($(this).val()) > parseInt($(this).attr('max'))) $(this).val($(this).attr('max'));
            e.preventDefault();
            var id = $(this).data('id');
            var quantity = $(this).val();
            $.ajax({
                type:'post',
                url:'/ajaxCartOrderInput',
                data:{id:id, quantity:quantity},
                success: function(data) {   
                    $('#quantity-'+id).val(data[0]);
                    $('#product-total-'+id).html('Rp' + data[1]);
                    $('#summary-'+id);
                    $('#volume-'+id).html(data[0]);
                    $('#subtotal-'+id).html('Rp' + data[1]);
                    $('#total').html('Total: Rp' + data[2]);
                }
            });
        });
        $('.order-decrement').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                type:'post',
                url:'/ajaxCartOrderDecrement',
                data:{id:id},
                success: function(data) {   
                    $('#quantity-'+id).val(data[0]);
                    $('#product-total-'+id).html('Rp' + data[1]);
                    $('#summary-'+id);
                    $('#volume-'+id).html(data[0]);
                    $('#subtotal-'+id).html('Rp' + data[1]);
                    $('#total').html('Total: Rp' + data[2]);
                }
            });
        });
        $('.order-increment').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                type:'post',
                url:'/ajaxCartOrderIncrement',
                data:{id:id},
                success: function(data) {
                    $('#quantity-'+id).val(data[0]);
                    $('#product-total-'+id).html('Rp' + data[1]);
                    $('#summary-'+id);
                    $('#volume-'+id).html(data[0]);
                    $('#subtotal-'+id).html('Rp' + data[1]);
                    $('#total').html('Total: Rp' + data[2]);
                }
            });

        });
    });
</script>
@endpush