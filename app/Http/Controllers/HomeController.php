<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use function PHPUnit\Framework\isEmpty;
use Session;
use Stripe;

class HomeController extends Controller
{
    public function index()
    {
        $product = Product::paginate(6);
        return view('home.userpage', compact('product'));
        //TODO: fix khi ở trạng thái admin nhưng nếu gõ url "/" thì sẽ hiện ra index này -> fix về trang admin
    }

    //
    public function redirect()
    {
        $usertype = Auth::user()->usertype;
        if ($usertype == '1') {
            $total_product = Product::all()->count();
            $total_orders = Order::all()->count();
            $total_customers = User::all()->count();
            $orders = Order::all();
            $revenue = 0;
            $order_delivered = 0;
            $order_processing = 0;
            foreach ($orders as $order) {
                if ($order->delivery_status == "Đã Giao Hàng") {
                    $revenue = $revenue + $order->price;
                    $order_delivered = $order_delivered + 1;
                } else {
                    $order_processing = $order_processing + 1;
                }
            }

            return view('admin.home', compact('total_product', 'total_orders', 'total_customers', 'revenue', 'order_delivered', 'order_processing'));
        } else {
            $product = Product::paginate(6);
            return view('home.userpage', compact('product'));
        }
    }

    public function detail_product($id)
    {
        $product = Product::find($id);
        if (Auth::id()) {
            $comments = Comment::where('product_id', '=', $id)->orderByDesc('name')->get();

            $replies = Reply::where('product_id', '=', $id)->get();
        } else {
            $comments = null;
            $replies = null;
        }
        return view('home.detail_product', compact('product', 'comments', 'replies'));
    }

    public function add_cart(Request $request, $id)
    {
        if (Auth::id()) {
            $user = Auth::user();
            $product = Product::find($id);
            $cart = new cart;
            $cart->name = $user->name;
            $cart->email = $user->email;
            $cart->phone = $user->phone;
            $cart->address = $user->address;
            $cart->user_id = $user->id;
            $cart->product_title = $product->title;
            if ($product->discount != null) {
                $cart->price = number_format($product->price * (1 - $product->discount / 100), 2);
                $cart->price = str_replace(',', '', $cart->price);
                // lưu vào cơ sở dữ liệu ko được có dấu , cái ở trên là loại bỏ dấy ,
            } else {
                $cart->price = $product->price;
            }
            $cart->image = $product->image;
            $cart->Product_id = $product->id;
            $cart->quantity = $request->quantity;
            $cart->save();
            return redirect()->back()->with('message', 'Bạn đã thêm thành công vào giỏ hàng rồi bro !');
        } else {
            return redirect('login');
        }
    }

    public function show_cart()
    {
        if (Auth::id()) {
            $id = Auth::user()->id;
            $cart = Cart::where('user_id', '=', $id)->get();
            return view('home.show_cart', compact('cart'));

        } else {
            return redirect('login');
        }
    }

    public function remove_cart($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        return redirect()->back();
    }

    public function cash_order()
    {
        $user = Auth::user();
        $userid = $user->id;
        $cart = Cart::where('user_id', '=', $userid)->get();
        foreach ($cart as $item) {
            $order = new Order();
            $order->name = $item->name;
            $order->email = $item->email;
            $order->address = $item->address;
            $order->phone = $item->phone;
            $order->user_id = $item->user_id;
            $order->product_title = $item->product_title;
            $order->price = $item->price;
            $order->quantity = $item->quantity;
            $order->image = $item->image;
            $order->product_id = $item->Product_id;
            $order->payment_status = 'Thanh Toán Khi Nhận';
            $order->delivery_status = 'Đang Xử Lý';
            $order->save();
            $cart_id = $item->id;
            $cart_fi = Cart::find($cart_id);
            $cart_fi->delete();
        }
        if (!$cart->isEmpty()) {
            return redirect()->back()->with('message', 'Đơn hàng đã được giao đến địa chỉ của bạn rồi đó !!!');
        } else
            return redirect()->back()->with('message', 'Giỏ hàng rỗng, xin vui lòng thêm sản phẩm vào giỏ hàng!!!')->with('url', '/');
    }

    public function stripe($totalprice)
    {
        return view('home.stripe', compact('totalprice'));
    }

    public function stripePost(Request $request, $totalprice)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create([
            "amount" => $totalprice * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Cảm ơn đã thanh toán"
        ]);

        $user = Auth::user();
        $userid = $user->id;
        $cart = Cart::where('user_id', '=', $userid)->get();
        foreach ($cart as $item) {
            $order = new Order();
            $order->name = $item->name;
            $order->email = $item->email;
            $order->address = $item->address;
            $order->phone = $item->phone;
            $order->user_id = $item->user_id;
            $order->product_title = $item->product_title;
            $order->price = $item->price;
            $order->quantity = $item->quantity;
            $order->image = $item->image;
            $order->product_id = $item->Product_id;
            $order->payment_status = 'Đã Thanh Toán';
            $order->delivery_status = 'Đang Xử Lý';
            $order->save();
            $cart_id = $item->id;
            $cart_fi = Cart::find($cart_id);
            $cart_fi->delete();
        }

        Session::flash('success', 'Payment successful!');

        return back();
    }

    public function show_order()
    {
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $orders = Order::where('user_id', '=', $userid)->get();
            return view('home.order', compact('orders'));
        } else {
            return view('login');
        }
    }

    public function cancel_order($id)
    {
        $order = Order::find($id);
        $order->delivery_status = 'Bạn đã xóa đơn hàng';
        $order->save();
        return redirect()->back();
    }

    public function add_comment(Request $request, $id)
    {
        if (Auth::id()) {
            $comment = new Comment();
            $comment->name = Auth::user()->name;
            $comment->user_id = Auth::user()->id;
            $comment->comment = $request->comment;
            $comment->product_id = $id;
            $comment->save();

            return redirect()->back();
        } else {
            return redirect('login');
        }
    }

    public function add_reply(Request $request, $id)
    {
        if (Auth::id()) {
            $reply = new Reply();
            $reply->name = Auth::user()->name;
            $reply->user_id = Auth::user()->id;
            $reply->comment_id = $request->commentId;
            $reply->reply = $request->reply;
            $reply->product_id = $id;
            $reply->save();
            return redirect()->back();
        } else {
            return redirect('login');
        }
    }
}
