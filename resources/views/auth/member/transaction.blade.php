@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/auth/transaction.css') }}">
@endpush
@section('content')
<div class="content limiter">
    <div class="transaction col-12">
        <div class="title">
            Sejarah Transaksi
        </div>
        @if($transactions->isEmpty())
        <div id="empty" style="text-align:center;">
            <h3>Oh tidak, sepertinya transaksi anda kosong!</h3>
        </div>
        @else
        <div style="text-align:center; font-weight: 500;">
            <div class="alert alert-primary">
                Transfer ke 00000000000 A\N Johny Roger
                <br>
                Jika dalam waktu 24 jam bukti transaksi belum diupload maka transaksi dapat dibatalkan oleh Admin
            </div>
        </div>
        <div class="history col-12">
            <div class="row accordion history" id="accordion">
                @foreach ($transactions as $transaction)
                    <div class="detail col-12">
                        <div class="card">
                            <div class="card-header" id="headingCollapseHistory-{{ $transaction->id }}">
                                <button class="btn title" data-toggle="collapse" data-target="#collapseHistory-{{ $transaction->id }}" aria-expanded="true" aria-controls="collapseHistory-{{ $transaction->id }}">
                                    Transaksi pada {{$transaction->created_at}} ({{$transaction->delivery}})
                                    <div class="status">
                                        @if ($transaction->status == 'pending' || $transaction->status == 'Pending')
                                            Pending
                                        @else
                                            @if ($transaction->status == 'waiting')
                                            Waiting for Approval
                                            @else
                                                @if ($transaction->status == 'declined')
                                                    Declined
                                                @else
                                                    @if ($transaction->status == 'canceled')
                                                        Canceled
                                                    @else
                                                        @if ($transaction->status == 'accepted')
                                                            Accepted
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                </button>
                            </div>
                        </div>
                        <div id="collapseHistory-{{ $transaction->id }}" class="collapse" aria-labelledby="collapseHistory-{{ $transaction->id }}" data-parent="#accordion">
                            <div class="card-body">
                                <?php $carttotal = 0; ?>
                                @foreach ($transaction->cart as $summary)
                                    <div class="item">
                                        {{ $summary['name'] }} [Rp{{ number_format(($summary['price']), 0, ',', '.') }}] &times; <span class="volume">{{ number_format(($summary['quantity']), 0, ',', '.') }}</span>
                                        <span class="subtotal" >Rp{{ number_format(($summary['price'] * $summary['quantity']), 0, ',', '.') }}</span>
                                        <?php $carttotal += $summary['price'] * $summary['quantity']; ?>
                                    </div>
                                @endforeach
                                <hr>
                                <div class="cart-total">
                                    Total
                                    <span>Rp{{ number_format(($carttotal), 0, ',', '.') }}</span>
                                </div>
                                @if (!($transaction->status == 'accepted' || $transaction->status == 'canceled'))
                                    <div class="proof">
                                        <form action="{{ route('transaction-proof', $transaction->id) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="proof" id="proof-{{$transaction->id}}" accept="image/*" required>
                                            <input type="submit" value="Upload Bukti Transfer">
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
@push('js')
@endpush