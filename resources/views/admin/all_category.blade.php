@extends('templates.admin')

@section('content')
<div class="row px-1 mb-4">
        <div class="col-7 col-sm-7 col-md-7 col-lg-7">
            <button type="submit" class="btn btn-sm btn-blue">Xóa những dòng được chọn</button>
        </div>
        <div class="col input-group">
            <input id="search-category" type="text" class="form-control form-control-sm" placeholder="Tìm kiếm...">
            <span>
                <button class="btn btn-sm btn-blue" type="button"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th><input type="checkbox" id="check-all"><i></i></th>
                    <th>STT</th>
                    <th>Tên danh mục</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
            </thead>

            <tbody id="table-content">
                @csrf
                @foreach ($all_category as $key => $category)
                    <tr>
                        <td><input type="checkbox" id="check-item" value="{{ $category->category_id }}"><i></i></td>
                        <td>{{ ++$key }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            @if ($category->status == 1)
                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                            @else
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            @endif
                        </td>
                        <td>
                            <a href="edit-category/{{ $category->id }}" data-bs-toggle="tooltip" title="Cập nhật category">
                                <i class="fas fa-pencil fa-sm"></i>
                            </a>
                            <a onclick="return confirm('Bạn chắc chắn muốn xóa tài khoản này?')" href="" data-bs-toggle="tooltip" title="Xóa category">
                                <i class="fa fa-times fa-lg text-danger"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row mt-2">
        <div class="col-6 col-sm-6 col-md-6 col-lg-6">
            <small>Hiển thị {{ $all_category->count() }} danh mục trong số {{ $all_category->total() }} danh mục.</small>
        </div>
        <div class="col">
            <ul class="pagination pagination-sm justify-content-end">
                {{ $all_category->links() }}
            </ul>
        </div>
    </div>
@endsection
