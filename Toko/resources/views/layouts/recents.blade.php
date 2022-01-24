@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/non-auth/recents.css')}}">
@endpush
<div class="recents">
    @if (!$products->isEmpty())
        <div class="title">
            Produk Terbaru
        </div>
        <div class="row products">
            @foreach ($products as $product)
                <div class="product-pad col-lg-3 col-md-6">
                    @include('layouts.card-product')
                </div>
            @endforeach
        </div>
    @endif
</div>