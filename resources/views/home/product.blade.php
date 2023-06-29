<section class="product_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                Our <span>products</span>
            </h2>
        </div>
        @if (session('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session('message') }}
            </div>
        @endif
        <div class="row">
            {{--            todo: thực hiện làm hiện thị trang chi tiết cá nhân sau khi hoàn thành khung--}}
            @foreach($product as $prd)
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <div class="box">
                        <div class="option_container">
                            <div class="options">
                                <a href="{{url('detail_product',$prd->id)}}" class="option1">
                                    {{$prd->title}}
                                </a>
                                <form  action="{{url('add_cart',$prd->id)}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>
                                                <input type="number" name="quantity" value="1" min="1"
                                                       style=" width: 100px; height: 49px">
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="submit" value="Add to Cart">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="img-box">
                            <img src="product/{{$prd->image}}" alt="">
                        </div>
                        <div class="detail-box">
                            <h5>
                                {{$prd->title}}
                            </h5>
                            {{--                                todo: Hiện thị giá chiết khấu sản phẩm--}}
                            @if($prd->discount != null)
                                <h6 style="color: red">
                                    Discount price
                                    <br>
                                    ${{ number_format($prd->price * (1 - $prd->discount/100), 2) }}
                                </h6>
                                <h6 style="text-decoration: line-through; color : blue">
                                    Price
                                    <br>
                                    ${{$prd->price}}
                                </h6>
                            @else
                                <h6 style="color: blue">
                                    Price
                                    <br>
                                    ${{$prd->price}}
                                </h6>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            <span style="padding-top: 20px">
                {!!$product->withQueryString()->links('pagination::bootstrap-5')!!}
            </span>
        </div>
        {{--        <div class="btn-box">--}}
        {{--            <a href="">--}}
        {{--                View All products--}}
        {{--            </a>--}}
        {{--        </div>--}}
    </div>
</section>
