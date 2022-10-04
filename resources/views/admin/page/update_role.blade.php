@extends('admin.layout.master3')

@section('title')
Cập nhật vai trò
@endsection

@section('page')
Cài đặt hệ thống
@endsection

@section('name-content')
Danh sách vai trò
@endsection

@section('breadcrumb')
<i class="fas fa-angle-right"></i> Quản lý vai trò <i class="fas fa-angle-right"></i> <span style="color: #FF9138">Cập nhật vai trò</span>
@endsection




@section('content')
<?php
$arr = [];

foreach ($data->func as $key => $value) {
    $arr[] = $value->id;
}

?>

<div class="row">
    <div style="padding-top: 20px;padding-left:22px;" class="col-lg-12">
        <!-- Content Row -->
        <form id="form-update-role">
            <div style=" padding-right:10px;" class="row pb-2">
                <div style="border-radius: 15px;" class="col-lg-12 bg-white shadow">
                    <div class="row pt-4 pl-2 pr-2">
                        <div class="col-lg-12">
                            <div style="font-weight: bold;color:#FF7506;" class="h5">Thông tin thiết bị</div>
                            <div class="alert alert-success" role="alert">
                                This is a success alert—check it out!
                            </div>
                            <div class="alert alert-danger" role="alert">
                                This is a danger alert—check it out!
                            </div>
                        </div>

                    </div>
                    <div style="padding-right:20px;" class="row pt-2 pl-2">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label style="color: #282739;font-weight:bold;" for="exampleInputEmail1">Tên vai trò <span style="color:#FF4747;">*</span></label>
                                <input type="text" class="form-control" value="{{ $data->nameRole }}" name="nameRole" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập tên vai trò">
                                <div id="nameRole" class="invalid-feedback">

                                </div>
                            </div>
                            <div class="form-group">
                                <label style="color: #282739;font-weight:bold;" for="exampleInputPassword1">Mô tả:</label>
                                <textarea style="resize:none ;height:150px;" name="der" class="form-control" id="exampleFormControlTextarea1" placeholder="Nhập mô tả" rows="3">{{ $data->der }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for=""><span style="color:#FF4747;font-weight:bold;">*</span> Là trường thông tin bắt buộc</label>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label style="color: #282739;font-weight:bold;" for="exampleInputEmail1">Phân quyền chức năng <span style="color:#FF4747;">*</span></label>
                                <div class="row">
                                    <div class="col-lg-12 box-create-role-function-of-users">
                                        <div style="font-weight: bold;color:#FF7506;" class="h5">Nhóm chức năng quản lý thiết bị</div>
                                        <div class="custom-control custom-checkbox input-checkbox-function-role">
                                            <input type="hidden" name="id" value="{{ $data->id }}">
                                            <input type="checkbox" name="" value="auto" class="custom-control-input input-update-check-all-func-devices" id="customCheck1">
                                            <label style="color: #535261;" class="custom-control-label" for="customCheck1">Tất cả</label>
                                        </div>
                                        <div class="custom-control custom-checkbox input-checkbox-function-role">
                                            <input type="checkbox" name="function[]" value="1" class="custom-control-input input-update-each-func-devices" id="customCheck2" {{$show=(in_array(1,$arr)) ? 'checked' : ''}}>
                                            <label style="color: #535261;" class="custom-control-label" for="customCheck2">Thêm mới</label>
                                        </div>
                                        <div class="custom-control custom-checkbox input-checkbox-function-role">
                                            <input type="checkbox" name="function[]" value="2" class="custom-control-input input-update-each-func-devices" id="customCheck3" {{$show=(in_array(2,$arr)) ? 'checked' : ''}}>
                                            <label style="color:#535261;" class="custom-control-label" for="customCheck3">Cập nhật</label>
                                        </div>
                                        <div class="custom-control custom-checkbox input-checkbox-function-role mb-4">
                                            <input type="checkbox" name="function[]" value="3" class="custom-control-input input-update-each-func-devices" id="customCheck4" {{$show=(in_array(3,$arr)) ? 'checked' : ''}}>
                                            <label style="color:#535261;" class="custom-control-label" for="customCheck4">Xem chi tiết</label>
                                        </div>

                                        <div style="font-weight: bold;color:#FF7506;" class="h5">Nhóm chức năng quản lý dịch vụ</div>
                                        <div class="custom-control custom-checkbox input-checkbox-function-role">
                                            <input type="checkbox" name="" value="auto" class="custom-control-input  input-update-check-all-func-services" id="customCheck5">
                                            <label style="color: #535261;" class="custom-control-label" for="customCheck5">Tất cả</label>
                                        </div>
                                        <div class="custom-control custom-checkbox input-checkbox-function-role">
                                            <input type="checkbox" name="function[]" value="4" class="custom-control-input input-update-each-func-services" id="customCheck6" {{$show=(in_array(4,$arr)) ? 'checked' : ''}}>
                                            <label style="color: #535261;" class="custom-control-label" for="customCheck6">Thêm mới</label>
                                        </div>
                                        <div class="custom-control custom-checkbox input-checkbox-function-role">
                                            <input type="checkbox" name="function[]" value="5" class="custom-control-input input-update-each-func-services" id="customCheck7" {{$show=(in_array(5,$arr)) ? 'checked' : ''}}>
                                            <label style="color: #535261;" class="custom-control-label" for="customCheck7">Cập nhật</label>
                                        </div>
                                        <div class="custom-control custom-checkbox input-checkbox-function-role mb-4">
                                            <input type="checkbox" name="function[]" value="6" class="custom-control-input input-update-each-func-services" id="customCheck8" {{$show=(in_array(6,$arr)) ? 'checked' : ''}}>
                                            <label style="color: #535261;" class="custom-control-label" for="customCheck8">Xem chi tiết</label>
                                        </div>

                                        <div style="font-weight: bold;color:#FF7506;" class="h5">Nhóm chức năng quản lý cấp số</div>
                                        <div class="custom-control custom-checkbox input-checkbox-function-role">
                                            <input type="checkbox" name="" value="auto" class="custom-control-input input-update-check-all-func-numbers" id="customCheck9">
                                            <label style="color: #535261;" class="custom-control-label" for="customCheck9">Tất cả</label>
                                        </div>
                                        <div class="custom-control custom-checkbox input-checkbox-function-role">
                                            <input type="checkbox" name="function[]" value="7" class="custom-control-input input-update-each-func-numbers" id="customCheck10" {{$show=(in_array(7,$arr)) ? 'checked' : ''}}>
                                            <label style="color: #535261;" class="custom-control-label" for="customCheck10">Cấp số mới</label>
                                        </div>
                                        <div class="custom-control custom-checkbox input-checkbox-function-role">
                                            <input type="checkbox" name="function[]" value="8" class="custom-control-input input-update-each-func-numbers" id="customCheck11" {{$show=(in_array(8,$arr)) ? 'checked' : ''}}>
                                            <label style="color: #535261;" class="custom-control-label" for="customCheck11">Xem chi tiết</label>
                                        </div>
                                        <div class="custom-control custom-checkbox input-checkbox-function-role mb-4">
                                            <input type="checkbox" name="function[]" value="9" class="custom-control-input input-update-each-func-numbers" id="customCheck12" {{$show=(in_array(9,$arr)) ? 'checked' : ''}}>
                                            <label style="color: #535261;" class="custom-control-label" for="customCheck12">Lọc dữ liệu</label>
                                        </div>

                                        <div style="font-weight: bold;color:#FF7506;" class="h5">Nhóm chức năng quản lý tài khoản</div>
                                        <div class="custom-control custom-checkbox input-checkbox-function-role">
                                            <input type="checkbox" name="" value="auto" class="custom-control-input input-update-check-all-func-users" id="customCheck13">
                                            <label style="color:#535261;" class="custom-control-label" for="customCheck13">Tất cả</label>
                                        </div>
                                        <div class="custom-control custom-checkbox input-checkbox-function-role">
                                            <input type="checkbox" name="function[]" value="10" class="custom-control-input input-update-each-func-users" id="customCheck14" {{$show=(in_array(10,$arr)) ? 'checked' : ''}}>
                                            <label style="color: #535261;" class="custom-control-label" for="customCheck14">Thêm tài khoản</label>
                                        </div>
                                        <div class="custom-control custom-checkbox input-checkbox-function-role  mb-4">
                                            <input type="checkbox" name="function[]" value="11" class="custom-control-input input-update-each-func-users" id="customCheck15" {{$show=(in_array(11,$arr)) ? 'checked' : ''}}>
                                            <label style="color: #535261;" class="custom-control-label" for="customCheck15">Cập nhật</label>
                                        </div>
                                        <div style="font-weight: bold;color:#FF7506;" class="h5">Nhóm chức năng quản lý vai trò</div>
                                        <div class="custom-control custom-checkbox input-checkbox-function-role">
                                            <input type="checkbox" name="" value="auto" class="custom-control-input input-update-check-all-func-role" id="customCheck17">
                                            <label style="color:#535261;" class="custom-control-label" for="customCheck17">Tất cả</label>
                                        </div>
                                        <div class="custom-control custom-checkbox input-checkbox-function-role">
                                            <input type="checkbox" name="function[]" value="12" class="custom-control-input input-update-each-func-role" id="customCheck18" {{$show=(in_array(12,$arr)) ? 'checked' : ''}}>
                                            <label style="color: #535261;" class="custom-control-label" for="customCheck18">Thêm vai trò</label>
                                        </div>
                                        <div class="custom-control custom-checkbox input-checkbox-function-role  mb-4">
                                            <input type="checkbox" name="function[]" value="13" class="custom-control-input input-update-each-func-role" id="customCheck19" {{$show=(in_array(13,$arr)) ? 'checked' : ''}}>
                                            <label style="color: #535261;" class="custom-control-label" for="customCheck19">Cập nhật vai trò</label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>


                </div>
                <div class="col-lg-6 m-auto text-center pt-4 pb-4">
                    <button onclick="history.back()" style="background-color: #FFF2E7;border:2px solid #FF9138;color:#FF9138;margin-right:25px;width:150px;height:40px;" type="button" class="btn btn-primary">Hủy bỏ</button>
                    <button style="background-color:#FF9138 ;color:#FFFFFF;border:none;width:150px;height:40px;" type="submit" class="btn btn-primary btn-update-role">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection