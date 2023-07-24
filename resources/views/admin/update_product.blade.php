<!DOCTYPE html>
<html lang="en">
<head>
    {{--    dùng để dùng được css không có thì css không được --}}
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
            @if (session('message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    {{ session('message') }}
                </div>
            @endif

            <div class="div_center">
                <h1 class="font_size">Update Product</h1>
                <form action="{{url('update_product_confirm', $product->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="div_design">
                        <label>
                            Product Title
                        </label>
                        <input class="text_color" type="text" name="title" placeholder="Nhập tiêu đề đi bạn "
                               required="" value="{{$product->title}}">
                    </div>

                    <div class="div_design">
                        <label>
                            Product Description
                        </label>
                        <input class="text_color" type="text" name="description" placeholder="Nhập mô tả đi bạn "
                               required="" value="{{$product->description}}">
                    </div>

                    <div class="div_design">
                        <label>
                            Product Price
                        </label>
                        <input class="text_color" type="number" name="price" placeholder="Nhập giá đi bạn " required="" value="{{$product->price}}">
                    </div>

                    <div class="div_design">
                        <label>
                            Product Quantity
                        </label>
                        <input class="text_color" type="number" min="0" name="quantity"
                               placeholder="Nhập số lượng sản phẩm đi bạn " required="" value="{{$product->quantity}}">
                    </div>
                    <div class="div_design">
                        <label>
                            Product Discount
                        </label>
                        <input class="text_color" type="text" name="discount" placeholder="Nhập giảm giá đi bạn "
                               required="" value="{{$product->discount}}">
                    </div>
                    <div class="div_design">
                        <label>
                            Product Category
                        </label>
                        @php
                            $data = \App\Models\Category::find($product->category_id);
                        @endphp
                        <select class="text_color" name="category" required="">
                            <option value="{{$data->category_name}}" selected="">
                                {{$data->category_name}}
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
                            Current Image Here
                        </label>
                        <img style="margin:auto;" height="250" width="250" src="/product/{{$product->image}}">
                    </div>
                    <div class="div_design">
                        <label>
                            Change Image Here
                        </label>
                        <input type="file" name="image" >
                    </div>
                    <div class="div_design">
                        <input value="Update Product" class="btn btn-primary" type="submit">
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
