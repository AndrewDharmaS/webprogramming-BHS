@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{ secure_asset('assets/css/auth/admin-product.css') }}">
@endpush
@section('content')
<div class="content limiter">
    <div class="products col-12">
        <div class="title">
            Kontrol Produk
        </div>
        <div class="control">
            <a href="{{ route('product-insert') }}">Tambah Produk Baru</a>
        </div>
        @if($products->isEmpty())
        <br>
        <div class="alert alert-danger">
            Produk Tidak Ditemukan
        </div>
        @else
        <br>
        <div class="product-view col-12">
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scole="col" class="update-lead">&#10227;</th>
                    <th scope="col">ID</th>
                    <th scope="col">Kateogri</th>
                    <th scope="col" class="name">Nama</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Harga</th>
                    <th scope="col" class="description">Deskripsi</th>
                    <th scope="col">Tautan</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">&#x1F5D1;</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td class="update-laed update"><a href="{{ route('product-update-view', $product->id) }}">&#x21bb;</a></td>
                            <th scope="row">{{ $product->id }}</th>
                            <td>{{ $product->category->name }}</td>
                            <td class="name">{{ $product->name }}</td>
                            <td class="stock">{{ number_format($product->quantity, 0, ',', '.') }}</td>
                            <td class="price">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="description" style="white-space: pre-line">{{ $product->description }}</td>
                            <td><a href="{{ $product->link }}" target="_blank">Buka</a></td>
                            <td><a href="{{ secure_asset('/assets/images/product/'.$product->image)}}" target="_blank">Lihat</a></td>
                            <td class="remove"><a href="{{ route('product-delete', $product->id)}}" class="d-flex align-items-center">&#128473;</a></td>
                        </tr>
                    @endforeach
                    {{ $products->links() }}
                </tbody>
              </table>
        </div>
        @endif
    </div>
</div>
@endsection
@push('js')
@endpush