@extends('templates.admin')

@section('content')
    <div class="row px-1 mb-4">
        <div class="col-7 col-sm-7 col-md-7 col-lg-7">
            <button type="submit" class="btn btn-sm btn-blue">Xóa những dòng được chọn</button>
        </div>
        <div class="col-2 col-sm-2 col-md-2 col-lg-2">
            <select class="form-select form-select-sm">
                <option selected>Tất cả User</option>
                <option value="1">Admin</option>
                <option value="2">Normal User</option>
            </select>
        </div>
        <div class="col input-group">
            <input id="search-user" type="text" class="form-control form-control-sm" placeholder="Tìm kiếm...">
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
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Avatar</th>
                    <th>Trạng thái</th>
                    <th>Vai trò</th>
                    <th></th>
                </tr>
            </thead>

            <tbody id="table-content">
                @csrf
                @foreach ($all_user as $key => $user)
                    <tr>
                        <td><input type="checkbox" id="check-item" value="{{ $user->user_id }}"><i></i></td>
                        <td>{{ ++$key }}</td>
                        <td>{{ $user->last_name . ' ' . $user->first_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td><img src="images/user/{{ $user->avatar }}" class="rounded-circle img-table"></td>
                        <td>
                            @if (!empty($user->email_verified_at))
                                <i class="fa fa-check text-success" data-bs-toggle="tooltip" title="Email đã xác nhận"></i>
                            @else
                                <i class="fa fa-ban text-danger" data-bs-toggle="tooltip"
                                    title="Email chưa được xác nhận"></i>
                            @endif
                        </td>
                        <td>
                            @if ($user->is_admin == 1)
                                <i class="fas fa-user-cog" data-bs-toggle="tooltip" title="Admin"></i>
                            @else
                                <i class="fas fa-user" data-bs-toggle="tooltip" title="Normal user"></i>
                            @endif
                        </td>
                        <td>
                            <a href="" data-bs-toggle="tooltip" title="Cập nhật user">
                                <i class="fas fa-pencil fa-sm"></i>
                            </a>
                            <a onclick="return confirm('Bạn chắc chắn muốn xóa tài khoản này?')" href="" data-bs-toggle="tooltip" title="Xóa user">
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
            <small>Hiển thị {{ $all_user->count() }} user trong số {{ $all_user->total() }} user.</small>
        </div>
        <div class="col">
            <ul class="pagination pagination-sm justify-content-end">
                {{ $all_user->links() }}
            </ul>
        </div>
    </div>
@endsection
