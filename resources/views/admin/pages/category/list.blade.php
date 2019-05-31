@extends('admin.layouts.master')
@section('title')
    Danh sách danh mục sản phẩm
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>STT</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Hành động</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach ($category as $key => $cat)
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>{{ $cat->name }}</td>
                            <td>{{ $cat->slug }}</td>
                            <td>
                                @if($cat->status == '1')
                                    Hiển thị
                                @else
                                Không hiển thị
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-warning edit" title="{{ "Sửa ". $cat->name }}"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger delete" title="{{ "Xóa ". $cat->name }}"><i class="fas fa trash alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
