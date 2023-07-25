<!doctype html>
<html lang="en">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@include('home.head')
<style>
    table {
        border: 3px solid chartreuse;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    table td,
    table th {
        border: 1px solid #000;
        padding: 8px;
    }

    .center {
        margin: auto;
        width: 70%;
        text-align: center;
        margin-top: 30px;
        padding-bottom: 20px;
    }

    .title {
        background: skyblue;
        font-size: 24px;
        color: red;
    }

    .img_deg {
        display: flex;
    }

    .total_deg {
        font-size: 30px;
        color: blue;
        padding: 40px;
        text-align: center;
    }

</style>
<body>
@include('sweetalert::alert')

<div class="hero_area" style="background-color: rgba(0,255,21,0.1);">
    <!-- header section strats -->
    @include('home.navbar')
    <!-- end header section -->
    <div class="center">
        <header>
            <h1 style="font-size: 28px; padding-bottom: 20px">Giỏ hàng của bạn !~!</h1>
            <br>
        </header>
        @if (session('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session('message') }}
                @if(session('url'))
                    <a style="font-size: 16px" href="{{ session('url') }}"> Đến trang chủ </a>
                @endif
            </div>
        @endif

        <table>
            <tr class="title">
                <th>Product Title</th>
                <th>Product Quantity</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            <?php $totalprice = 0; ?>


            @foreach($cart as $cart)
                <tr>
                    <td>{{$cart->product_title}}</td>
                    <td>{{$cart->quantity}}</td>
                    <td>${{$cart->price}}</td>
                    <td><img class="img_deg" src="/product/{{$cart->image}}"></td>
                    <td>
                        <a class="btn btn-danger" onclick="confirmation(event)"
                           href="{{url('remove_cart',$cart->id)}}">
                            Remove
                        </a>
                    </td>
                </tr>
                    <?php $totalprice = $totalprice + $cart->price * $cart->quantity ?>
            @endforeach
        </table>
        {{--    <div>--}}
        <div>
            <h1 class="total_deg"> Total Price:: ${{$totalprice}}</h1>
        </div>
        <div>
            <h1 style="font-size: 25px; padding-bottom: 15px">Process to Order</h1>
            <a href="{{url('cash_order')}}" class="btn btn-danger">Cash on Delivery 🥭 </a>
            <a href="{{url('stripe', $totalprice)}}" class="btn btn-danger">Pay Using Card 🍑</a>
        </div>
    </div>
</div>
<!-- footer start -->
@include('home.footer')
<!-- footer end -->
@include('home.copyright')
<script>
    function confirmation(ev) {
        ev.preventDefault();
        var urlToRedirect = ev.currentTarget.getAttribute('href');
        console.log(urlToRedirect);
        swal({
            title: "Are you sure to cancel this product",
            text: "You will not be able to revert this!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willCancel) => {
                if (willCancel) {
                    window.location.href = urlToRedirect;
                }
            });
    }
</script>
@include('home.script')
</body>
</html>
