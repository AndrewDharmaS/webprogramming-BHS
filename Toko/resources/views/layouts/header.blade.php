<div class="header">
    <div class="navbar">
        <div class="shelf row">
            <div class="nav-logo col-xl-2 col-lg-3 col-md-12">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <!-- <img src="https://images.tokopedia.net/img/cache/215-square/shops-1/2018/9/8/3125826/3125826_4b6263b8-49f9-401e-b30e-b8625b398be0.jpg" alt=""> -->
                        Bahan Sinar Jaya
                    </a>
                </div>
            </div>
            <div class="nav-search col-xl-6 col-lg-5 col-md-12">
                <div class="search-bar">
                    <form action="{{ route('search') }}" method="GET">
                        <input type="text" name="search" placeholder="Search . . ." value="{{ old('search') }}">
                        <input type="image" src="https://assets.tokopedia.net/assets-tokopedia-lite/v2/zeus/kratos/af2f34c3.svg" alt="Submit" />
                    </form>
                </div>
            </div>
            <div class="row nav-list col-xl-4 col-lg-4 col-md-12">
                @guest
                    @if (Route::has('register'))
                        <div class="link">
                            <a href="{{ route('register') }}">{{ __('Daftar') }}</a>
                        </div>
                    @endif
                    @if (Route::has('login'))
                        <div class="link">
                            <a href="{{ route('login') }}">{{ __('Masuk') }}</a>
                        </div>
                    @endif
                @else
                @if (Auth::user()->role == 'member')
                    <div class="link">
                        <a class="dropdown-toggle" href="#" role="button" id="navProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navProfileDropdown">
                            <a class="dropdown-item" href="{{ route('transaction-view') }}">Transaksi</a>
                            <a class="dropdown-item" href="{{ route('cart-view') }}">Keranjang</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('Keluar') }}</a>
                            <form action="{{ route('logout') }}" id="logout-form" method="POST" class="d-none">@csrf</form>
                        </div>
                    </div>
                @endif
                @if (Auth::user()->role == 'admin')
                    <div class="link">
                        <a class="dropdown-toggle" href="#" role="button" id="navProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navProfileDropdown">
                            <a class="dropdown-item" href="{{ route('product-controls') }}">Kontrol Produk</a>
                            <a class="dropdown-item" href="{{ route('category-controls') }}">Kontrol Kategori</a>
                            <a class="dropdown-item" href="{{ route('delivery-controls') }}">Kontrol Deliveri</a>
                            <a class="dropdown-item" href="{{ route('transaction-controls') }}">Kontrol Transaksi</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('Keluar') }}</a>
                            <form action="{{ route('logout') }}" id="logout-form" method="POST" class="d-none">@csrf</form>
                        </div>
                    </div>
                @endif
                @endguest
                <div class="link">
                    <a href="{{ route('about') }}">Tentang Kita</a>
                </div>
            </div>
        </div>
    </div>
</div>