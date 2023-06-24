<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class AdminController extends Controller
{
    //
    public function view_category(){
        return view('admin.category');
    }
    public function add_category(Request $request){
        $data = new category;
        $data -> category_name = $request->category;
        $data -> description = $request->description;
        $data->save();
        return redirect()->back()->with('message', 'Đã Thêm Thành Công Danh Mục: ' . $request->category);
    }
}
