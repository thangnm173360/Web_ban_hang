<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Brand;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportBrand;
use App\Imports\ImportBrand;
use App\Slider;
use App\Http\Requests;
use App\Imports\ExportBrand as ImportsExportBrand;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Redirect;

session_start();
class BrandProduct extends Controller
{
    public function AuthLogin()
    {
        $admin_id = Session()->get('admin_id');
        $roles_id = Session()->get('roles_id');
        if ($admin_id && $roles_id == 1) {
            return Redirect::to('dashboard-admin');
        } else if ($admin_id && $roles_id == 2) {
            return Redirect::to('dashboard-shop');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    public function add_brand_product()
    {
        $this->AuthLogin();
        return view('admin.brand.add_brand_product');
    }

    public function all_brand_product()
    {
        $this->AuthLogin();
        $all_brand_product = Brand::where('shop_id', Session()->get('admin_id'))
            ->orderBy('brand_id', 'DESC')->paginate(4);
        $manager_brand_product  = view('admin.brand.all_brand_product')->with('all_brand_product', $all_brand_product);
        return view('shop_layout')->with('admin.brand.all_brand_product', $manager_brand_product);
    }

    public function save_brand_product(Request $request)
    {
        $this->AuthLogin();
        $data = $request->all();

        $brand = new Brand();
        $brand->brand_name = $data['brand_product_name'];
        $brand->brand_slug = $data['brand_slug'];
        $brand->brand_desc = $data['brand_product_desc'];
        $brand->brand_status = $data['brand_product_status'];
        $brand->shop_id = session()->get('admin_id');
        $brand->save();

        Session()->put('message', 'Thêm thương hiệu sản phẩm thành công');
        return Redirect::to('add-brand-product');
    }

    public function unactive_brand_product($brand_product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_brand')->where('brand_id', $brand_product_id)->update(['brand_status' => 1]);
        Session()->put('message', 'Không kích hoạt thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }

    public function active_brand_product($brand_product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_brand')->where('brand_id', $brand_product_id)->update(['brand_status' => 0]);
        Session()->put('message', 'Kích hoạt thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }

    public function edit_brand_product($brand_product_id)
    {
        $this->AuthLogin();

        // $edit_brand_product = DB::table('tbl_brand')->where('brand_id',$brand_product_id)->get();
        $edit_brand_product = Brand::where('brand_id', $brand_product_id)->get();
        $manager_brand_product  = view('admin.brand.edit_brand_product')->with('edit_brand_product', $edit_brand_product);

        return view('shop_layout')->with('admin.brand.edit_brand_product', $manager_brand_product);
    }

    public function update_brand_product(Request $request, $brand_product_id)
    {
        $this->AuthLogin();
        $data = $request->all();
        $brand = Brand::find($brand_product_id);
        // $brand = new Brand();
        $brand->brand_name = $data['brand_product_name'];
        $brand->brand_slug = $data['brand_product_slug'];
        $brand->brand_desc = $data['brand_product_desc'];
        $brand->brand_status = $data['brand_product_status'];
        $brand->save();
        Session()->put('message', 'Cập nhật thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }

    public function delete_brand_product($brand_product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_brand')->where('brand_id', $brand_product_id)->delete();
        Session()->put('message', 'Xóa thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }

    //End Function Admin Page

    public function show_brand_home(Request $request, $brand_slug)
    {
        //slide
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')
            ->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')
            ->orderby('brand_id', 'desc')->get();


        $brand_by_id = DB::table('tbl_product')->join('tbl_brand', 'tbl_product.brand_id', '=', 'tbl_brand.brand_id')
            ->where('tbl_brand.brand_slug', $brand_slug)->paginate(6);

        $brand_name = DB::table('tbl_brand')->where('tbl_brand.brand_slug', $brand_slug)->limit(1)->get();

        foreach ($brand_name as $key => $val) {
            //seo 
            $meta_desc = $val->brand_desc;
            $meta_keywords = $val->brand_desc;
            $meta_title = $val->brand_name;
            $url_canonical = $request->url();
            //--seo
        }
        return view('pages.brand.show_brand')->with('category', $cate_product)->with('brand', $brand_product)
            ->with('brand_by_id', $brand_by_id)->with('brand_name', $brand_name)->with('meta_desc', $meta_desc)
            ->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)
            ->with('slider', $slider);
    }

    public function export_csv_brand()
    {
        $this->AuthLogin();
        return Excel::download(new ExportBrand, 'brand_product.xlsx');
    }

    public function import_csv_brand(Request $request)
    {
        $this->AuthLogin();
        $path = $request->file('file')->getRealPath();
        Excel::import(new ImportBrand, $path);
        return back();
    }
}
