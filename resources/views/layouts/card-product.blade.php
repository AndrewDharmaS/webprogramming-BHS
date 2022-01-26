<a href="{{ route('product-view', ['id' => $product->id])}}">
    <div class="product">
        <div class="image">
            <img src="{{ secure_asset('assets/images/product/'.$product->image) }}" alt="{{ $product->image }}">
        </div>
        <div class="description">
            <div class="name">
                {{ $product->name }}
            </div>
            <div class="category">
                {{ $product->category->name }}
            </div>
            <div class="price">
                Rp{{ number_format($product->price, 0, ',', '.') }}
            </div>
        </div>
    </div>
</a>