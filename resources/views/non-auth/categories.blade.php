@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{ secure_asset('assets/css/non-auth/categories.css')}}">
<link rel="stylesheet" href="{{ secure_asset('assets/css/non-auth/card-product.css')}}">
@endpush
@section('content')
<div class="content limiter">
    <div class="home row">
        <div class="categories col-12">
            <div class="title">
                Kategori
            </div>
            <div class="row category">
                @foreach ($categories as $cate)
                    <a href="{{ route('category-view', ['id' => $cate->id]) }}">{{ $cate->name }}</a>
                @endforeach
            </div>
        </div>
        <div class="recommend col-12">
            @if ($products->isEmpty())
                <div class="title">
                    Produk tidak ditemukan.
                </div>
            @else
                <div class="title">
                    Menampilkan "{{ $category->name }}" ({{ $products->count() }})
                </div>
                <div class="row products">
                    @foreach ($products as $product)
                        <div class="product-pad col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                            @include('layouts.card-product')
                        </div>
                    @endforeach
                </div>
                {{ $products->links() }}
            @endif
        </div>
    </div>
</div>
@endsection