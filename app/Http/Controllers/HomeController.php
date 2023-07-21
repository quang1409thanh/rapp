<?php

namespace App\Http\Controllers;

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
    public function index(){
        $product = Product::paginate(3);
        return view('home.userpage', compact('product'));
    }

    //
    public function redirect() {
        $usertype = Auth::user()-> usertype;
        if($usertype == '1' ) {
            return view('admin.home');
        }
        else {
            $product = Product::paginate(3);
            return view('home.userpage', compact('product'));
        }
    }
    public function detail_product($id){
        $product = Product::find($id);
        return view('home.detail_product', compact('product'));
    }

    public function add_cart(Request $request, $id){
        if(Auth::id()){
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
                $cart->price = number_format($product->price * (1 - $product->discount/100), 2);
                $cart->price = str_replace(',', '', $cart->price);
                // lưu vào cơ sở dữ liệu ko được có dấu , cái ở trên là loại bỏ dấy ,
            } else {
                $cart->price = $product->price;
            }
            $cart->image = $product->image;
            $cart->Product_id = $product->id;
            $cart->quantity = $request->quantity;
            $cart->save();
            return redirect()->back()->with('message','Bạn đã thêm thành công vào giỏ hàng rồi bro !');
        }
        else{
            return redirect('login');
        }
    }

    public function show_cart(){
        if(Auth::id()){
            $id = Auth::user()->id;
            $cart = Cart::where('user_id','=',$id)->get();
            return view('home.show_cart', compact('cart'));

        }
        else{
            return redirect('login');
        }
    }

    public function remove_cart($id){
        $cart = Cart::find($id);
        $cart->delete();
        return redirect()->back();
    }

    public function cash_order(){
        $user = Auth::user();
        $userid = $user->id;
        $cart = Cart::where('user_id', '=', $userid)->get();
        foreach ($cart as $item){
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
            $order->payment_status = 'cash on delivery';
            $order->delivery_status = 'processing';
            $order->save();
            $cart_id = $item->id;
            $cart_fi = Cart::find($cart_id);
            $cart_fi ->delete();
        }
        if(!$cart->isEmpty()) {
            return redirect()->back()->with('message', 'Đơn hàng đã được giao đến địa chỉ của bạn rồi đó !!!');
        }
        else
            return redirect()->back()->with('message', 'Giỏ hàng rỗng, xin vui lòng thêm sản phẩm vào giỏ hàng!!!')->with('url', '/');
    }

//    public function stripe($totalprice){
//        return view('home.stripe', compact('totalprice'));
//    }
//    public function stripePost(Request $request)
//    {
//        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
//
//        Stripe\Charge::create ([
//            "amount" => 100 * 100,
//            "currency" => "usd",
//            "source" => $request->stripeToken,
//            "description" => "Cảm ơn đã thanh toán"
//        ]);
//
//        Session::flash('success', 'Payment successful!');
//
//        return back();
//    }

}
