<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            $total_orders = Order::where('user_id', '=', $user_id)->count();
            $total_carts = Cart::where('user_id', '=', $user_id)->count();;
        } else {
            $total_orders = null;
            $total_carts = null;
        }
        $products = Product::paginate(6);
        return view('home.userpage', compact('products', 'total_orders', 'total_carts'));
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
        } else if ($usertype == '0') {
            $products = Product::paginate(6);
            if (Auth::id()) {
                $user = Auth::user();
                $user_id = $user->id;
                $total_orders = Order::where('user_id', '=', $user_id)->count();
                $total_carts = Cart::where('user_id', '=', $user_id)->count();;
            } else {
                $total_orders = null;
                $total_carts = null;
            }
            return view('home.userpage', compact('products', 'total_orders', 'total_carts'));
        } else {
            $products = Product::paginate(6);
            return view('home.userpage', compact('products'));
        }
    }


    public
    function detail_product($id)
    {
        $product = Product::find($id);
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            $comments = Comment::where('product_id', '=', $id)->orderByDesc('name')->get();
            $replies = Reply::where('product_id', '=', $id)->get();
            $total_orders = Order::where('user_id', '=', $user_id)->count();
            $total_carts = Cart::where('user_id', '=', $user_id)->count();;
        } else {
            $comments = null;
            $replies = null;
            $total_orders = null;
            $total_carts = null;
        }
        return view('home.detail_product', compact('product', 'comments', 'replies', 'total_orders', 'total_carts'));
    }

    public
    function add_cart(Request $request, $id)
    {
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            $product = Product::find($id);
            $product_exist_id = Cart::where('product_id', '=', $id)->where('user_id', '=', $user_id)->get('id')->first();;
            if ($product_exist_id) {
                $cart = Cart::find($product_exist_id)->first();
                $quantity = $cart->quantity;
                $price = $cart->price;
                $cart->quantity = $request->quantity + $quantity;
                if ($cart->discount != null) {
                    $cart->price = number_format($product->price * (1 - $product->discount / 100), 2);
                    $cart->price = $price + str_replace(',', '', $cart->price) * $request->quantity;
                    // lưu vào cơ sở dữ liệu ko được có dấu , cái ở trên là loại bỏ dấy ,
                } else {
                    $cart->price = $price + $product->price * $request->quantity;
                }
                $cart->save();
                Alert::info('Bạn đã cập nhật thành ' . $quantity . ' số lượng cho sản phẩm này rồi bro!');
                return redirect()->back()->with('message', 'Bạn đã cập nhật thêm ' . $quantity . ' số lượng cho sản phẩm này rồi bro!');
            } else {
                $cart = new cart;
                $cart->name = $user->name;
                $cart->email = $user->email;
                $cart->phone = $user->phone;
                $cart->address = $user->address;
                $cart->user_id = $user->id;
                $cart->product_title = $product->title;
                if ($product->discount != null) {
                    $cart->price = number_format($product->price * (1 - $product->discount / 100), 2);
                    $cart->price = str_replace(',', '', $cart->price) * $request->quantity;
                    // lưu vào cơ sở dữ liệu ko được có dấu , cái ở trên là loại bỏ dấy ,
                } else {
                    $cart->price = $product->price * $request->quantity;
                }
                $cart->image = $product->image;
                $cart->Product_id = $product->id;
                $cart->quantity = $request->quantity;
                $cart->save();
                Alert::info('Bạn đã thêm thành công vào giỏ hàng rồi bro !');
                return redirect()->back()->with('message', 'Bạn đã thêm thành công vào giỏ hàng rồi bro !');

            }
        } else {
            return redirect('login');
        }
    }

    public
    function show_cart()
    {
        if (Auth::id()) {
            $id = Auth::user()->id;
            $cart = Cart::where('user_id', '=', $id)->get();
            $total_orders = Order::where('user_id', '=', $id)->count();
            $total_carts = Cart::where('user_id', '=', $id)->count();;
            return view('home.show_cart', compact('cart', 'total_orders', 'total_carts'));

        } else {
            return redirect('login');
        }
    }

    public
    function remove_cart($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        return redirect()->back();
    }

    public
    function cash_order()
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

    public
    function stripe($totalprice)
    {
        return view('home.stripe', compact('totalprice'));
    }

    public
    function stripePost(Request $request, $totalprice)
    {
        if ($totalprice > 0) {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            Stripe\Charge::create([
                "amount" => $totalprice * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Cảm ơn đã thanh toán"
            ]);

            Session::flash('success', 'Payment successful!');
            return back();
        } else {
            // Thay đổi thành
            Session::flash('error', 'Payment failed(chưa chọn sản phẩm nào)!'); // Thông báo lỗi thay thế
            return back();
        }

    }

    public
    function show_order()
    {
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $orders = Order::where('user_id', '=', $userid)->get();
            $total_orders = Order::where('user_id', '=', $userid)->count();
            $total_carts = Cart::where('user_id', '=', $userid)->count();;
            return view('home.order', compact('orders', 'total_orders', 'total_carts'));
        } else {
            return redirect('login');
        }
    }

    public
    function cancel_order($id)
    {
        $order = Order::find($id);
        $order->delivery_status = 'Bạn đã xóa đơn hàng';
        $order->save();
        return redirect()->back();
    }

    public
    function add_comment(Request $request, $id)
    {
        if (Auth::id()) {
            if ($request->comment != null) {
                $comment = new Comment();
                $comment->name = Auth::user()->name;
                $comment->user_id = Auth::user()->id;
                $comment->comment = $request->comment;
                $comment->product_id = $id;
                $comment->save();
                return redirect()->back();
            } else {
                return redirect()->back()->with('message', 'Bạn chưa viết gì !!!');
            }
        } else {
            return redirect('login');
        }
    }

    public
    function add_reply(Request $request, $id)
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

    public
    function product_search(Request $request)
    {
        $search_text = $request->search;

        $products = Product::where('title', 'LIKE', "%$search_text%")
            ->orWhereHas('category', function ($query) use ($search_text) {
                $query->where('category_name', 'LIKE', "%$search_text%"); // khó hiểu -> liên quan đến hàm  category trong Mode/Product
            })
            ->paginate(6);
        if ($request->has('from_home')) {
            if (Auth::id()) {
                $user = Auth::user();
                $user_id = $user->id;
                $total_orders = Order::where('user_id', '=', $user_id)->count();
                $total_carts = Cart::where('user_id', '=', $user_id)->count();;
            } else {
                $total_orders = null;
                $total_carts = null;
            }
            return view('home.userpage', compact('products', 'search_text', 'total_orders', 'total_carts'));
        } else {
            return view('home.all_products', compact('products', 'search_text'));
        }
    }

    public
    function products(Request $request)
    {
        $products = Product::paginate(6);
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            $total_orders = Order::where('user_id', '=', $user_id)->count();
            $total_carts = Cart::where('user_id', '=', $user_id)->count();;
        } else {
            $total_orders = null;
            $total_carts = null;
        }
        return view('home.all_products', compact('products', 'total_orders', 'total_carts'));
    }
}
