@extends('admin.layout.master3')

@section('title')
Thêm tài khoản
@endsection

@section('page')
Cài đặt hệ thống
@endsection

@section('name-content')
Quản lý tài khoản
@endsection

@section('breadcrumb')
<i class="fas fa-angle-right"></i> Quản lý tài khoản <i class="fas fa-angle-right"></i> <span style="color: #FF9138">Thêm tài khoản</span>
@endsection




@section('content')


<div class="row">
    <div style="padding-top: 20px;padding-left:22px;" class="col-lg-12">
        <!-- Content Row -->
        <form id="form-add-user">
            <div style=" padding-right:10px;" class="row pb-2">
                <div style="border-radius: 15px;" class="col-lg-12 bg-white shadow">
                    <div class="row pt-4 pl-2 pr-2">
                        <div class="col-lg-12">
                            <div style="font-weight: bold;color:#FF7506;" class="h5">Thông tin tài khoản</div>
                            <div class="alert alert-success" role="alert">
                                This is a success alert—check it out!
                            </div>
                            <div class="alert alert-danger" role="alert">
                                This is a danger alert—check it out!
                            </div>
                        </div>

                    </div>
                    <div class="row pt-2 pl-2 pr-2">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label style="color: #282739;font-weight:bold;" for="exampleInputEmail1">Họ tên <span style="color:#FF4747;">*</span></label>
                                <input type="text" class="form-control" name="fullname" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập họ tên">
                                <div id="fullname" class="invalid-feedback">

                                </div>
                            </div>
                            <div class="form-group">
                                <label style="color: #282739;font-weight:bold;" for="exampleInputPassword1">Số điện thoại <span style="color:#FF4747;">*</span></label>
                                <input type="text" name="phone" class="form-control" id="exampleInputPassword1" placeholder="Nhập tên số điện thoại" autocomplete="off">
                                <div id="phone" class="invalid-feedback">

                                </div>
                            </div>
                            <div class="form-group">
                                <label style="color: #282739;font-weight:bold;" for="exampleInputPassword1">Email <span style="color:#FF4747;">*</span></label>
                                <input type="text" class="form-control" name="email" id="exampleInputPassword1" placeholder="Nhập Email">
                                <div id="email" class="invalid-feedback">

                                </div>
                            </div>
                            <div class="form-group">
                                <label style="color: #282739;font-weight:bold;" for="exampleInputEmail1">Vai trò <span style="color:#FF4747;">*</span></label>
                                <div class="select-box-10">
                                    <div class="options-container_10 shadow">
                                      @foreach($roles as $row)

                                      <div class="option_10">
                                            <input type="radio" class="radio" value="{{ $row->id }}" id="input_checkbox_role_create_users_{{ $row->id }}" name="role" />
                                            <label for="input_checkbox_role_create_users_{{ $row->id }}">{{ $row->nameRole }}</label>
                                        </div>
                                      @endforeach
                                    </div>
                                    <div class="selected_10">
                                        Chọn vai trò
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label style="color: #282739;font-weight:bold;" for="exampleInputEmail1">Tên đăng nhập <span style="color:#FF4747;">*</span></label>
                                <input type="text" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập tên đăng nhập">
                                <div id="name" class="invalid-feedback">

                                </div>
                            </div>
                            <div class="form-group">
                                <label style="color: #282739;font-weight:bold;" for="exampleInputPassword1">Mật khẩu <span style="color:#FF4747;">*</span></label>
                                <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Nhập mật khẩu">
                                <div id="password" class="invalid-feedback">

                                </div>
                            </div>
                            <div class="form-group">
                                <label style="color: #282739;font-weight:bold;" for="exampleInputPassword1">Nhập lại mật khẩu <span style="color:#FF4747;">*</span></label>
                                <input type="password" class="form-control" name="confirm_password" id="exampleInputPassword1" placeholder="Nhập lại mật khẩu">
                                <div id="confirm_password" class="invalid-feedback">

                                </div>
                            </div>
                            <div class="form-group">
                                <label style="color: #282739;font-weight:bold;" for="exampleInputEmail1">Tình trạng <span style="color:#FF4747;">*</span></label>
                                <div class="select-box-11">
                                    <div class="options-container_11 shadow">

                                        <div class="option_11">
                                            <input type="radio" class="radio" value="1" id="input_set_status_active_create_user" name="status" />
                                            <label for="input_set_status_active_create_user">Hoạt động</label>
                                        </div>
                                        <div class="option_11">
                                            <input type="radio" class="radio" value="2" id="input_set_status_inactive_create_user" name="status" />
                                            <label for="input_set_status_inactive_create_user">Ngưng hoạt động</label>
                                        </div>


                                    </div>
                                    <div class="selected_11">
                                        Chọn trạng thái
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row  pb-4 pl-2 pr-2">
                        <div class="col-lg-12">

                            <div class="form-group">
                                <label for=""><span style="color:#FF4747;font-weight:bold;">*</span> Là trường thông tin bắt buộc</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 m-auto text-center pt-4 pb-4">
                    <button onclick="history.back()" style="background-color: #FFF2E7;border:2px solid #FF9138;color:#FF9138;margin-right:25px;width:150px;height:40px;" type="button" class="btn btn-primary">Hủy bỏ</button>
                    <button style="background-color:#FF9138 ;color:#FFFFFF;border:none;width:150px;height:40px;" type="submit" class="btn btn-primary btn-add-user">Thêm</button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection