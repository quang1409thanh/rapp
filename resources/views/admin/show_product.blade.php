<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.css')
    <style>
        .center{
            margin: auto;
            width: 70%;
            border: solid 2px chartreuse;
            text-align: center;
            margin-top: 40px;
        }
        .font_size{
            text-align: center;
            font-size: 40px;
            padding-top: 20px;
        }
        table {
            border-collapse: collapse;
        }

        table td,
        table th {
            border: 1px solid #fff;
            padding: 8px;
        }

        .title{
            font-size: 20px;
            color: yellow;
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
            <h2 class="font_size">All Products</h2>
            <table  class="center">
                <tr class="title">
                    <th>Product_title</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>View</th>
                </tr>
                    @foreach($product as $product)
                    <tr>
                    <th>{{$product -> title}}</th>
                        <th>{{$product -> description}}</th>
                        <th>{{$product -> quantity}}</th>
                        <th>{{$product -> category_id}}</th>
                        <th>{{$product-> price}}</th>
                        <th>{{$product->discount}} %</th>
                        <td>
                            <a  class="btn btn-primary" href="{{url('#')}}">Detail</a>
                        </td>
                    </tr>
                @endforeach
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
