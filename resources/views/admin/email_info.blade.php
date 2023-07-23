<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/public">
    @include('admin.css')
    <style type="text/css">
        .title_deg {
            text-align: center;
            font-size: 25px;
            font-weight: bold;
            padding-bottom: 20px;
        }

        label {
            display: inline-block;
            width: 200px;
            font-size: 15px;
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
            @if(!$notifications -> isEmpty())
                <div>
                    <h1 class="title_deg">Mail Đã gửi tới to {{$order->email}}</h1>
                    <h2> Với những nội dung như sau:</h2>
                    <br>
                    <h1>Bạn có muốn gửi mail tới người này tiếp ??</h1>
                    <a id="sendEmailLink" href="{{ url('send_email', $order->id) }}">Click Here</a>
                    {{--                    todo: hiện thị email và thêm chức năng tiếp tục gửi ở đây--}}
                </div>
            @else
            @endif
                <h1 class="title_deg">Send Email to {{$order->email}}</h1>
                <form action="{{url('send_user_email', $order->id)}}" method="Post">
                    @csrf
                    <div style="padding-left: 35% ; padding-top: 30px">
                        <label style="font-weight: bold">Email Greeting:</label>
                        <label>
                            <input style="color: black" type="text" name="greeting">
                        </label>
                    </div>

                    <div style="padding-left: 35% ; padding-top: 30px">
                        <label style="font-weight: bold">Header Email:</label>
                        <label>
                            <input style="color: black" type="text" name="header">
                        </label>
                    </div>

                    <div style="padding-left: 35% ; padding-top: 30px">
                        <label style="font-weight: bold">Body Email:</label>
                        <label>
                            <input style="color: black" type="text" name="body">
                        </label>
                    </div>

                    <div style="padding-left: 35% ; padding-top: 30px">
                        <label style="font-weight: bold">Email Button Name :</label>
                        <label>
                            <input style="color: black" type="text" name="button">
                        </label>
                    </div>

                    <div style="padding-left: 35% ; padding-top: 30px">
                        <label style="font-weight: bold">Email URL:</label>
                        <label>
                            <input style="color: black" type="text" name="url">
                        </label>
                    </div>

                    <div style="padding-left: 35% ; padding-top: 30px">
                        <label style="font-weight: bold">Last line:</label>
                        <label>
                            <input style="color: black" type="text" name="lastline">
                        </label>
                    </div>

                    <div style="padding-left: 35% ; padding-top: 30px">
                        <input type="submit" name="Send email" class="btn btn-primary" value="Send email">
                    </div>
                </form>
        </div>
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
</div>
</body>
</html>
