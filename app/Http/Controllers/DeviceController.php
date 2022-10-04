<?php

namespace App\Http\Controllers;

use App\Models\Devices;
use App\Models\Services;
use App\Models\TypeDevices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Models\ActHistory;

class DeviceController extends Controller
{
    public $stt = true;
    // public $BaseCTR;
    // public function __construct()
    // {
    //     $this->BaseCTR = new BaseController();
    // }
    public function index()
    {
        if (isset($_GET['key'])) {
            $key = $_GET['key'];
            $devices = Devices::where('name', "like", '%' . $key . '%')
                ->orWhere('code_devices', 'like', '%' . $key . '%')
                ->orwhere('ip_address', 'like', '%' . $key . '%')
                ->orWhere('services', 'like', '%' . $key . '%')
                ->paginate(9);
            $devices->appends(['key' => $key]);
        } else {
            $devices = Devices::paginate(9);
        }
        return view('admin.page.all_devices', compact('devices'));
    }


    public function create()
    {

        $type = TypeDevices::all();
        return view('admin.page.create_device', compact('type'));
    }


    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'codeDevices' => 'required',
            'nameDevices' => 'required',
            'ipAddress' => 'required',
            'type' => 'required',
            'name' => 'required',
            'password' => 'required',
            'services' => 'required',
        ], [
            'codeDevices.required' => 'Mã thiết bị là bắt buộc !',
            'nameDevices.required' => 'Tên thiết bị là bắt buộc !',
            'ipAddress.required' => 'Địa chỉ IP là bắt buộc !',
            'type.required' => 'Loại thiết bị là bắt buộc !',
            'name.required' => 'Tên đăng nhập là bắt buộc !',
            'password.required' => 'Mật khẩu là bắt buộc !',
            'services.required' => 'Dịch vụ sử dụng là bắt buộc !',
        ]);
        if ($validation->fails()) {
            return response()->json(['status' => 202, 'msg' => $validation->errors()]);
        }
        $arr = explode(',', $request->services);
        $loi = [];
        $servicesArr = [];
        foreach (explode(',', $request->services) as $key => $value) {
            $servicesArr[] = ucfirst(trim($value));
        }
        foreach ($arr as $key => $value) {
            if (Services::where('name', '=', trim(ucfirst($value)))->count() == 0) {
                $loi[] = $value;
                $this->stt = false;
            }
        }
        if ($this->stt == false) {
            return response()->json(['status' => 204, 'msg' => $loi]);
        }
        foreach (Devices::all() as $key => $value) {
            foreach ($servicesArr as $keys => $row) {
                if (in_array($row, explode(',', $value->services))) {
                    return response()->json(['status' => 206, 'msg' =>  'Dịch vụ ' . $row . ' đã được dùng ở thiết bị ' . $value->name . '']);
                }
            }
        }

        $insert =  Devices::create([
            'code_devices' => $request->codeDevices,
            'type_device' => $request->type,
            'name' => trim(strip_tags(ucfirst($request->nameDevices))),
            'slug' => Str::slug($request->nameDevices),
            'ip_address' => $request->ipAddress,
            'services' => implode(',', $servicesArr),
            'nameLogin' => trim($request->name),
            'password' => $request->password,
            'created_at' => now(),
        ])->id;

        foreach ($servicesArr as $key => $value) {
            Services::where('name', '=', $value)->update([
                'device_id' => $insert,
            ]);
        }
        $dataNew = Devices::find($insert);
        $addHistory = ActHistory::create([
            'nameLogin' => auth()->guard('web')->user()->name,
            'Time' => now(),
            'ipAddress' => $request->ip(),
            'action' => 'Thêm mới thiết bị ' . $dataNew->name,
            'created_at' => now(),
            'format_date'=>now()->toDateString(),
        ]);
        if ($insert &&  $addHistory) {
            return response()->json(['status' => 200, 'msg' => 'Đã thêm thiết bị thành công !']);
        }
    }

    public function fiter_by_status(Request $request)
    {
        $output = "";
        if ($request->valueActive == 3 && $request->valueConnect != 3) {
            $data = Devices::where("status_connect", "=", $request->valueConnect)->take(9)->get();
            $count = Devices::where("status_connect", "=", $request->valueConnect)->count();
        } elseif ($request->valueActive != 3 && $request->valueConnect == 3) {
            $data = Devices::where("status_active", "=", $request->valueActive)->take(9)->get();
            $count = Devices::where("status_active", "=", $request->valueActive)->count();
        } elseif ($request->valueActive != 3 && $request->valueConnect != 3) {
            $data = Devices::where("status_active", "=", $request->valueActive)->where("status_connect", "=", $request->valueConnect)->take(9)->get();
            $count = Devices::where("status_active", "=", $request->valueActive)->where("status_connect", "=", $request->valueConnect)->count();
        } elseif ($request->valueActive == 3 && $request->valueConnect == 3) {
            $data = Devices::take(9)->get();
            $count = Devices::count();
        }
        if ($count > 0) {
            foreach ($data as $key => $value) {
                $active = ($value->status_active == 1) ? '<i style="color:#35C75A;" class="fa fa-circle"></i> Hoạt động' : '<i style="color:#EC3740;" class="	fa fa-circle"></i> Ngưng hoạt động';
                $connect = ($value->status_connect == 1) ? ' <i style="color: #35C75A;" class="	fa fa-circle"></i> Kết nối' : '<i style="color: #EC3740;" class="	fa fa-circle"></i> Mất kết nối';
                $services =  $value->services;
                $output .= '            <tr>
                                                <td>' . $value->code_devices . '</td>
                                                <td>' . $value->name . '</td>
                                                <td>' . $value->ip_address . '</td>
                                                <td>' . $active . '</td>
                                                <td>' . $connect . '</td>
                                                <td>' . $services  . ' <br><a href="" class="modal-show-more-services" data-toggle="modal" data-target="#modal-show-more-services' . $value->id . '">Xem thêm</a>
                                                <div class="modal fade" id="modal-show-more-services' . $value->id . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Các dịch vụ sử dụng</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                           ' . $services . '
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" style="background-color: #FF9138;" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                </td>
                                                <td><a href="/admin/devices/show/' . $value->id . '">Chi tiết</a></td>
                                                <td><a href="/admin/devices/edit/' . $value->id . '">Cập nhật</a></td>
                                        </tr>';
            }
            $id = $value->id;
            if ($count > 9) {
                $output .= '             <tr class="tr-view-more-devices-filter">
                                                <td class="text-center" colspan="8"><button data-id="' . $id . '" data-active="' . $request->valueActive . '" data-connect="' . $request->valueConnect . '" style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-devices-filter">Xem thêm...</button></td>
                                         </tr>';
            }
        } else {
            $output .= '             <tr class="tr-view-more-devices-filter">
            <td class="text-center" colspan="8">Không tìm thấy kết quả nào ! </td>
     </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }

    public function load_more_devices_filter(Request $request)
    {
        $output = '';
        if ($request->active && !$request->connect) {
            if ($request->active != 3) {
                $data = Devices::where("id", ">", $request->id)->where("status_active", "=", $request->active)->take(9)->get();
                $count = Devices::where("id", ">", $request->id)->where("status_active", "=", $request->active)->count();
            } elseif ($request->active == 3) {
                $data = Devices::where("id", ">", $request->id)->take(9)->get();
                $count = Devices::where("id", ">", $request->id)->count();
            }
        } elseif (!$request->active && $request->connect) {
            if ($request->connect != 3) {
                $data = Devices::where("id", ">", $request->id)->where("status_connect", "=", $request->connect)->take(9)->get();
                $count = Devices::where("id", ">", $request->id)->where("status_connect", "=", $request->connect)->count();
            } elseif ($request->connect == 3) {
                $data = Devices::where("id", ">", $request->id)->take(9)->get();
                $count = Devices::where("id", ">", $request->id)->count();
            }
        } elseif ($request->active && $request->connect) {
            if ($request->active == 3 && $request->connect != 3) {
                $data = Devices::where("id", ">", $request->id)->where("status_connect", "=", $request->connect)->take(9)->get();
                $count = Devices::where("id", ">", $request->id)->where("status_connect", "=", $request->connect)->count();
            } elseif ($request->active != 3 && $request->connect == 3) {
                $data = Devices::where("id", ">", $request->id)->where("status_active", "=", $request->active)->take(9)->get();
                $count = Devices::where("id", ">", $request->id)->where("status_active", "=", $request->active)->count();
            } elseif ($request->active != 3 && $request->connect != 3) {
                $data = Devices::where("id", ">", $request->id)->where("status_active", "=", $request->active)->where("status_connect", "=", $request->connect)->take(9)->get();
                $count = Devices::where("id", ">", $request->id)->where("status_active", "=", $request->active)->where("status_connect", "=", $request->connect)->count();
            } elseif ($request->active == 3 && $request->connect == 3) {
                $data = Devices::where("id", ">", $request->id)->take(9)->get();
                $count = Devices::where("id", ">", $request->id)->count();
            }
        }

        foreach ($data as $key => $value) {
            $active = ($value->status_active == 1) ? '<i style="color:#35C75A;" class="fa fa-circle"></i> Hoạt động' : '<i style="color:#EC3740;" class="	fa fa-circle"></i> Ngưng hoạt động';
            $connect = ($value->status_connect == 1) ? ' <i style="color: #35C75A;" class="	fa fa-circle"></i> Kết nối' : '<i style="color: #EC3740;" class="	fa fa-circle"></i> Mất kết nối';
            $services =  $value->services;
            $output .= '            <tr>
                                            <td>' . $value->code_devices . '</td>
                                            <td>' . $value->name . '</td>
                                            <td>' . $value->ip_address . '</td>
                                            <td>' . $active . '</td>
                                            <td>' . $connect . '</td>
                                            <td>' . $services  . '<br><a href="" class="modal-show-more-services" data-toggle="modal" data-target="#modal-show-more-services' . $value->id . '">Xem thêm</a>
                                            <div class="modal fade" id="modal-show-more-services' . $value->id . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Các dịch vụ sử dụng</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                       ' . $value->services . '
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" style="background-color: #FF9138;" class="btn btn-secondary" data-dismiss="modal">Đóng</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            </td>
                                            <td><a href="/admin/devices/show/' . $value->id . '">Chi tiết</a></td>
                                            <td><a href="/admin/devices/edit/' . $value->id . '">Cập nhật</a></td>
                                    </tr>';
        }
        $id = $value->id;
        if ($count > 9) {
            $output .= '             <tr  class="tr-view-more-devices-filter">
                                            <td class="text-center" colspan="8"><button data-id="' . $id . '" data-active="' . $request->active . '" data-connect="' . $request->connect . '" style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-devices-filter">Xem thêm...</button></td>
                                     </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }

    public function keyup(Request $request)
    {
        $output = '';
        $data = Devices::where('name', "like", '%' . $request->key . '%')
            ->orWhere('code_devices', 'like', '%' . $request->key . '%')
            ->orwhere('ip_address', 'like', '%' . $request->key . '%')
            ->orWhere('services', 'like', '%' . $request->key . '%')
            ->get();
        if (count($data) > 0) {

            foreach ($data as $key => $value) {
                $active = ($value->status_active == 1) ? '<i style="color:#35C75A;" class="fa fa-circle"></i> Hoạt động' : '<i style="color:#EC3740;" class="	fa fa-circle"></i> Ngưng hoạt động';
                $connect = ($value->status_connect == 1) ? ' <i style="color: #35C75A;" class="	fa fa-circle"></i> Kết nối' : '<i style="color: #EC3740;" class="	fa fa-circle"></i> Mất kết nối';
                $services =  $value->services;
                $output .= '            <tr>
                                                <td>' . $value->code_devices . '</td>
                                                <td>' . $value->name . '</td>
                                                <td>' . $value->ip_address . '</td>
                                                <td>' . $active . '</td>
                                                <td>' . $connect . '</td>
                                                <td>' . $services  . '<br><a href="" class="modal-show-more-services" data-toggle="modal" data-target="#modal-show-more-services' . $value->id . '">Xem thêm</a>
                                                <div class="modal fade" id="modal-show-more-services' . $value->id . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Các dịch vụ sử dụng</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                           ' . $value->services . '
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" style="background-color: #FF9138;" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                </td>
                                                <td><a href="/admin/devices/show/' . $value->id . '">Chi tiết</a></td>
                                                <td><a href="/admin/devices/edit/' . $value->id . '">Cập nhật</a></td>
                                        </tr>';
            }
        } else {
            $output .= '             <tr>
                  <td class="text-center" colspan="8">Không tìm thấy kết quả !</td>
                 </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }

    public function show($id = null)
    {
        if (!$id) {
            return abort(404);
        }
        $data = Devices::findOrFail($id);
        return view("admin.page.detail_devices", compact('data'));
    }


    public function edit($id = null)
    {
        if (!$id) {
            return abort(404);
        }
        $type = TypeDevices::all();
        $data = Devices::findOrFail($id);
        return view('admin.page.update_devices', compact('type', 'data'));
    }


    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'codeDevices' => 'required',
            'nameDevices' => 'required',
            'ipAddress' => 'required',
            'type' => 'required',
            'name' => 'required',
            'password' => 'required',
            'services' => 'required',
        ], [
            'codeDevices.required' => 'Mã thiết bị là bắt buộc !',
            'nameDevices.required' => 'Tên thiết bị là bắt buộc !',
            'ipAddress.required' => 'Địa chỉ IP là bắt buộc !',
            'type.required' => 'Loại thiết bị là bắt buộc !',
            'name.required' => 'Tên đăng nhập là bắt buộc !',
            'password.required' => 'Mật khẩu là bắt buộc !',
            'services.required' => 'Dịch vụ sử dụng là bắt buộc !',
        ]);
        if ($validation->fails()) {
            return response()->json(['status' => 202, 'msg' => $validation->errors()]);
        }
        $arr = explode(',', $request->services);
        $loi = [];
        $arrId = [];
        $servicesArr = [];
        foreach (explode(',', $request->services) as $key => $value) {
            $servicesArr[] = ucfirst(trim($value));
        }
        foreach (Devices::where("id", "!=", $request->id)->get() as $key => $value) {
            foreach ($servicesArr as $keys => $row) {
                if (in_array($row, explode(',', $value->services))) {
                    return response()->json(['status' => 206, 'msg' =>  'Dịch vụ ' . $row . ' đã được dùng ở thiết bị ' . $value->name . '']);
                }
            }
        }
        foreach ($arr as $key => $value) {
            if (Services::where('name', '=', trim(ucfirst($value)))->count() == 0) {
                $loi[] = $value;
                $this->stt = false;
            } else {
                $data = Services::where('name', '=', trim(ucfirst($value)))->first();
                $arrId[] = $data->id;
            }
        }
        if ($this->stt == false) {
            return response()->json(['status' => 204, 'msg' => $loi]);
        }
        $update =  Devices::where('id', '=', $request->id)->update([
            'code_devices' => $request->codeDevices,
            'type_device' => $request->type,
            'name' => trim(strip_tags(ucfirst($request->nameDevices))),
            'slug' => Str::slug($request->nameDevices),
            'ip_address' => $request->ipAddress,
            'services' => implode(',', $servicesArr),
            'nameLogin' => trim($request->name),
            'password' => $request->password,
            'updated_at' => now(),
        ]);
        foreach ($servicesArr as $key => $value) {
            Services::where('name', '=', $value)->update([
                'device_id' => $request->id,
            ]);
        }
        $addHistory = ActHistory::create([
            'nameLogin' => auth()->guard('web')->user()->name,
            'Time' => now(),
            'ipAddress' => $request->ip(),
            'action' => 'Cập nhật thông tin thiết bị ' . trim(strip_tags(ucfirst($request->nameDevices))),
            'format_date'=>now()->toDateString(),
            'created_at' => now()
        ]);
        if ($update && $addHistory) {
            return response()->json(['status' => 200, 'msg' => 'Đã cập nhật thiết bị thành công !']);
        }
    }


    public function destroy($id)
    {
        //
    }
}
