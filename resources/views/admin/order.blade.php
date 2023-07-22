<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.css')
    <style type="text/css">
        .title_deg{
            text-align: center;
            font-size: 25px;
            font-weight: bold;
            padding-bottom: 20px;
        }
        .table_deg{
            border: 2px solid green;
            width: 70%;
            margin: auto;
            padding-top: 50px;
            text-align: center;
        }

        tr:nth-child(odd) {
            background-color: rgba(245, 245, 245, 0.48); /* Tô màu nền cho các hàng lẻ */
        }

        tr:first-child{
            background-color: aquamarine;
            color: black;

        }
        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.34); /* Tô màu nền cho các hàng chẵn */
        }
        table th, td {
            border: 1px solid #fff;
            padding: 8px;
        }
        .centered-form {
            width: 400px; /* Đặt chiều rộng cố định cho form */
            margin: 0 auto; /* Căn giữa form theo chiều ngang */
            padding-bottom: 30px;
        }

        .centered-form form {
            display: inline-block; /* Sử dụng display inline-block để form chỉ chiếm không gian cần thiết */
            text-align: left; /* Đảm bảo nội dung trong form căn trái */
        }

    </style>
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_sidebar.html -->
    @include('admin.sidebar')
    <!-- partial -->
    @include('admin.header')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <h1 class="title_deg"> ALL Orders</h1>

            <div class="centered-form">
                <form action="{{url('search')}}" method="get">
                    <label>
                        <input style="color: black" type="text" name="search" placeholder="Search for something">
                    </label>
                    <input type="submit" value="Search" class="btn btn-outline-primary">
                </form>
            </div>

            <table class="table_deg">
                <tr class="th_deg">
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Product_title</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Payment Status</th>
                    <th>Delivery Status</th>
                    <th>Delivered</th>
                    <th>Print PDF</th>
                    <th>Send Email</th>

                </tr>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <a href="{{ url('/t_info', $order->id) }}">{{ $order->name }}</a>
                        </td>
                        <td>{{$order->email}}</td>
                        <td>{{$order->address}}</td>
                        <td>{{$order->phone}}</td>
                        <td>{{$order->product_title}}</td>
                        <td>{{$order->quantity}}</td>
                        <td>{{$order->price}}</td>
                        <td>{{$order->payment_status}}</td>
                        <td>{{$order->delivery_status}}</td>
                        <td >
                            @if($order->delivery_status == 'Đang Xử Lý')
                                <a href="{{url('delivered', $order->id)}} " onclick="return confirm('Đơn hàng này đã giao ư ? ')" class="btn btn-primary"> ☑️Delivered</a>
                            @else
                                <p style="color: #03f303"> ✅ Delivered</p>
                            @endif
                        </td>
                        <td>
                            <a href="{{url('print_pdf', $order->id)}}" class="btn btn-secondary">Print</a>
                        </td>
                        <td>
                            <a href="{{url('send_email', $order->id)}}" class="btn btn-info">Send</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="16">
                            No Data Found
                        </td>
                    </tr>

                @endforelse
            </table>
        </div>
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
</div>
</body>
</html>
