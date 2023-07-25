<!doctype html>
<html lang="en">
@include('home.head')
<style>
    .comment {
        padding-left: 2%;
        border: solid 1px burlywood;
    }
</style>
<body>
@include('sweetalert::alert')
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
                <img src="/product/{{$product->image}}" alt="">
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
                                <input type="number" name="quantity" value="1" min="1"
                                       style=" width: 100px; height: 49px">
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
{{--comment and reply start--}}
<div style="text-align: center; padding-bottom:30px;padding-left: 20%; padding-right: 20%">
    <h1 style="font-size: 30px; text-align: center; padding-bottom: 20px; padding-top: 20px">
        Comments
    </h1>
    <form action="{{url('/add_comment', $product->id)}}" method="post">
        @csrf
        <label>
<textarea style="height: 150px; width: 600px" placeholder="Comment something here" name="comment">
</textarea>
        </label>
        <br>
        @if (session('message'))
            <div class="alert alert-success" >
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session('message') }}
            </div>
        @endif
        <input type="submit" class="btn btn-primary" value="Comment">
    </form>

</div>
<div style="padding-left: 20%; padding-right: 20%; padding-bottom: 1%">
    <div style="padding-left: 2%;background-color: #d0e9c6;padding-right: 2%; padding-bottom: 1%" ;>
        <h1 style="font-size: 20px; padding-bottom: 20px; padding-top: 10px">All Comments</h1>
        @if($comments!=null)
            @if($comments->isEmpty())
                <h5>Chưa có bình luận về sản phẩm này</h5>
            @else
                @foreach($comments as $comment)
                    <div class="comment">
                        <b>{{$comment->name}}</b>
                        <p>{{$comment -> comment}}</p>
                        <a style="color: blue" href="javascript::void(0);" onclick="reply(this)"
                           Comment_id= {{$comment->id}}>Reply</a>
                        <br>
                        <br>
                        @foreach($replies as $reply)
                            @if($reply -> comment_id == $comment ->id )
                                <div style="padding-left: 2%; padding-bottom: 10px; padding-top: 10px" ;>
                                    <b>{{$reply->name}}</b>
                                    <p>{{$reply->reply}}</p>
                                    <a style="color: blue" href="javascript::void(0);" onclick="reply(this)"
                                       Comment_id= {{$comment->id}}>Reply</a>
                                    {{--                                    todo: hiện thị các thuộc tính của cmt và reply--}}
                                    <br>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            @endif
        @else
            <div>
                <h5>Login to view comment</h5>
                <a href="{{url('redirect')}}">Click here</a>
            </div>
        @endif
        {{--        Replt Box--}}
        <div style="display:none;" class="replyDiv">
            <form action="{{url('add_reply', $product->id)}}" method="post">
                @csrf
                <label for="commentId"></label><input type="text" id="commentId" name="commentId" hidden="">
                <label>
                    <textarea style="height: 100px;width: 500px;" placeholder="write something here"
                              name="reply"></textarea>
                </label>
                <br>
                <button href="" class="btn btn-primary">Reply</button>
                <a href="javascript::void(0)" class="btn" onclick="reply_close(this)">Close</a>
            </form>
        </div>

    </div>
</div>

@include('home.client')
@include('home.footer')
<script type="text/javascript">
    function reply(caller) {
        document.getElementById('commentId').value = $(caller).attr('Comment_id');
        $('.replyDiv').insertAfter($(caller));
        $('.replyDiv').show()
    }

    function reply_close(caller) {
        $('.replyDiv').hide()
    }
</script>

@include('home.script')

</body>
</html>
