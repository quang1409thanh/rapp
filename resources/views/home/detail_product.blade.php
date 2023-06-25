<!doctype html>
<html lang="en">
@include('home.head')
<body>
@include('home.navbar')
<div class="col-sm-6 col-md-4 col-lg-4" style="margin:auto; width: 50%; padding: 30px ">
    <div class="box">
        <div class="img-box" style="padding-top: 20px">
            <img src="product/{{$product->image}}" alt="">
        </div>
        <div class="detail-box">
            <h5>
                {{$product->title}}
            </h5>
            {{--                                todo: Hiện thị giá chiết khấu sản phẩm--}}
            @if($product->discount != null)
                <h6 style="color: red">
                    Discount price
                    <br>
                    ${{ number_format($product->price * (1 - $product->discount/100), 2) }}
                </h6>
                <h6 style="text-decoration: line-through; color : blue">
                    Price
                    <br>
                    ${{$product->price}}
                </h6>
            @else
                <h6 style="color: blue">
                    Price
                    <br>
                    ${{$product->price}}
                </h6>
            @endif
            <h6>
                Quantity: {{$product->quantity}}
            </h6>
            <h6>
                Description: {{$product->description}}
            </h6>
            @php
                $data = \App\Models\Category::find($product->category_id);
            @endphp
            <h6>
                Category: {{$data->category_name}}
            </h6>
            <br>
            <a href="" class="btn btn-primary">
                Add to Cart
            </a>
        </div>
    </div>
</div>

@include('home.footer')
</body>
</html>
