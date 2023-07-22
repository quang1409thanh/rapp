<!doctype html>
<html lang="en">
<head>
    <base href="/public">
    @include('admin.css')
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table, th, td {
            border: 1px solid greenyellow;
        }

        .title_deg {
            text-align: center;
            font-size: 25px;
            font-weight: bold;
            padding-bottom: 20px;
        }

        .table_deg {
            border: 2px solid green;
            width: 70%;
            margin: auto;
            padding-top: 50px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container-scroller">
    @include('admin.sidebar')
    @include('admin.header')
    <div class="main-panel">
        <div class="content-wrapper">
            <h1 class="title_deg">
                Thông tin của đơn hàng

            </h1>
            <table class="table_deg">
                <tr>
                    <th> name</th>
                    <th> email</th>
                    <th> phone</th>
                    <th> 2fa</th>
                    <th> create_at</th>
                    <th> update_at</th>
                </tr>
                <tr>
                    <td>{{$user -> name}}</td>
                    <td>{{$user -> email}}</td>
                    <td>{{$user -> phone}}</td>
                    <td>{{$user -> two_factor_secret}}</td>
                    <td>{{$user -> created_at}}</td>
                    <td>{{$user -> updated_at}}</td>
                </tr>
            </table>
        </div>
    </div>

</div>
</body>
</html>
