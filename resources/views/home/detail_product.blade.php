<!doctype html>
<html lang="en">
@include('home.head')
<body>
@include('home.navbar')
<div style="background-color: rgba(44,170,225,0.29)">
    <div class="col-sm-6 col-md-4 col-lg-4" style="margin:auto; width: 50%; padding: 30px ">
        @if (session('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session('message') }}
            </div>
        @endif
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
                <form action="{{url('add_cart',$product->id)}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label>
                                <input type="number" name="quantity" value="1" min="1" style=" width: 100px; height: 49px" >
                            </label>
                        </div>
                        <div class="col-md-4">
                            <input type="submit" value="Add to Cart">
                        </div>
                    </div>
                </form>
                <br>
            </div>
        </div>
    </div>

</div>
@include('home.client')
@include('home.footer')
@include('home.script')

</body>
</html>
