<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\Models\ActHistory;
use Carbon\Carbon;

class ManageUsersController extends Controller
{
    public $base;
    public function __construct()
    {
        $this->base = new BaseController();
    }
    public function history()
    {
        $arr = [];
        $all = ActHistory::orderBy('created_at', 'desc')->paginate(10);
        $totalData = ActHistory::all();
        foreach ($totalData as $key => $value) {
            $arr[] = Carbon::parse($value->created_at)->toDateString();
        }
        $dateLimit = count($arr) > 0 ? min($arr) : '00';
        return view('admin.page.history', compact('all', 'dateLimit'));
    }
    public function keyupHistory(Request $request)
    {
        $output = '';
        $key = $request->key;
        $data = ActHistory::where(function ($query) use ($key) {
            $query->where('nameLogin', 'like', '%' . $key . '%');
            $query->orWhere('Time', 'like', '%' . $key . '%');
            $query->orWhere('ipAddress', 'like', '%' . $key . '%');
            $query->orWhere('action', 'like', '%' . $key . '%');
        })->orderBy('created_at', 'desc')->take(10)->get();
        $count = ActHistory::where(function ($query) use ($key) {
            $query->where('nameLogin', 'like', '%' . $key . '%');
            $query->orWhere('Time', 'like', '%' . $key . '%');
            $query->orWhere('ipAddress', 'like', '%' . $key . '%');
            $query->orWhere('action', 'like', '%' . $key . '%');
        })->count();
        if ($count > 0) {
            foreach ($data as $key => $value) {
                $output .= '      <tr>
                                    <td>' . $value->nameLogin . '</td>
                                    <td>' . Carbon::parse($value->Time)->format('d/m/y h:i:s') . '</td>
                                    <td>' . $value->ipAddress . '</td>
                                    <td>' . $value->action . '</td>
                             </tr>';
            }
            $id = $value->id;
            if ($count > 10) {
                $output .= '   <tr class="tr-view-more-diary">
                              <td class="text-center" colspan="4"><button onclick="viewMoreKeyupDiary(this)" data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-diary-keyup">Xem thêm...</button></td>
                       </tr>';
            }
        } else {
            $output .= '   <tr>
                           <td class="text-center" colspan="4">Không có dòng nào !</td>
                     </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }
    public function viewMoreHistoryKeyup(Request $request)
    {
        $output = '';
        $key = $request->key;
        $data = ActHistory::where('id', ">", $request->id)->where(function ($query) use ($key) {
            $query->where('nameLogin', 'like', '%' . $key . '%');
            $query->orWhere('Time', 'like', '%' . $key . '%');
            $query->orWhere('ipAddress', 'like', '%' . $key . '%');
            $query->orWhere('action', 'like', '%' . $key . '%');
        })->orderBy('created_at', 'desc')->take(10)->get();
        $count = ActHistory::where('id', ">", $request->id)->where(function ($query) use ($key) {
            $query->where('nameLogin', 'like', '%' . $key . '%');
            $query->orWhere('Time', 'like', '%' . $key . '%');
            $query->orWhere('ipAddress', 'like', '%' . $key . '%');
            $query->orWhere('action', 'like', '%' . $key . '%');
        })->count();
        if ($count > 0) {
            foreach ($data as $key => $value) {
                $output .= '      <tr>
                                    <td>' . $value->nameLogin . '</td>
                                    <td>' . Carbon::parse($value->Time)->format('d/m/y h:i:s') . '</td>
                                    <td>' . $value->ipAddress . '</td>
                                    <td>' . $value->action . '</td>
                             </tr>';
            }
            $id = $value->id;
            if ($count > 10) {
                $output .= '   <tr class="tr-view-more-diary">
                              <td class="text-center" colspan="4"><button onclick="viewMoreKeyupDiary(this)" data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-diary-keyup">Xem thêm...</button></td>
                       </tr>';
            }
        } else {
            $output .= '   <tr>
                           <td class="text-center" colspan="4">Không có dòng nào !</td>
                     </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }
    public function filterHistory(Request $request)
    {
        $output = '';
        $begin = $request->begin;
        $end = $request->end;
        $data = ActHistory::where(function ($query) use ($begin, $end) {
            $query->where('format_date', '>=', $begin);
            $query->where('format_date', '<=', $end);
        })->take(10)->get();
        $count = ActHistory::where(function ($query) use ($begin, $end) {
            $query->where('format_date', '>=', $begin);
            $query->where('format_date', '<=', $end);
        })->count();
        if ($count > 0) {
            foreach ($data as $key => $value) {
                $output .= '      <tr>
                                        <td>' . $value->nameLogin . '</td>
                                        <td>' . Carbon::parse($value->Time)->format('d/m/y h:i:s') . '</td>
                                        <td>' . $value->ipAddress . '</td>
                                        <td>' . $value->action . '</td>
                                 </tr>';
            }
            $id = $value->id;
            if ($count > 10) {
                $output .= '   <tr class="tr-view-more-diary">
                                  <td class="text-center" colspan="4"><button onclick="viewMoreDiary(this)" data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-diary-filter">Xem thêm...</button></td>
                           </tr>';
            }
        } else {
            $output .= '   <tr>
                               <td class="text-center" colspan="4">Không có dòng nào !</td>
                         </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }

    public function viewMoreFilter(Request $request)
    {
        $output = '';
        $begin = $request->begin;
        $end = $request->end;
        $data = ActHistory::where('id', '>', $request->id)->where(function ($query) use ($begin, $end) {
            $query->where('format_date', '>=', $begin);
            $query->where('format_date', '<=', $end);
        })->take(10)->get();
        $count = ActHistory::where('id', '>', $request->id)->where(function ($query) use ($begin, $end) {
            $query->where('format_date', '>=', $begin);
            $query->where('format_date', '<=', $end);
        })->count();
        if ($count > 0) {
            foreach ($data as $key => $value) {
                $output .= '      <tr>
                                        <td>' . $value->nameLogin . '</td>
                                        <td>' . Carbon::parse($value->Time)->format('d/m/y h:i:s') . '</td>
                                        <td>' . $value->ipAddress . '</td>
                                        <td>' . $value->action . '</td>
                                 </tr>';
            }
            $id = $value->id;
            if ($count > 10) {
                $output .= '   <tr class="tr-view-more-diary">
                                  <td class="text-center" colspan="4"><button onclick="viewMoreDiary(this)" data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-diary-filter">Xem thêm...</button></td>
                           </tr>';
            }
        } else {
            $output .= '   <tr>
                               <td class="text-center" colspan="4">Không có dòng nào !</td>
                         </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }
    public function index()
    {
        $all = User::paginate(9);
        return view('admin.page.all_users', compact('all'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.page.create_users', compact('roles'));
    }
    public function filter(Request $request)
    {
        $output = '';
        if ($request->stt != 3) {
            $data = User::where('status', '=', $request->stt)->take(9)->get();
            $count = User::where('status', '=', $request->stt)->count();
        } elseif ($request->stt == 3) {
            $data = User::take(9)->get();
            $count = count(User::all());
        }

        if ($count > 0) {

            foreach ($data as $key => $value) {
                if ($value->status == 1) {
                    $stt = ' <i style="color:#34CD26 ;" class="fa fa-circle"></i> Hoạt động';
                } elseif ($value->status == 2) {
                    $stt = ' <i style="color:#EC3740 ;" class="fa fa-circle"></i> Ngưng hoạt động';
                }
                $output .= '           <tr>
                                                <td>' . $value->name . '</td>
                                                <td>' . $value->fullname . '</td>
                                                <td>' . $value->phone . '</td>
                                                <td>' . $value->email . '</td>
                                                <td>' . $value->roles->nameRole . '</td>
                                                <td>' . $stt . '</td>
                                                <td><a href="/admin/system/users/edit/' . $value->id . '">Cập nhật</a></td>
                                   </tr>';
            }
            $id = $value->id;
            if ($count > 9) {
                $output .= ' <tr class="tr-box-btn-view-more-account">
                              <td colspan="7" class="text-center"><button onclick="viewMoreUsersFilter(this)" data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-account-filter">Xem thêm...</button></td>
                         </tr> ';
            }
        } else {
            $output .= ' <tr>
                              <td colspan="7" class="text-center">Không có kết quả nào !</td>
                         </tr> ';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }
    public function viewMore(Request $request)
    {
        $output = '';
        if ($request->stt != 3) {
            $data = User::where('id', '>', $request->id)->where('status', '=', $request->stt)->take(9)->get();
            $count = User::where('status', '=', $request->stt)->count();
        } elseif ($request->stt == 3) {
            $data = User::where('id', '>', $request->id)->take(9)->get();
            $count = count(User::where('id', '>', $request->id)->get());
        }

        if ($count > 0) {

            foreach ($data as $key => $value) {
                if ($value->status == 1) {
                    $stt = ' <i style="color:#34CD26 ;" class="fa fa-circle"></i> Hoạt động';
                } elseif ($value->status == 2) {
                    $stt = ' <i style="color:#EC3740 ;" class="fa fa-circle"></i> Ngưng hoạt động';
                }
                $output .= '           <tr>
                                                <td>' . $value->name . '</td>
                                                <td>' . $value->fullname . '</td>
                                                <td>' . $value->phone . '</td>
                                                <td>' . $value->email . '</td>
                                                <td>' . $value->roles->nameRole . '</td>
                                                <td>' . $stt . '</td>
                                                <td><a href="/admin/system/users/edit/' . $value->id . '">Cập nhật</a></td>
                                   </tr>';
            }
            $id = $value->id;
            if ($count > 9) {
                $output .= ' <tr class="tr-box-btn-view-more-account">
                              <td colspan="7" class="text-center"><button onclick="viewMoreUsersFilter(this)" data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-account-filter">Xem thêm...</button></td>
                         </tr> ';
            }
        } else {
            $output .= ' <tr>
                              <td colspan="7" class="text-center">Không có kết quả nào !</td>
                         </tr> ';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }
    public function keyup(Request $request)
    {
        $output = '';
        $key = $request->key;
        $data = User::where(function ($query) use ($key) {
            $query->where('name', 'like', '%' . $key . '%');
            $query->orWhere('fullname', 'like', '%' . $key . '%');
            $query->orWhere('email', '=', $key);
            $query->orWhere('phone', '=', $key);
            $query->orWhereHas('roles', function ($querys) use ($key) {
                $querys->where('nameRole', 'like', '%' . $key . '%');
            });
        })->take(9)->get();
        $count = User::where(function ($query) use ($key) {
            $query->where('name', 'like', '%' . $key . '%');
            $query->orWhere('fullname', 'like', '%' . $key . '%');
            $query->orWhere('email', '=', $key);
            $query->orWhere('phone', '=', $key);
            $query->orWhereHas('roles', function ($querys) use ($key) {
                $querys->where('nameRole', 'like', '%' . $key . '%');
            });
        })->count();

        if ($count > 0) {
            foreach ($data as $key => $value) {
                if ($value->status == 1) {
                    $stt = '<i style="color:#34CD26 ;" class="fa fa-circle"></i> Hoạt động';
                } elseif ($value->status == 2) {
                    $stt = '<i style="color:#EC3740 ;" class="fa fa-circle"></i> Ngưng hoạt động';
                }
                $output .= '              <tr>
                                                <td>' . $value->name . '</td>
                                                <td>' . $value->fullname . '</td>
                                                <td>' . $value->phone . '</td>
                                                <td>' . $value->email . '</td>
                                                <td>' . $value->roles->nameRole . '</td>
                                                <td>' . $stt . '</td>
                                                <td><a href="/admin/system/users/edit/' . $value->id . '">Cập nhật</a></td>
                                        </tr>';
            }
            $id = $value->id;
            if ($count > 9) {
                $output .= '   <tr class="tr-view-more-users">
                                      <td class="text-center" colspan="8"><button onclick="viewMoreKeyupUsers(this)" data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-keyup-users-filter">Xem thêm...</button></td>
                               </tr>';
            }
        } else {
            $output .= ' <tr>
                           <td class="text-center" colspan="7">Không tìm thấy kết quả nào !</td>
                        </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }
    public function viewMoreKeyup(Request $request)
    {
        $output = '';
        $key = $request->key;
        $data = User::where('id', '>', $request->id)->where(function ($query) use ($key) {
            $query->where('name', 'like', '%' . $key . '%');
            $query->orWhere('fullname', 'like', '%' . $key . '%');
            $query->orWhere('email', '=', $key);
            $query->orWhere('phone', '=', $key);
            $query->orWhereHas('roles', function ($querys) use ($key) {
                $querys->where('nameRole', 'like', '%' . $key . '%');
            });
        })->take(9)->get();
        $count = User::where('id', '>', $request->id)->where(function ($query) use ($key) {
            $query->where('name', 'like', '%' . $key . '%');
            $query->orWhere('fullname', 'like', '%' . $key . '%');
            $query->orWhere('email', '=', $key);
            $query->orWhere('phone', '=', $key);
            $query->orWhereHas('roles', function ($querys) use ($key) {
                $querys->where('nameRole', 'like', '%' . $key . '%');
            });
        })->count();

        if ($count > 0) {
            foreach ($data as $key => $value) {
                if ($value->status == 1) {
                    $stt = '<i style="color:#34CD26 ;" class="fa fa-circle"></i> Hoạt động';
                } elseif ($value->status == 2) {
                    $stt = '<i style="color:#EC3740 ;" class="fa fa-circle"></i> Ngưng hoạt động';
                }
                $output .= '              <tr>
                                                <td>' . $value->name . '</td>
                                                <td>' . $value->fullname . '</td>
                                                <td>' . $value->phone . '</td>
                                                <td>' . $value->email . '</td>
                                                <td>' . $value->roles->nameRole . '</td>
                                                <td>' . $stt . '</td>
                                                <td><a href="/admin/system/users/edit/' . $value->id . '">Cập nhật</a></td>
                                        </tr>';
            }
            $id = $value->id;
            if ($count > 9) {
                $output .= '   <tr class="tr-view-more-users">
                                      <td class="text-center" colspan="8"><button onclick="viewMoreKeyupUsers(this)" data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-keyup-users-filter">Xem thêm...</button></td>
                               </tr>';
            }
        } else {
            $output .= ' <tr>
                           <td class="text-center" colspan="7">Không tìm thấy kết quả nào !</td>
                        </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'fullname' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/',
            'confirm_password' => 'required|same:password',
            'role' => 'required',
            'status' => 'required',
        ], [
            'fullname.required' => 'Họ tên bắt buộc !',
            'phone.required' => 'Số điện thoại bắt buộc !',
            'phone.numeric' => 'Số điện thoại phải là số !',
            'name.required' => 'Tên đăng nhập bắt buộc !',
            'password.required' => 'Mật khẩu là bắt buộc !',
            'password.min' => 'Mật khẩu phải ít nhất 8 ký tự !',
            'password.regex' => 'Mật khẩu phải có ít nhất ký tự in hoa n ký tự thường và chũ số !',
            'confirm_password.required' => 'Bắt buộc nhập lại mật khẩu !',
            'confirm_password.same' => 'Nhập lại mật khẩu không đúng !',
            'role.required' => 'Vui lòng chọn vai trò !',
            'status.required' => 'Vui lòng chọn trạng thái !',
            'email.required' => 'Vui lòng nhập email !',
            'email.email' => 'Email sai định dạng !'
        ]);
        if ($validation->fails()) {
            return response()->json(['status' => 202, 'msg' => $validation->errors()]);
        }

        $checkEmail = User::where('email', '=', trim($request->email))->count();
        $checkName = User::where('name', '=', trim($request->name))->count();
        if ($checkEmail > 0) {
            return response()->json(['status' => 204, 'msg' => 'Email đã tồn tại vui lòng chọn email khác !']);
        } elseif ($checkName > 0) {
            return response()->json(['status' => 206, 'msg' => 'Tên đăng nhập đã tồn tại vui lòng chọn tên khác !']);
        }

        $addUser = User::create([
            'fullname' => trim(ucwords($request->fullname)),
            'name' => trim($request->name),
            'email' => trim($request->email),
            'password_2' => trim($request->password),
            'password' => bcrypt(trim($request->password)),
            'status' => $request->status,
            'role' => $request->role,
            'created_at' => now(),
            'phone' => trim($request->phone),
        ])->id;
        $dataNew = User::find($addUser);
        $addHistory = ActHistory::create([
            'nameLogin' => auth()->guard('web')->user()->name,
            'Time' => now(),
            'ipAddress' => $request->ip(),
            'action' => 'Thêm mới tài khoản ' . $dataNew->name,
            'format_date' => now()->toDateString(),
            'created_at' => now()
        ]);
        if ($addUser && $addHistory) {
            return response()->json(['status' => 200, 'msg' => 'Thêm người dùng thành công !']);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id = null)
    {
        if (!$id) {
            return abort(404);
        }
        $data = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.page.update_user', compact('data', 'roles'));
    }


    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'fullname' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/',
            'confirm_password' => 'required|same:password',
            'role' => 'required',
            'status' => 'required',
        ], [
            'fullname.required' => 'Họ tên bắt buộc !',
            'phone.required' => 'Số điện thoại bắt buộc !',
            'phone.numeric' => 'Số điện thoại phải là số !',
            'name.required' => 'Tên đăng nhập bắt buộc !',
            'password.required' => 'Mật khẩu là bắt buộc !',
            'password.min' => 'Mật khẩu phải ít nhất 8 ký tự !',
            'password.regex' => 'Mật khẩu phải có ít nhất ký tự in hoa n ký tự thường và chũ số !',
            'confirm_password.required' => 'Bắt buộc nhập lại mật khẩu !',
            'confirm_password.same' => 'Nhập lại mật khẩu không đúng !',
            'role.required' => 'Vui lòng chọn vai trò !',
            'status.required' => 'Vui lòng chọn trạng thái !',
            'email.required' => 'Vui lòng nhập email !',
            'email.email' => 'Email sai định dạng !'
        ]);
        if ($validation->fails()) {
            return response()->json(['status' => 202, 'msg' => $validation->errors()]);
        }

        $checkEmail = User::where('id', '!=', $request->id)->where('email', '=', trim($request->email))->count();
        $checkName = User::where('id', '!=', $request->id)->where('name', '=', trim($request->name))->count();
        if ($checkEmail > 0) {
            return response()->json(['status' => 204, 'msg' => 'Email đã tồn tại vui lòng chọn email khác !']);
        } elseif ($checkName > 0) {
            return response()->json(['status' => 206, 'msg' => 'Tên đăng nhập đã tồn tại vui lòng chọn tên khác !']);
        }

        $updateUser = User::find($request->id)->update([
            'fullname' => trim(ucwords($request->fullname)),
            'name' => trim($request->name),
            'email' => trim($request->email),
            'password_2' => trim($request->password),
            'password' => bcrypt(trim($request->password)),
            'status' => $request->status,
            'role' => $request->role,
            'updated_at' => now(),
            'phone' => trim($request->phone),
        ]);
        $addHistory = ActHistory::create([
            'nameLogin' => auth()->guard('web')->user()->name,
            'Time' => now(),
            'ipAddress' => $request->ip(),
            'action' => 'Cập nhật thông tin tài khoản ' . trim($request->name),
            'format_date' => now()->toDateString(),
            'created_at' => now()
        ]);
        if ($updateUser && $addHistory) {
            return response()->json(['status' => 200, 'msg' => 'Cập nhật tài khoản người dùng thành công !']);
        }
    }


    public function destroy($id)
    {
        //
    }
}
