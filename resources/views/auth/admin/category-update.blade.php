@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/auth/admin-category-update.css') }}">
@endpush
@section('content')
<div class="content limiter">
    <div class="categories col-12">
        <div class="title">
            Memperbarui Kategori
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
            </div>
        @endif
        <div class="control col-xl-7 col-lg-8 col-md-10 col-sm-12 col-12">
            <div class="title">
                Memperbarui {{ $category->name }}
            </div>
            <form action="{{ route('category-update', $category->id) }}" method="POST" class="col-12" enctype="multipart/form-data">
                @csrf
                <div class="input-container">
                    <label for="name" class="fill">Nama</label>
                    <div class="fill">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $category->name }}"required autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <input type="submit" value="Perbarui">
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
@endpush