<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.css')
    <style>
        .div_center {
            text-align: center;
            padding-top: 40px;
        }

        .font_size {
            font-size: 40px;
            padding-bottom: 40px;
        }

        .text_color {
            color: black;
        }

        label {
            display: inline-block;
            width: 200px;
        }

        .div_design {
            padding-bottom: 14px;
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
            <div class="div_center">
                @if (session('message'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        {{ session('message') }}
                    </div>
                @endif
                <h1 class="font_size">Add Product</h1>
                <form action="{{url('add_product')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="div_design">
                        <label>
                            Product Title
                        </label>
                        <input class="text_color" type="text" name="title" placeholder="Nhập tiêu đề đi bạn "
                               required="">
                    </div>

                    <div class="div_design">
                        <label>
                            Product Description
                        </label>
                        <input class="text_color" type="text" name="description" placeholder="Nhập mô tả đi bạn "
                               required="">
                    </div>

                    <div class="div_design">
                        <label>
                            Product Price
                        </label>
                        <input class="text_color" type="number" name="price" placeholder="Nhập giá đi bạn " required="">
                    </div>

                    <div class="div_design">
                        <label>
                            Product Quantity
                        </label>
                        <input class="text_color" type="number" min="0" name="quantity"
                               placeholder="Nhập số lượng sản phẩm đi bạn " required="">
                    </div>
                    <div class="div_design">
                        <label>
                            Product Discount
                        </label>
                        <input class="text_color" type="text" name="discount" placeholder="Nhập giảm giá đi bạn "
                               required="">
                    </div>
                    <div class="div_design">
                        <label>
                            Product Category
                        </label>
                        <select class="text_color" name="category" required="">
                            <option value="" selected="">
                                Thêm danh mục ở đây
                            </option>
                            @foreach($category as $category)
                                <option>
                                    {{$category->category_name}}
                                </option>

                            @endforeach
                        </select>
                    </div>
                    <div class="div_design">
                        <label>
                            Product Image Here
                        </label>
                        <input type="file" name="image" required="">
                    </div>
                    <div class="div_design">
                        <input value="Add Product" class="btn btn-primary" type="submit">
                    </div>
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
