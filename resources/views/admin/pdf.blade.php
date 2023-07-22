<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order PDF</title>
    <style type="text/css">
        .title_deg {
            padding-top: 20px;
            text-align: center;
            font-size: 25px;
            font-weight: bold;
            padding-bottom: 20px;
        }

        .table_deg {
            border: 2px solid green;
            width: 70%;
            margin: auto;
            text-align: center;
        }


        table th, td {
            border: 1px solid rgba(0, 0, 0, 0.49);
            padding: 8px;
        }

        .centered-image {
            display: block;
            margin: 0 auto;
        }

    </style>

</head>
<body>
<div class="title_deg" style="background-color: #d0e9c6">
    <h1>Order Details</h1>
</div>
<table class="table_deg">
    <caption><h2>Thông tin khách hàng</h2></caption>
    <tr class="th_deg">
        <th>
            Customer Name
        </th>
        <th>
            Customer Email
        </th>
        <th>
            Customer Phone
        </th>
        <th>
            Customer Address
        </th>
        <th>
            Customer ID
        </th>
    </tr>
    <tr class="th_deg">
        <td>
            {{$order -> name}}
        </td>
        <td>
            {{$order -> email}}
        </td>
        <td>
            {{$order -> phone}}
        </td>
        <td>
            {{$order -> address}}
        </td>
        <td>
            {{$order -> user_id}}
        </td>
    </tr>
</table>
<br><br>
<br><br>
<table class="table_deg">
    <caption><h2>Thông tin sản phẩm</h2></caption>
    <tr class="th_deg">
        <th>
            Product Name
        </th>
        <th>
            Product Price
        </th>
        <th>
            Product Quantity
        </th>
        <th>
            Payment Status
        </th>
        <th>
            Product ID
        </th>
    </tr>
    <tr class="th_deg">
        <td>
            {{$order -> product_title}}
        </td>
        <td>
            {{$order -> price}}
        </td>
        <td>
            {{$order -> quantity}}
        </td>
        <td>
            {{$order -> payment_status}}
        </td>
        <td>
            {{$order -> product_id}}
        </td>
    </tr>
</table>
<br><br>
<h3 class="title_deg">Một Số Hình Ảnh</h3>
<img class="centered-image" height="250" width="450" src="product/{{$order->image}}" alt="#">
{{--TODO: support cho tiếng việt để sau--}}
</body>
</html>
