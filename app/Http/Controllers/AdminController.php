<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Notifications\SendEmailNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Notification;

// Import model Notification
use Illuminate\Support\Facades\Notification as FacadeNotification;
use Illuminate\Support\Str;

// Import class Notification Facade
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
        if ($request->image != null) {
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
        return redirect()->back()->with('message', ' Sản phẩm đã được cập nhật thành công !');
        // todo: có thể sử dụng cách đặt tên ảnh khác để tránh xung đột file
    }

    public function order()
    {
        $orders = Order::all();
        return view('admin.order', compact('orders'));
    }

    public function delivered($id)
    {
        $order = Order::find($id);
        $order->delivery_status = "Đã Giao Hàng";
        $order->payment_status = "Đã Thanh Toán";
        $order->save();
        return redirect()->back();
        //TODO: sửa lại để khi load lại trang thì vẫn ở trạng thái hiện tại
    }

    public function see_info($order_id)
    {
        $order = Order::find($order_id);
        if ($order) {
            // Accessing the buyer relationship to get the associated buyer's ID
            $user_id = $order->user_id;
            $user = User::find($user_id);
            // Now you can use $buyer_id for further processing or display it if needed.
            // For example, you can return it in a response or pass it to a view.
            return view('admin.t_info', compact('user'));
        } else {
            abort(404, 'Order not found');
        }
    }

    public function print_pdf($id)
    {
        $order = Order::find($id);
        $filename = 'order_details' . $order->user_id . $order->id . '.pdf';
        $pdf = PDF::loadView('admin.pdf', compact('order'));
//        return  view('admin.pdf', compact('order'));
        return $pdf->download($filename);
    }

    public function send_email($id)
    {
        $order = Order::find($id);
        $notifications = Notification::where('notifiable_type', 'App\\Models\\User')
            ->where('notifiable_id', $order->user_id)
            ->get();
        return view('admin.email_info', compact('order','notifications'));
    }

    public function send_user_email(Request $request, $id)
    {
        $order = Order::find($id);
        $details = [
            'greeting' => $request->greeting,
            'header' => $request->header,
            'body' => $request->body,
            'button' => $request->button,
            'url' => $request->url,
            'lastline' => $request->lastline,
        ];
        // Lấy thông tin người dùng đang đăng nhập (hoặc bất kỳ người dùng nào bạn muốn liên kết với thông báo)
        $user = User::find($order->user_id);
        $notification = new Notification();
        // Liên kết thông báo với người dùng
        $notification->notifiable()->associate($user);
        $uuid = Str::uuid();
        $notification->id = $uuid;
        $notification->type = "email"; // Loại thông báo, bạn có thể thay đổi nếu cần
        $notification->data = json_encode($details); // Lưu dữ liệu vào trường 'data' dưới dạng JSON
        $notification->read_at = null; // Đánh dấu là chưa đọc (null) hoặc thời gian khi đã đọc (nếu có)


        // Lưu notification vào database
        $notification->save();

        // Sử dụng Notification Facade để gửi thông báo
        FacadeNotification::send($order, new SendEmailNotification($details));

        return redirect()->back();//TODO: hiển thị thông báo đã gửi email
    }

    public function search_data(Request $request)
    {
        $searchQuery = $request->input('search');
        $sortBy = $request->input('sort_by');

        $orders = Order::Where('name', 'LIKE', "%$searchQuery%")->orWhere('email', 'LIKE', "%$searchQuery%")->orWhere('phone', 'LIKE', "%$searchQuery%")->orWhere('product_title', 'LIKE', "%$searchQuery%")->get();
        switch ($sortBy) {
            case 'name_asc':
                // Sắp xếp theo tên (tăng dần)
                $orders = Order::orderBy('name', 'asc')->get();
                break;
            case 'name_desc':
                // Sắp xếp theo tên (giảm dần)
                $orders = Order::orderBy('name', 'desc')->get();
                break;
            case 'price_asc':
                // Sắp xếp theo giá (tăng dần)
                $orders = Order::orderBy('price', 'asc')->get();
                break;
            case 'price_desc':
                // Sắp xếp theo giá (giảm dần)
                $orders = Order::orderBy('price', 'desc')->get();
                break;
            // Xử lý các tùy chọn sắp xếp khác nếu cần
            case 'processing':
                $orders = Order::Where('delivery_status', 'Like', 'Đang Xử Lý')->get();
                break;
            case 'delivered':
                $orders = Order::Where('delivery_status', 'Like', 'Đã Giao Hàng')->get();
                break;
            default:
                // Mặc định không sắp xếp (hoặc xử lý sắp xếp mặc định)
                break;
        }
        return view('admin.order', compact('orders', 'sortBy', 'searchQuery'));
    }

}
