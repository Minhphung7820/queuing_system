@extends('admin.layout.master3')

@section('title')
Thông tin thiết bị
@endsection

@section('page')
Thiết bị
@endsection

@section('name-content')
Quản lý thiết bị
@endsection

@section('breadcrumb')
<i class="fas fa-angle-right"></i> Danh sách thiết bị <i class="fas fa-angle-right"></i> <span style="color: #FF9138">Chi tiết thiết bị</span>
@endsection




@section('content')


<div class="row">
    <div style="padding-top: 20px;padding-left:22px;" class="col-lg-12">
        <!-- Content Row -->
        <form id="form-create-devices">
            <div style=" padding-right:10px;" class="row pb-2">
                <div style="border-radius: 15px; min-height:520px;" class="col-lg-12 bg-white pb-4 mb-4 shadow">
                    <div class="row pt-4 pl-2 pr-2">
                        <div class="col-lg-12">
                            <div style="font-weight: bold;color:#FF7506;" class="h5">Thông tin thiết bị</div>
                        </div>

                    </div>
                    <div class="row pt-2 pl-2 pr-2">
                        <div class="col-lg-6">
                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <div style="color: #282739;font-weight:bold;" class="h6">Mã thiết bị:</div>
                                </div>
                                <div class="col-lg-9">
                                    {{ $data->code_devices }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <div style="color: #282739;font-weight:bold;" class="h6">Tên thiết bị:</div>
                                </div>
                                <div class="col-lg-9">
                                    {{ $data->name }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <div style="color: #282739;font-weight:bold;" class="h6">Địa chỉ IP:</div>
                                </div>
                                <div class="col-lg-9">
                                    {{ $data->ip_address }}
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="row mb-2">
                                <div class="col-lg-3">
                                <div style="color: #282739;font-weight:bold;" class="h6">Loại thiết bị:</div>
                                </div>
                                <div class="col-lg-9">
                                    {{$data->type->name}}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-3">
                                <div style="color: #282739;font-weight:bold;" class="h6">Tên đăng nhập:</div>
                                </div>
                                <div class="col-lg-9">
                                    {{$data->nameLogin}}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-3">
                                <div style="color: #282739;font-weight:bold;" class="h6">Mật khẩu:</div>
                                </div>
                                <div class="col-lg-9">
                                   {{$data->password}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                        <div style="color: #282739;font-weight:bold;" class="h6">Dịch vụ sử dụng:</div>
                         {{$data->services}}
                        </div>
                    </div>

                </div>

            </div>
        </form>
    </div>
</div>


@endsection