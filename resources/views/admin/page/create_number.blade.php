@extends('admin.layout.master3')

@section('title')
Cấp số mới
@endsection

@section('page')
Cấp số
@endsection

@section('name-content')
Quản lý cấp số
@endsection

@section('breadcrumb')
<i class="fas fa-angle-right"></i> Danh sách cấp số <i class="fas fa-angle-right"></i> <span style="color: #FF9138">Cấp số mới</span>
@endsection




@section('content')


<div class="row">
    <div style="padding-top: 20px;padding-left:22px;" class="col-lg-12">
        <!-- Content Row -->
        <form id="form-create-number">
            <div style=" padding-right:10px;" class="row pb-2">
                <div style="border-radius: 15px; min-height:520px;" class="col-lg-12 bg-white pb-4 mb-4 shadow">
                    <div class="row pt-4 pl-2 pr-2">
                        <div class="col-lg-12 text-center">
                            <div style="font-weight: bold;color:#FF7506;" class="h2">Cấp số mới</div>
                        </div>

                    </div>
                    <div class="row pt-2 pl-2 pr-2">
                        <div class="col-lg-12 mt-2 text-center">

                            <div style="color:  #535261;font-weight: bold;" class="h6">Dịch vụ khách hàng lựa chọn</div>
                        </div>
                        <div class="col-lg-4 m-auto">
                            <div class="select-box-8">
                                <div class="options-container_8 shadow">
                                    @foreach($services as $row)
                                    <div class="option_8 option-name-services">
                                        <input type="radio" class="radio radio-select-services" value="{{ $row->id }}" id="select-services-is-name-{{ $row->id }}" name="name_select_services" />
                                        <label for="select-services-is-name-{{ $row->id }}">{{ $row->name }}</label>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="selected_8 result-select">
                                    Chọn dịch vụ
                                </div>
                            </div>
                        </div>

                    </div>
                    <div style="padding-top: 80px;" class="row pl-2 pr-2">
                        <div class="col-lg-4 m-auto text-center">
                            <button  onclick="history.back()" style="width:120px;height:45px;margin-right:20px;background:#FFF2E7;border: 1.5px solid #FF9138;color: #FF9138;" type="button" class="btn btn-primary">Hủy bỏ</button>
                            <button style="width:120px;height:45px;background: #FF9138;border:none;" type="submit" class="btn btn-primary">In số</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
<div class="container-wrap-success-give-numbers">
    <div class="container-black-success-give-numbers">

    </div>
    <div class="content-success-give-numbers">
        <span id="turn-off-success-give-number"><i class="fas fa-times"></i></span>
        <div style="width:100%;height:100%;border-radius:20px;overflow:hidden;border: none;">
           <div style="background: white;width:100%;height:70%;padding-top:35px;" class="text-center">
                <div style="font-weight:bold;color:#535261;" class="h4">Số thứ tự được cấp</div>
                <div id="box-number-new-create" style="font-weight:800;color: #FF7506;" class="h1 mt-4"></div>
                <div style="margin-top:40px;color:#282739;" class="h6">DV:<span  id="name-services-of-number"></span> <strong>(Tại quầy số <span id="box-counter-services"></span>)</strong></div>
            </div>
            <div style="background: #FF9138;width:100%;height:30%;padding:20px 20px 10px 40px;"class="text-center" >
                <div style="color: white;font-weight:bold;" class="h5">Thời gian cấp: <span id="box-start-timeout-number"></span></div>
                <div style="color: white;font-weight:bold;"  class="h5">Hạn sử dụng:&#160; <span id="box-end-timeout-number" ></span></div>
            </div>
        </div>
    </div>
</div>

@endsection