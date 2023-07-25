<!doctype html>
<!doctype html>
<html lang="en">
@include('home.head')
<style>
    .center {
        text-align: center;
        margin: 80px auto;
    }

    table td,
    table th {
        border: 1px solid rgba(0, 0, 0, 0.49);
        padding-left: 10px;
        padding-right: 10px;;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .th_deg {
        background-color: skyblue;
        font-size: 20px;
        font-weight: bold;
    }
</style>
<body>
<div class="hero_area">
    <!-- header section strats -->
    @include('home.navbar')
    <!-- end header section -->
    <div class="center">
        @if($orders->isEmpty())
            <h1 style="font-size: 50px">Không có đơn hàng nào!!</h1>
        @else
            <h1 style="font-size: 50px; padding-bottom: 30px">Danh sách đơn hàng của bạn!!</h1>

            <table>
                <tr>
                    <th class="th_deg">Product Title</th>
                    <th class="th_deg">Quantity</th>
                    <th class="th_deg">Price</th>
                    <th class="th_deg">Payment Status</th>
                    <th class="th_deg">Delivery Status</th>
                    <th class="th_deg">Image</th>
                    <th class="th_deg">Action</th>
                </tr>
                @foreach($orders as $order)
                    <tr>
                        <td>{{$order->product_title}}</td>
                        <td>{{$order->quantity}}</td>
                        <td>{{$order->price}}</td>
                        <td>{{$order->payment_status}}</td>
                        <td>{{$order->delivery_status}}</td>
                        <td>
                            <a href="" class="btn-outline-primary"> Detail </a>
                        </td>
                        @if($order->delivery_status=='Bạn đã xóa đơn hàng')
                            <td>
                                <a class="btn btn-secondary">Canceled</a>
                            </td>
                        @else
                            <td>
                                <a onclick="return confirm('Bạn có chắc là muốn xóa ?')"
                                   href="{{url('cancel_order',$order->id)}}" class="btn btn-danger"> Cancel</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </table>
        @endif
    </div>
</div>
@include('home.copyright')
@include('home.script')
</body>
</html>
