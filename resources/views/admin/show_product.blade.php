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
            @if (session('message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    {{ session('message') }}
                </div>
            @endif
            <h2 class="font_size">All Products</h2>
            <table  class="center">
                <tr class="title">
                    <td>Product_title</td>
                    <td>Quantity</td>
                    <td>Category</td>
                    <td>Price</td>
                    <td>Discount</td>
                    <td>View</td>
                    <td>DELETE</td>
                    <td>EDIT</td>
                </tr>
            @foreach($product as $product)
                    <tr>
                        <td>{{$product -> title}}</td>
                        <td>{{$product -> quantity}}</td>
                        @php
                            $data = \App\Models\Category::find($product->category_id);
                        @endphp
                        <td>{{$data->category_name}}</td>
                        <td>{{$product-> price}}</td>
                        <td>{{$product->discount}} %</td>
{{--                        todo: lấy ảnh hiện thị để sau phát triển--}}
                        <td>
                            <a  class="btn btn-primary" href="{{url('#')}}">Detail</a>
                        </td>
                        <td>
                            <a onclick="return confirm('Bạn có chắc là muốn xóa ?')" class="btn btn-danger" href="{{url('delete_product', $product->id)}}">DELETE</a>
                        </td>
                        <td>
                            <a  class="btn btn-success" href="{{url('update_product', $product->id)}}">EDIT</a>
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
