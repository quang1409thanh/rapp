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

        </div>
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
</div>
</body>
</html>
