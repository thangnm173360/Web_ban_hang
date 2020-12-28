@extends('layout')
@section('content')
<div class="features_items">
    <!--features_items-->
    <h2 class="title text-center">Kết quả tìm kiếm</h2>
    @foreach($search_product as $key => $product)
    <div class="col-sm-4">
        <div class="product-image-wrapper">
            <a href="{{URL::to('/chi-tiet/'.$product->product_slug)}}">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                        <h2>{{number_format($product->product_price).' '.'VNĐ'}}</h2>
                        <p>{{$product->product_name}}</p>
                    </div>
                </div>
            </a>
            <form action="{{URL::to('/save-cart')}}" method="POST">
                @csrf
                <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                <input type="hidden" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                <input type="hidden" value="{{$product->product_quantity}}" class="cart_product_quantity_{{$product->product_id}}">
                <input type="hidden" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                <input name="productid_hidden" type="hidden" value="{{$product->product_id}}" />
                <input name="qty" type="hidden" min="1" class="cart_product_qty_{{$product->product_id}}" value="1" />
                <input style="margin-left:25%" type="button" value="Thêm giỏ hàng" class="btn btn-primary btn-sm add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart">
            </form>
            <div class="choose">
                <ul class="nav nav-pills nav-justified">
                    <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
                    <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                </ul>
            </div>
        </div>
    </div>
    @endforeach
</div>
<!--features_items-->
<!--/recommended_items-->
@endsection