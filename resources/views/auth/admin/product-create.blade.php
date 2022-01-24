@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{ secure_asset('assets/css/auth/admin-product-create.css') }}">
@endpush
@section('content')
<div class="content limiter">
    <div class="products col-12">
        <div class="title">
            Insert Product
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
            </div>
        @endif
        <div class="control">
            @if ($categories->isEmpty())
            <div class="alert alert-danger">
                Tidak ada Kategori yang ditemukan, harap masukkan Kategori terlebih dahulu!
            </div>
            @else
            <form action="{{ route('product-create') }}" method="POST" class="col-xl-6 col-lg-7 col-md-9 col-sm-12 col-12" enctype="multipart/form-data">
                @csrf
                <div class="input-container">
                    <label for="category" class="fill">Kategori</label>
                    <div class="fill">
                        <select name="category" id="category">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('quantity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="input-container">
                    <label for="name" class="fill">Nama</label>
                    <div class="fill">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="input-container">
                    <label for="quantity" class="fill">Kuantitas</label>
                    <div class="fill">
                        <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" min="0" required>
                        @error('quantity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="input-container">
                    <label for="price" class="fill">Harga</label>
                    <div class="fill">
                        <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" min="0" required>
                        @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="input-container">
                    <label for="description" class="fill">Deskripsi</label>
                    <div class="fill">
                        <textarea name="description" id="description" cols="30" rows="10" style="white-space: pre-line"></textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="input-container">
                    <label for="link" class="fill">Tautan</label>
                    <div class="fill">
                        <input id="link" type="text" class="form-control @error('link') is-invalid @enderror" name="link">
                        @error('link')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="input-container">
                    <label for="image" class="fill">Gambar</label>
                    <div class="fill">
                        <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*" required>
                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <input type="submit" value="Tambahkan">
            </form>
            @endif
        </div>
    </div>
</div>
@endsection
@push('js')
@endpush