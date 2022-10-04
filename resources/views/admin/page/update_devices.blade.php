@extends('admin.layout.master3')

@section('title')
Cập nhật thiết bị
@endsection

@section('page')
Thiết bị
@endsection

@section('name-content')
Quản lý thiết bị
@endsection

@section('breadcrumb')
<i class="fas fa-angle-right"></i> Danh sách thiết bị <i class="fas fa-angle-right"></i> <span style="color: #FF9138">Cập nhật thiết bị</span>
@endsection




@section('content')


<div class="row">
    <div style="padding-top: 20px;padding-left:22px;" class="col-lg-12">
        <!-- Content Row -->
        <form id="form-update-devices">
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
                    <div class="row pt-2 pl-2 pr-2">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <label style="color: #282739;font-weight:bold;" for="exampleInputEmail1">Mã thiết bị <span style="color:#FF4747;">*</span></label>
                                <input type="text" class="form-control" value="{{ $data->code_devices }}" name="codeDevices" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập mã thiết bị">
                                <div id="codeDevices" class="invalid-feedback">

                                </div>
                            </div>
                            <div class="form-group">
                                <label style="color: #282739;font-weight:bold;" for="exampleInputPassword1">Tên thiết bị <span style="color:#FF4747;">*</span></label>
                                <input type="text" name="nameDevices" value="{{ $data->name }}" class="form-control" id="exampleInputPassword1" placeholder="Nhập tên thiết bị" autocomplete="off">
                                <div id="nameDevices" class="invalid-feedback">

                                </div>
                            </div>
                            <div class="form-group">
                                <label style="color: #282739;font-weight:bold;" for="exampleInputPassword1">Địa chỉ IP <span style="color:#FF4747;">*</span></label>
                                <input type="text" class="form-control" value="{{ $data->ip_address }}" name="ipAddress" id="exampleInputPassword1" placeholder="Nhập địa chỉ IP">
                                <div id="ipAddress" class="invalid-feedback">

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label style="color: #282739;font-weight:bold;" for="exampleInputEmail1">Loại thiết bị <span style="color:#FF4747;">*</span></label>
                                <div class="select-box-2">
                                    <div class="options-container_3 shadow">
                                        @foreach($type as $row)
                                        <div class="option_3">
                                            <input type="radio" class="radio" value="{{ $row->id }}" id="name_devices_cate_{{ $row->id }}" name="type" {{ $show = ($data->type_device == $row->id) ? 'checked' : '' }} />
                                            <label for="name_devices_cate_{{ $row->id }}">{{ $row->name }}</label>
                                        </div>
                                        @endforeach
                                        <!-- <div class="option_3">
                                            <input type="radio" class="radio" value="1" id="name_devices_cate_1" name="type" />
                                            <label for="name_devices_cate_1">Tất cả</label>
                                        </div>

                                        <div class="option_3">
                                            <input type="radio" class="radio" value="2" id="name_devices_cate_2" name="type" />
                                            <label for="name_devices_cate_2">Hoạt động</label>
                                        </div> -->
                                    </div>
                                    <div class="selected_3">
                                        {{$data->type->name}}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label style="color: #282739;font-weight:bold;" for="exampleInputEmail1">Tên đăng nhập <span style="color:#FF4747;">*</span></label>
                                <input type="text" class="form-control" value="{{ $data->nameLogin }}" name="name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập tài khoản">
                                <div id="name" class="invalid-feedback">

                                </div>
                            </div>
                            <div class="form-group">
                                <label style="color: #282739;font-weight:bold;" for="exampleInputPassword1">Mật khẩu <span style="color:#FF4747;">*</span></label>
                                <input type="text" class="form-control" value="{{ $data->password }}" name="password" id="exampleInputPassword1" placeholder="Nhập mật khẩu">
                                <div id="password" class="invalid-feedback">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row  pb-4 pl-2 pr-2">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label style="color: #282739;font-weight:bold;" for="exampleInputEmail1">Dịch vụ sử dụng <span style="color:#FF4747;">*</span></label>
                                <input type="text" data-role="tagsinput" value="{{ $data->services }}" name="services" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập dịch vụ sử dụng">
                            </div>
                            <div class="form-group">
                                <label for=""><span style="color:#FF4747;font-weight:bold;">*</span> Là trường thông tin bắt buộc</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 m-auto text-center pt-4 pb-4">
                    <button onclick="history.back()" style="background-color: #FFF2E7;border:2px solid #FF9138;color:#FF9138;margin-right:25px;width:150px;height:40px;" type="button" class="btn btn-primary">Hủy bỏ</button>
                    <button style="background-color:#FF9138 ;color:#FFFFFF;border:none;width:150px;height:40px;" type="submit" class="btn btn-primary btn-update-device">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection