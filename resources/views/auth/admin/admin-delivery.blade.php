@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/auth/admin-delivery.css') }}">
@endpush
@section('content')
<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDelete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="confirmation"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="" id="confirm-button" class="btn btn-primary">Konfirmasi</a>
            </div>
        </div>
    </div>
</div>
<div class="content limiter">
    <div class="deliveries col-12">
        <div class="title">
            Kontrol Deliveri
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
            </div>
        @endif
        @if($deliveries->isEmpty())
        <div class="alert alert-danger">
            Deliveri Tidak Ditemukan
        </div>
        
        <div class="control col-12">
            <div class="title">
                Tambah Deliveri Baru
            </div>
            <form action="{{ route('delivery-create') }}" method="POST" class="col-12" enctype="multipart/form-data">
                @csrf
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
                <input type="submit" value="Tambahkan">
            </form>
        </div>
        @else
        <div class="row">
            <div class="delivery-view col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scole="col" class="update-lead">&#10227;</th>
                        <th scope="col">ID</th>
                        <th scope="col" class="name">Nama</th>
                        <th scope="col">&#x1F5D1;</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($deliveries as $delivery)
                            <tr>
                                <td class="update-laed update"><a href="{{ route('delivery-update-view', $delivery->id) }}">&#x21bb;</a></td>
                                <th scope="row">{{ $delivery->id }}</th>
                                <td class="name">{{ $delivery->name }}</td>
                                <td class="remove"><a class="remove-button d-flex align-items-center" data-id="{{ $delivery->id }}" data-name="{{ $delivery->name }}" data-toggle="modal" data-target="#modalConfirmDelete">&#128473;</a></td>
                            </tr>
                        @endforeach
                        {{ $deliveries->links() }}
                    </tbody>
                </table>
            </div>
            <div class="control col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="title">
                    Tambah Deliveri Baru
                </div>
                <form action="{{ route('delivery-create') }}" method="POST" class="col-12" enctype="multipart/form-data">
                    @csrf
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
                    <input type="submit" value="Tambahkan">
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('.remove-button').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var name = $(this).data('name');
            var newconfirmation = 'Apakah anda yakin in menghapus ' + name + '?';
            $('#confirmation').html(newconfirmation);
            var newurl = '/deliverydelete-'+id;
            $('#confirm-button').attr('href', newurl);
        });
    });
</script>
@endpush