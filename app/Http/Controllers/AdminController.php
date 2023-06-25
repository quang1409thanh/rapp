<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class AdminController extends Controller
{
    //
    public function view_category()
    {
        $data = category::all();
        return view('admin.category', compact('data'));
    }

    public function add_category(Request $request)
    {
        $data = new category;
        $data->category_name = $request->category;
        $data->description = $request->description;
        $data->save();
        return redirect()->back()->with('message', 'Đã Thêm Thành Công Danh Mục: ' . $request->category);
        // TODO: cảnh báo khi thêm 1 danh mục có sắn
    }

    public function delete_category($id)
    {
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
    public function view_product()
    {
        $category = category::all();
        return view('admin.product', compact('category'));
    }

    public function add_product(Request $request)
    {
        $product = new product;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->discount = $request->discount;
        // Chuyển từ category sang category_id
        $category = Category::where('category_name', $request->category)->first();
        if (isset($category) && $category !== null) {
            $product->category_id = $category->id;
        } else {
            // Xử lý khi không tìm thấy danh mục
            $product->category_id = 0;
        }
        // Xử lý hình ảnh
        $image = $request->image;
        $imagename = time() . '.' . $image->getClientOriginalExtension();
        $request->image->move('product', $imagename);
        $product->image = $imagename;
        $product->save();
        return redirect()->back()->with('message', 'sản phẩm đã được thêm thành công bạn ạ');
        // todo: có thể sử dụng cách đặt tên ảnh khác để tránh xung đột file
    }

    public function show_product()
    {
        $product = Product::all();
        return view('admin.show_product', compact('product'));
    }

    public function delete_product($id)
    {
        $product = Product::find($id);
        $s = $product->title;

        // Lấy tên file ảnh từ thuộc tính "image" của sản phẩm
        $imageName = $product->image;

        // Xóa sản phẩm khỏi cơ sở dữ liệu
        $product->delete();

        // Xóa ảnh từ máy chủ
        $imagePath = public_path('product/' . $imageName);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        // TODO: THÊM TỰ CHỌN NGƯỜI DÙNG XÓA MỌI DỮ LIỆU KHỎI SERVER HOẶC CHÍNH SÁCH BẢO MẬT TRONG HẦM
        return redirect()->back()->with('message', 'Đã Xóa Thành Công Sản Phẩm: ' . $s);
    }


    public function update_product($id)
    {
        $product = Product::find($id);
        $category = Category::all();
        return view('admin.update_product', compact('product'), compact('category'));
    }

    public function update_product_confirm(Request $request, $id)
    {
        $product = Product::find($id);
        $product->title = $request->title;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->discount = $request->discount;
        // Chuyển từ category sang category_id
        $category = Category::where('category_name', $request->category)->first();
        if (isset($category) && $category !== null) {
            $product->category_id = $category->id;
        } else {
            // Xử lý khi không tìm thấy danh mục
            $product->category_id = 0;
        }
        if($request->image !=null) {
            // xoá ảnh cũ.
            $old_ImageName = $product->image;
            $old_ImagePath = public_path('product/' . $old_ImageName);
            if (file_exists($old_ImagePath)) {
                unlink($old_ImagePath);
            }
            // Xử lý hình ảnh
            $image = $request->image;
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move('product', $imagename);
            $product->image = $imagename;
        }
        $product->save();
        return redirect()->back()->with('message',' Sản phẩm đã được cập nhật thành công !');
        // todo: có thể sử dụng cách đặt tên ảnh khác để tránh xung đột file
    }
}
