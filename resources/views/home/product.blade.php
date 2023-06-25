<section class="product_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                Our <span>products</span>
            </h2>
        </div>
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
                                <a href="" class="option2">
                                    Buy Now
                                </a>
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
