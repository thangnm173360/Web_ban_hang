<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use App\Slider;
use Illuminate\Support\Facades\Redirect;
use App\Admin;

session_start();

class HomeController extends Controller
{
    public function error_page()
    {
        return view('errors.404');
    }
    public function send_mail()
    {
        //send mail
        $to_name = '';
        $to_email = "luongduyanh1999@gmail.com"; //send to this email


        $data = array("name" => "Mail từ tài khoản Khách hàng", "body" => 'Mail gửi về vấn về mở cửa hàng');

        Mail::send('pages.send_mail', $data, function ($message) use ($to_name, $to_email) {

            $message->to($to_email)->subject('Đăng kí làm người bán');
            $message->from($to_email, $to_name);
        });
        return redirect('/admin')->with('message', 'Bạn đã đăng kí, hãy đợi admin duyệt đơn của bạn');
    }

    public function index(Request $request)
    {
        //slide
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();
        //seo 
        $meta_desc = "Chuyên bán những sản phẩm chính hãng";
        $meta_keywords = "thuong mai dien tu, mua ban";
        $meta_title = "Sàn thương mại điện tử, mua bán sản phẩm chính hãng";
        $url_canonical = $request->url();
        //--seo

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')
            ->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')
            ->orderby('brand_id', 'desc')->get();

        $all_product = DB::table('tbl_product')->where('product_status', '0')
            ->orderby(DB::raw('RAND()'))->paginate(6);

        return view('pages.home')->with('category', $cate_product)
            ->with('brand', $brand_product)->with('all_product', $all_product)
            ->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)
            ->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)
            ->with('slider', $slider); //1

    }
    public function search(Request $request)
    {
        //slide
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();

        //seo 
        $meta_desc = "Tìm kiếm sản phẩm";
        $meta_keywords = "Tìm kiếm sản phẩm";
        $meta_title = "Tìm kiếm sản phẩm";
        $url_canonical = $request->url();
        //--seo
        $keywords = $request->keywords_submit;

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        $search_product = DB::table('tbl_product')->where('product_name', 'like', '%' . $keywords . '%')->get();


        return view('pages.sanpham.search')->with('category', $cate_product)->with('brand', $brand_product)
            ->with('search_product', $search_product)->with('meta_desc', $meta_desc)
            ->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical)->with('slider', $slider);
    }
}
