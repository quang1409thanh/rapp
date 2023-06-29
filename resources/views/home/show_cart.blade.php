<!doctype html>
<html lang="en">
@include('home.head')
<style>

    table {
        border-collapse: collapse;
    }

    table td,
    table th {
        border: 1px solid #000;
        padding: 8px;
    }
    .center{
        margin: auto;
        width: 70%;
        text-align: center;
        margin-top: 30px;
        border: 3px solid chartreuse;
    }
    .title{
        background: skyblue;
        font-size: 24px;
        color: red;
    }
    .img_deg{
        display: flex;
    }
    .total_deg{
        font-size: 30px;
        color: blue;
        padding: 40px;
        text-align: center;
    }

</style>
<body>
<div class="hero_area">
    <!-- header section strats -->
    @include('home.navbar')
    <!-- end header section -->

    <table class="center">
        <tr class="title">
            <th>Product Title</th>
            <th>Product Quantity</th>
            <th>Price</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        <?php $totalprice=0; ?>


        @foreach($cart as $cart)
            <tr>
                <td>{{$cart->product_title}}</td>
                <td>{{$cart->quantity}}</td>
                <td>${{$cart->price}}</td>
                <td><img class="img_deg" src="/product/{{$cart->image}}"></td>
                <td>
                    <a class="btn btn-danger" onclick="return confirm('Bạn muốn xóa khỏi giỏ hàng ?')" href="{{url('remove_cart',$cart->id)}}">
                        Remove
                    </a>
                </td>
            </tr>
            <?php $totalprice = $totalprice + $cart -> price ?>
        @endforeach
    </table>
    <div>
        <div>
            <h1 class = "total_deg"> Total Price:: ${{$totalprice}}</h1>
        </div>
    </div>
    <!-- footer start -->
{{--    @include('home.footer')--}}
    <!-- footer end -->
    @include('home.script')
</div>
</body>
</html>
