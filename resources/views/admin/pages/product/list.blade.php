@extends('admin.layouts.master')
@section('title')
    Danh sách loại sản phẩm
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách loại sản phẩm</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Giá khuyến mãi</th>
                        <th>Loại sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Giá khuyến mãi</th>
                        <th>Loại sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach ($product as $key => $pro)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ $pro->name }}</td>
                            <td>
                              <b>Số lượng:</b>  {{ $pro->quantity }}
                                <br>
                              <b>Giá:</b>  {{ $pro->price }}
                                <br>
                              <b>Khuyến mãi:</b>  {{ $pro->promotional }}
                                <br>
                              <b>Hình:</b> <img src="img/upload/product/{{ $pro->image }}" alt="" width="100" height="100">
                            </td>
                            <td>{{ $pro->productType->name }}</td>
                            {{-- ->category là hàm trong models producttype --}}
                            <td>{{ $pro->Category->name }}</td>
                            <td>
                                @if($pro->status == '1')
                                    {!! "Hiển thị" !!}
                                @else
                                    {!! "Không hiển thị" !!}
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-warning editProduct" data-toggle="modal" data-target="#editProduct"
                                        data-id="{{ $pro->id }}" type="button" title="{{ "Sửa ". $pro->name }}"><i
                                            class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger deleteProduct" data-toggle="modal" data-target="#deleteProduct"
                                        data-id="{{ $pro->id }}" type="button" title="{{ "Xóa ". $pro->name }}"><i
                                            class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pull-right">{{ $product->links() }}</div>
            </div>
        </div>
    </div>

    <!-- Edit Modal-->
    <div class="modal fade" id="editProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa sản phẩm <span id="title"></span></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin: 5px">
                        <div class="col-lg-12">
                            <form role="form">
                                <fieldset class="form-group">
                                    <label>Name</label>
                                    <input class="form-control name" name="name" placeholder="Nhập tên sản phẩm">
                                    <span class="error" style="color: red;font-size: 1rem;"></span>
                                    @if ($errors->has('name'))
                                        <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                </fieldset>
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control idCategory" name="idCategory">
                                        <option value="">Category</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control status" name="status">
                                        <option value="1">Hiển Thị</option>
                                        <option value="0">Không Hiển Thị</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success updateProduct">Lưu thay đổi</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>
    <!-- delete Modal-->
    <div class="modal fade" id="deleteProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc chắn muốn xóa ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="margin-left: 183px;">
                    <button type="button" class="btn btn-success confirmDelProType">Có</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Không</button>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
