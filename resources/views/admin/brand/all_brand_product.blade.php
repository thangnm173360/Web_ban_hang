@extends('shop_layout')
@section('shop_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê thương hiệu sản phẩm
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <?php
      $message = Session()->get('message');
      if ($message) {
        echo '<span class="text-alert">' . $message . '</span>';
        Session()->put('message', null);
      }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            
            <th>Tên thương hiệu</th>
            <th>Brand Slug</th>
            <th>Hiển thị</th>

            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_brand_product as $key => $brand_pro)
          <tr>
            
            <td>{{ $brand_pro->brand_name }}</td>
            <td>{{ $brand_pro->brand_slug }}</td>
            <td><span class="text-ellipsis">
                <?php
                if ($brand_pro->brand_status == 0) {
                ?>
                  <a href="{{URL::to('/unactive-brand-product/'.$brand_pro->brand_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up"></span></a>
                <?php
                } else {
                ?>
                  <a href="{{URL::to('/active-brand-product/'.$brand_pro->brand_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down"></span></a>
                <?php
                }
                ?>
              </span></td>

            <td>
              <a href="{{URL::to('/edit-brand-product/'.$brand_pro->brand_id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i></a>
              <a onclick="return confirm('Bạn có chắc là muốn xóa thương hiệu này ko?')" href="{{URL::to('/delete-brand-product/'.$brand_pro->brand_id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <form action="{{url('import-csv-brand')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="file" name="file" accept=".xlsx"><br>

        <input type="submit" value="Import file Excel" name="import_csv" class="btn btn-warning">
      </form>

      <!-----export data---->
      <form action="{{url('export-csv-brand')}}" method="POST">
        @csrf
        <input type="submit" value="Export file Excel" name="export_csv" class="btn btn-success">
      </form>
    </div>
    <footer class="panel-footer">
      <div class="row">

        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">
          <ul class="pagination pagination-sm m-t-none m-b-none">
            {!!$all_brand_product->links()!!}
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection