<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Frontend 
Route::get('/', 'HomeController@index');
Route::get('/trang-chu', 'HomeController@index');
Route::get('/404', 'HomeController@error_page');
Route::post('/tim-kiem', 'HomeController@search');

//Danh muc san pham trang chu
Route::get('/danh-muc/{slug_category_product}', 'CategoryProduct@show_category_home');
Route::get('/thuong-hieu/{brand_slug}', 'BrandProduct@show_brand_home');
Route::get('/chi-tiet/{product_slug}', 'ProductController@details_product');

//Backend
Route::get('/admin', 'AdminController@index');
Route::get('/dashboard-admin', 'AdminController@show_dashboard_admin');
Route::get('/dashboard-shop', 'AdminController@show_dashboard_shop');
Route::get('/logout', 'AdminController@logout');
Route::post('/admin-dashboard', 'AdminController@dashboard');
Route::get('/register-shop', 'AdminController@register_shop');
Route::post('/register', 'AdminController@register');


//Category Product
Route::get('/add-category-product', 'CategoryProduct@add_category_product');
Route::get('/edit-category-product/{category_product_id}', 'CategoryProduct@edit_category_product');
Route::get('/delete-category-product/{category_product_id}', 'CategoryProduct@delete_category_product');
Route::get('/all-category-product', 'CategoryProduct@all_category_product');

Route::post('/export-csv-cate', 'CategoryProduct@export_csv_cate');
Route::post('/import-csv-cate', 'CategoryProduct@import_csv_cate');

Route::get('/unactive-category-product/{category_product_id}', 'CategoryProduct@unactive_category_product');
Route::get('/active-category-product/{category_product_id}', 'CategoryProduct@active_category_product');

Route::post('/save-category-product', 'CategoryProduct@save_category_product');
Route::post('/update-category-product/{category_product_id}', 'CategoryProduct@update_category_product');


//Send Mail 
Route::get('/send-mail', 'HomeController@send_mail');


//Login facebook
Route::get('/login-facebook', 'AdminController@login_facebook');
Route::get('/admin/callback', 'AdminController@callback_facebook');


//Brand Product
Route::get('/add-brand-product', 'BrandProduct@add_brand_product');
Route::get('/edit-brand-product/{brand_product_id}', 'BrandProduct@edit_brand_product');
Route::get('/delete-brand-product/{brand_product_id}', 'BrandProduct@delete_brand_product');
Route::get('/all-brand-product', 'BrandProduct@all_brand_product');

Route::get('/unactive-brand-product/{brand_product_id}', 'BrandProduct@unactive_brand_product');
Route::get('/active-brand-product/{brand_product_id}', 'BrandProduct@active_brand_product');

Route::post('/save-brand-product', 'BrandProduct@save_brand_product');
Route::post('/update-brand-product/{brand_product_id}', 'BrandProduct@update_brand_product');

Route::post('/export-csv-brand', 'BrandProduct@export_csv_brand');
Route::post('/import-csv-brand', 'BrandProduct@import_csv_brand');


//Product
Route::get('/add-product', 'ProductController@add_product');
Route::get('/edit-product/{product_id}', 'ProductController@edit_product');
Route::get('/delete-product/{product_id}', 'ProductController@delete_product');
Route::get('/all-product', 'ProductController@all_product');

Route::get('/unactive-product/{product_id}', 'ProductController@unactive_product');
Route::get('/active-product/{product_id}', 'ProductController@active_product');

Route::post('/save-product', 'ProductController@save_product');
Route::post('/update-product/{product_id}', 'ProductController@update_product');

Route::post('/export-csv-product', 'ProductController@export_csv_product');
Route::post('/import-csv-product', 'ProductController@import_csv_product');


//user
Route::get('users-shop', 'UserController@index_shop');
Route::get('users-admin', 'UserController@index_admin');
Route::get('users', 'UserController@index_users');
Route::get('add-admin', 'UserController@add_admin');
Route::post('store-users', 'UserController@store_users');
Route::post('assign-roles', 'UserController@assign_roles');


//Coupon
Route::post('/check-coupon', 'CartController@check_coupon');
Route::get('/unset-coupon', 'CouponController@unset_coupon');
Route::get('/insert-coupon', 'CouponController@insert_coupon');
Route::get('/delete-coupon/{coupon_id}', 'CouponController@delete_coupon');
Route::get('/list-coupon', 'CouponController@list_coupon');
Route::post('/insert-coupon-code', 'CouponController@insert_coupon_code');


//Cart
Route::post('/update-cart-quantity', 'CartController@update_cart_quantity');
Route::post('/update-cart', 'CartController@update_cart');
Route::post('/save-cart', 'CartController@save_cart');
Route::post('/add-cart-ajax', 'CartController@add_cart_ajax');
Route::get('/show-cart', 'CartController@show_cart');
Route::get('/gio-hang', 'CartController@gio_hang');
Route::get('/delete-to-cart/{rowId}', 'CartController@delete_to_cart');
Route::get('/del-product/{session_id}', 'CartController@delete_product');
Route::get('/del-all-product', 'CartController@delete_all_product');

//Checkout
Route::get('/dang-nhap', 'CheckoutController@login_checkout');
Route::get('/del-fee', 'CheckoutController@del_fee');

Route::get('/logout-checkout', 'CheckoutController@logout_checkout');
Route::post('/add-customer', 'CheckoutController@add_customer');
Route::post('/order-place', 'CheckoutController@order_place');
Route::post('/login-customer', 'CheckoutController@login_customer');
Route::get('/checkout', 'CheckoutController@checkout');
Route::get('/payment', 'CheckoutController@payment');
Route::post('/save-checkout-customer', 'CheckoutController@save_checkout_customer');
Route::post('/calculate-fee', 'CheckoutController@calculate_fee');
Route::post('/select-delivery-home', 'CheckoutController@select_delivery_home');
Route::post('/confirm-order', 'CheckoutController@confirm_order');

//Order
Route::get('/delete-order/{order_code}', 'OrderController@order_code');
Route::get('/print-order/{checkout_code}', 'OrderController@print_order');
Route::get('/manage-order', 'OrderController@manage_order');
Route::get('/view-order/{order_code}', 'OrderController@view_order');
Route::post('/update-order-qty', 'OrderController@update_order_qty');
Route::post('/update-qty', 'OrderController@update_qty');


//Delivery
Route::get('/delivery', 'DeliveryController@delivery');
Route::post('/select-delivery', 'DeliveryController@select_delivery');
Route::post('/insert-delivery', 'DeliveryController@insert_delivery');
Route::post('/select-feeship', 'DeliveryController@select_feeship');
Route::post('/update-delivery', 'DeliveryController@update_delivery');

//Banner
Route::get('/manage-slider', 'SliderController@manage_slider');
Route::get('/add-slider', 'SliderController@add_slider');
Route::get('/delete-slide/{slide_id}', 'SliderController@delete_slide');
Route::post('/insert-slider', 'SliderController@insert_slider');
Route::get('/unactive-slide/{slide_id}', 'SliderController@unactive_slide');
Route::get('/active-slide/{slide_id}', 'SliderController@active_slide');



