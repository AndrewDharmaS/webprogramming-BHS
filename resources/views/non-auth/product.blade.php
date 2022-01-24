@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{ secure_asset('assets/css/non-auth/product.css')}}">
<link rel="stylesheet" href="{{ secure_asset('assets/css/non-auth/card-product.css')}}">
@endpush
@section('content')
<div class="modal" tabindex="-1" role="dialog" id="modalMessage">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="cursor: default;">
                <h5 class="modal-title">Alert</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="message" style="cursor: default;">
            </div>
        </div>
    </div>
</div>
<div class="content limiter">
    <div class="product row">
        @if ($product == null)
            <div id="no-product">
                Produk tidak Ditemukan
            </div>
        @else
        <div class="image col-lg-4">
            <img src="{{ secure_asset('assets/images/product/'.$product->image)}}" alt="{{$product->image}}">
        </div>
        <div class="detail col-lg-8">
            <div class="title">{{ $product->name }}</div>
            <div class="price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
            <div class="category">Kategori: {{ $product->category->name }}</div>
            <div class="action">
                @if ($product->quantity == 0)
                    <div class="quantity">
                        Stok Habis
                    </div>
                    <div class="options">
                        <a class="button-reverse disabled">Tambah ke Keranjang</a>
                        {{-- <a class="button-theme disabled">Buy Now</a> --}}
                    </div>
                @else
                    @guest
                        <form action="{{ route('login') }}">
                            @csrf
                            <div class="quantity">
                                Kuantitas
                                <div class="amount">
                                    <button type="button">&minus;</button>
                                    <input type="number" value="1" min="1" max="{{ $product->quantity }}">
                                    <button type="button">&plus;</button>
                                </div>
                                Sisa Stock {{ $product->quantity }}
                            </div>
                            <div class="options">
                                <input type="submit" value="Tambah ke Keranjang" class="button-reverse">
                                {{-- <a href="" class="button-theme">Buy Now</a> --}}
                            </div>
                        </form>
                    @else
                        @if (Auth::user()->role == 'admin')
                        <form>
                            @csrf
                            <div class="quantity">
                                Sisa Stock {{ $product->quantity }}
                            </div>
                        </form>
                        @else
                        <form action="{{ route('add-to-cart', $product->id) }}" method="post" id="actionForm">
                            @csrf
                            <div class="quantity">
                                Kuantitas
                                <div class="amount">
                                    <button type="button" id="decrement">&minus;</button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->quantity }}">
                                    <button type="button" id="increment">&plus;</button>
                                </div>
                                Sisa Stock {{ $product->quantity }}
                            </div>
                            <div class="options">
                                <input type="submit" value="Tambah ke Keranjang" class="button-reverse">
                                {{-- <a href="" class="button-theme">Buy Now</a> --}}
                            </div>
                        </form>
                        @endif
                    @endguest
                @endif
                @if ($product->link != '')
                    <div class="link">
                        <a href="{{ $product->link }}">Cek kita di Tokopedia</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="description col-lg-12">
            <div class="title">
                Deskripsi
            </div>
            <div class="text" style="white-space: pre-line">
                {{ $product->description }}
            </div>
        </div>
        @endif
    </div>
    @include('layouts.recents')
</div>
@endsection
@push('js')
@auth
    
@if (Auth::user()->role == 'admin')

@else
<script type="text/javascript">
    $(document).ready(function(){
        $('#actionForm').submit(function(e) {
            e.preventDefault();
            var form = $('#actionForm');
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function(data) {
                    $('#modalMessage').modal('show');
                    var msg = $('#message');
                    var received = data.split('@');
                    msg.html(received[1]);
                    if (received[0] == 'SUCCESS') {
                        $('#message').addClass('alert-success');
                        $('#message').removeClass('alert-danger');
                    } else if (received[0] == 'FAILED') {
                        $('#message').addClass('alert-danger');
                        $('#message').removeClass('alert-success');
                    }
                }
            });
        });
        $('#quantity').on('change', function update() {
            if (parseInt($('#quantity').val()) < parseInt($('#quantity').attr('min'))) $('#quantity').val($('#quantity').attr('min'));
            if (parseInt($('#quantity').val()) > parseInt($('#quantity').attr('max'))) $('#quantity').val($('#quantity').attr('max'));
        })
        $('#decrement').click(function() {
            if (parseInt($('#quantity').val()) < parseInt($('#quantity').attr('min'))) $('#quantity').val($('#quantity').attr('min'));
            if (parseInt($('#quantity').val()) > parseInt($('#quantity').attr('max'))) $('#quantity').val($('#quantity').attr('max'));
            if (parseInt($('#quantity').val()) > parseInt($('#quantity').attr('min'))) $('#quantity').val(parseInt($('#quantity').val())-1);
        });
        $('#increment').click(function() {
            if (parseInt($('#quantity').val()) < parseInt($('#quantity').attr('min'))) $('#quantity').val($('#quantity').attr('min'));
            if (parseInt($('#quantity').val()) > parseInt($('#quantity').attr('max'))) $('#quantity').val($('#quantity').attr('max'));
            if (parseInt($('#quantity').val()) < parseInt($('#quantity').attr('max'))) $('#quantity').val(parseInt($('#quantity').val())+1);
        });
    });
</script>
@endif
@endauth
@endpush