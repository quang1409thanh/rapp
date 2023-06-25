<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.css')
    <style type="text/css">
        .div_center {
            text-align: center;
            padding-top: 40px;
        }

        .text_category {
            font-size: 40px;
            padding-bottom: 40px;
        }

        .input_color {
            color: black;
        }
        table {
            border-collapse: collapse;
        }

        table td,
        table th {
            border: 1px solid #fff;
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
            <div class="div_center">
                <h2 class="text_category">Add Category</h2>
                <form action="{{url('add_category')}}" method="POST">
                    @csrf
                    <input class="input_color" type="text" name="category" placeholder="Write category name">
                    <input class="input_color" type="text" name="description" placeholder="Write Description ">
                    <input type="submit" class="btn btn-primary" name="submit" value="Add Catagory">
                </form>
            </div>

            <table class="center">
                <tr class="title">
                    <td>Category Name</td>
                    <td>Description</td>
                    <td>Delete</td>
                    <td>Edit</td>
                </tr>
                @foreach($data as $data)
                    <tr>
                        <td>{{$data->category_name}}</td>
                        <td>{{$data->description}}</td>
                        <td>
                            <a onclick="return confirm('Bạn có chắc là muốn xóa ?')" class="btn btn-danger" href="{{url('delete_category', $data->id)}}">DELETE</a>
                        </td>
                        <td>
                            <a  class="btn btn-primary" href="{{url('edit_category', $data->id)}}">EDIT</a>
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
