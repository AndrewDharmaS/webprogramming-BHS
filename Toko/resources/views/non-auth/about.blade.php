@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/non-auth/about.css')}}">
@endpush
@section('content')
<div class="content limiter">
    <div class="row intro part">
        <div class="packed col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="title">
                Toko Bahan Sinar Jaya
            </div>
            <div class="description">
                merupakan toko yang didirikan di daerah Depok yang menjual barang barang seperti bahan sintetis dari jok mobil, sofa, motor. 
                Selain itu toko ini juga menjual busa yang dapat menjadi kebutuhan pelengkap dalam membuat sebuah kursi ataupun ranjang untuk digunakan. 
                Toko ini didirikan pada tahun 2012 yang di mana pada saat didirikan untuk mencari lokasi yang strategis di mana pasar penjualan tentang bahan sintetis beserta busa yang ada di daerah Depok. 
                Toko ini pun menjual alat bantu seperti staples tangan, lem, benang jahit, perekat, dan juga lis ban yang dapat digunakan untuk membuat sebuah kursi yang perlu direnovasi 
                bagian keseluruhan selain rangka ataupun bisa digunakan untuk keperluan kerajinan tangan lainnya.
            </div>
        </div>
        <div class="image col-lg-4">
            <img src="{{ asset('assets/images/main/about-1.png') }}">
        </div>
    </div>
    <div class="row location part">
        <div class="map col-lg-5">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d589.4040711413874!2d106.85014119553949!3d-6.391141441430614!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69eb91cd43e2e7%3A0xb5f0e729c773e0a4!2sJl.%20Proklamasi%20No.153%2C%20Abadijaya%2C%20Kec.%20Sukmajaya%2C%20Kota%20Depok%2C%20Jawa%20Barat%2016417!5e0!3m2!1sen!2sid!4v1639987527049!5m2!1sen!2sid" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <div class="description col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
            <div class="title">
                Lokasi Kami
            </div>
            <div class="position">
                Toko Official kami beralamat di Jl. Proklamasi No.153, Abadijaya, Kec. Sukmajaya, Kota Depok, Jawa Barat 16417
            </div>
            <div class="time">
                Buka SENIN - SABTU
                <br>
                08:00 - 16:00
            </div>
            <div class="open">
                Hari minggu dan tanggal merah libur
            </div>
        </div>
    </div>
</div>
@endsection