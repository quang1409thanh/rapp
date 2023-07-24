<section class="product_section layout_padding" style="background-color: rgba(5,246,236,0.11)">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                All <span>products</span>
            </h2>
            <br>
            <div>
                <form action="{{url('product_search')}}" method="GET">
                    @csrf
                    <label>
                        <input style="width: 500px" type="text" name="search" placeholder="Search for something">
                    </label>
                    <input type="submit" value="search">
                </form>
                <script>
                    const inputField = document.querySelector('input[name="search"]');
                    inputField.addEventListener('click', function () {
                        const urlParams = new URLSearchParams(window.location.search);
                        const searchKeyword = urlParams.get('search');
                        if (searchKeyword) {
                            this.value = searchKeyword;
                        }
                    });
                    inputField.click();
                </script>
            </div>
        </div>
        @if (session('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session('message') }}
            </div>
        @endif
        @if(isset($search_text) && !$products->isEmpty())
            <p style="font-size: 20px; padding-bottom: 10px">Kết quả tìm kiếm của bạn là: </p>
        @endif
        <div class="row">
            {{--            todo: thực hiện làm hiện thị trang chi tiết cá nhân sau khi hoàn thành khung--}}
            @if($products->isEmpty())
                <p style="font-size: 24px">🔴Không có sản phẩm nào!!!</p>
            @else
                @foreach($products as $product)
                    <div class="col-sm-6 col-md-4 col-lg-4">
                        <div class="box">
                            <div class="option_container">
                                <div class="options">
                                    <a href="{{url('detail_product',$product->id)}}" class="option1">
                                        {{$product->title}}
                                    </a>
                                    <form action="{{url('add_cart',$product->id)}}" method="POST">
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
                            </div>
                        </div>
                    </div>
                @endforeach
                <span style="padding-top: 20px">
                {!!$products->withQueryString()->links('pagination::bootstrap-5')!!}
            </span>
            @endif
        </div>
        {{--        <div class="btn-box">--}}
        {{--            <a href="">--}}
        {{--                View All products--}}
        {{--            </a>--}}
        {{--        </div>--}}
    </div>
</section>
