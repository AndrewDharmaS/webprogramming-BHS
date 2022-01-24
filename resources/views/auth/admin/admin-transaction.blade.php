@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{ secure_asset('assets/css/auth/admin-transaction.css') }}">
@endpush
@section('content')
<div class="content limiter">
    <div class="transactions col-12">
        <div class="title">
            Kontrol Transaksi
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
            </div>
        @endif
        @if($transactions->isEmpty())
        <div class="alert alert-danger">
            Transaksi Tidak Ditemukan
        </div>
        @else
        <div class="row">
            <div class="transaction-view col-12">
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">Transaction ID</th>
                        <th scope="col">User ID</th>
                        <th scope="col">Waktu</th>
                        <th scope="col" class="name">Status</th>
                        <th scope="col">Tipe Delivery</th>
                        <th scope="col">Bukti</th>
                        <th scole="col">Tolak</th>
                        <th scope="col">Terima</th>
                        <th scope="col">Batal</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <th scope="row">{{ $transaction->id }}</th>
                                <th class="product">{{ $transaction->user_id }}</th>
                                <td class="product">{{ $transaction->updated_at }}</td>
                                <td class="name">{{ $transaction->status }}</td>
                                <td class="product">{{ $transaction->delivery }}</td>
                                @if ($transaction->status == 'declined')
                                    <td class="proof">-</td>
                                @else
                                    @if ($transaction->status == 'Pending' || $transaction->status == 'declined' || $transaction->status == 'canceled')
                                        <td class="proof">-</td>
                                    @else
                                        <td class="proof"><a href="{{ secure_asset('assets/images/transaction/'.$transaction->proof) }}" target="_blank">Lihat</a></td>
                                    @endif
                                @endif
                                @if ($transaction->status == 'accepted' || $transaction->status == 'canceled')
                                    <td class="proof">-</td>
                                    <td class="proof">-</td>
                                    <td class="proof">-</td>
                                @else
                                    @if ($transaction->status == 'declined' || $transaction->status == 'Pending')
                                        <td class="proof">-</td>
                                        <td class="proof">-</td>
                                    @else
                                        <td class="update-lead update"><a href="{{ route('transaction-decline', $transaction->id) }}">&#x21bb;</a></td>
                                        <td class="update-lead approve"><a href="{{ route('transaction-accept', $transaction->id) }}">&checkmark;</a></td>
                                    @endif
                                    <td class="remove"><a href="{{ route('transaction-cancel', $transaction->id) }}" class="remove-button d-flex align-items-center">&#128473;</a></td>
                                @endif
                            </tr>
                        @endforeach
                        {{ $transactions->links() }}
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
@push('js')
@endpush