<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class AdminController extends Controller
{
    //
    public function view_category(){
        $data = category::all();
        return view('admin.category', compact('data'));
    }
    public function add_category(Request $request){
        $data = new category;
        $data -> category_name = $request->category;
        $data -> description = $request->description;
        $data->save();
        return redirect()->back()->with('message', 'Đã Thêm Thành Công Danh Mục: ' . $request->category);
        // TODO: cảnh báo khi thêm 1 danh mục có sắn
    }
    public function delete_category($id){
        $data = category::find($id);
        $s = $data->category_name;
        $data->delete();
        return redirect()->back()->with('message', 'Đã Xóa Thành Công Danh Mục: ' . $s);
    }
//    public function edit_category($id){
//        $data = category::find($id);
//        $s = $data->category_name;
//        $data->delete();
//        return redirect()->back()->with('message', 'Đã Xóa Thành Công Danh Mục: ' . $s);
//    }
//TODO: thêm chỉnh sửa danh mục để sau.
    public function view_product() {
        $category = category::all();
        return view('admin.product', compact('category'));
    }
    public function add_product(Request $request) {
        $product = new product;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->price = $request -> price;
        $product->discount = $request->discount;
        $category = Category::where('category_name', $request->category)->first();
        if(isset($category) && $category !== null) {
            $product->category_id = $category->id;
        } else {
            // Xử lý khi không tìm thấy danh mục
            $product->category_id = 0;
        }
        // Xử lý hình ảnh
        $image = $request -> image;
        $imagename = time().'.'.$image->getClientOriginalExtension();
        $request->image->move('product', $imagename);
        $product->image = $imagename;
        $product->save();
        return redirect()->back()-> with('message', 'sản phẩm đã được thêm thành công bạn ạ');
    }

    public function show_product(){
        $product = Product::all();
        return view('admin.show_product', compact('product'));
    }
}
