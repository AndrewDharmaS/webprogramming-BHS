@foreach ($products as $product)
    <div class="product-pad col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
        @include('layouts.card-product')
    </div>
@endforeach