@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{ secure_asset('assets/css/non-auth/index.css')}}">
<link rel="stylesheet" href="{{ secure_asset('assets/css/non-auth/card-product.css')}}">
@endpush
@section('content')
<div class="content limiter">
    <div class="home row">
        {{-- <div class="banner col-12">
            <img src="{{ secure_asset('assets/images/main/welcome-banner.jpg') }}">
        </div> --}}
        <div class="categories col-12">
            <div class="title">
                Kategori
            </div>
            <div class="row category">
                @foreach ($categories as $category)
                    <a href="{{ route('category-view', ['id' => $category->id]) }}">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>
        <div class="recommend col-12">
            <div class="title">
                Terbaru
            </div>
            <div class="row products" id="load">

            </div>
            <div class="others">
                <a href="#" id="load-more">Lihat Lainnya</a>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    $(document).ready(function() {
        var page = 1;
        var limit = <?php echo $max+1?>;
        fetch_data(page++);
        window.onscroll = function(ev) {
            if ((window.innerHeight + window.scrollY) >= document.body.scrollHeight) {
                fetch_data(page++);
            }
        };

        $("#load-more").click(function(event){
            event.preventDefault();
            fetch_data(page++);
        });

        function fetch_data(page)
        {
            if (page < limit) {
                $.ajax({
                    url:"/home_fetch_data?page="+page,
                    success:function(data)
                    {
                        $('#load').append(data);
                        if (page+1 >= limit) $('#load-more').hide();
                    }
                });
            }
        }
    });
</script>
@endpush