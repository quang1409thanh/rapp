<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
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
}
