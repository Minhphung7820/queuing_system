<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\ActHistory;

class RoleController extends Controller
{

    public function index()
    {
        $all = Role::all();
        return view('admin.page.all_role', compact('all'));
    }


    public function create()
    {
        return view('admin.page.create_role');
    }


    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nameRole' => 'required',
        ], [
            'nameRole.required' => 'Vui lòng nhập tên vai trò !',
        ]);
        if ($validation->fails()) {
            return response()->json(['status' => 202, 'msg' => $validation->errors()]);
        }

        $checkName = Role::where('nameRole', "=", trim(ucfirst($request->nameRole)))->count();
        if ($checkName > 0) {
            return response()->json(['status' => 204, 'msg' => 'Tên vai trò đã tồn tại vui lòng chọn tên khác !', 'field' => 'nameRole']);
        }
        $id = Role::create([
            'nameRole' => trim(ucfirst($request->nameRole)),
            'der' => $request->der,
            'created_at' => now()
        ])->id;
        foreach ($request->function as $key => $value) {
            $insertPivot = DB::table('role_function')->insert([
                'idRole' => $id,
                'idFunc' => $value,
            ]);
        }
        $dataNew = Role::find($id);
        $addHistory = ActHistory::create([
            'nameLogin' => auth()->guard('web')->user()->name,
            'Time' => now(),
            'ipAddress' => $request->ip(),
            'action' => 'Thêm mới vai trò ' . $dataNew->nameRole,
            'format_date'=>now()->toDateString(),
            'created_at' => now()
        ]);
        if ($id && $insertPivot && $addHistory) {
            return response()->json(['status' => 200, 'msg' => 'Thêm vai trò thành công !']);
        }
    }

    public function keyup(Request $request)
    {
        $output = '';
        $data = Role::Where('nameRole', 'like', '%' . $request->key . '%')->orWhere('der', 'like', '%' . $request->key . '%')->get();
        $count = Role::Where('nameRole', 'like', '%' . $request->key . '%')->orWhere('der', 'like', '%' . $request->key . '%')->count();
        if($count > 0){
             foreach ($data as $key => $value) {
                $output .= '       <tr>
                                        <td>'.$value->nameRole.'</td>
                                        <td>'.count($value->users).'</td>
                                        <td>'.$value->der.'</td>
                                        <td><a href="/admin/system/role/show/'.$value->id.'">Cập nhật</a></td>
                                  </tr>';
             }
        }else{
            $output .= ' <tr>
                                 <td colspan="4" class="text-center">Không có kết quả nào !</td>
                          </tr> ';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }

    public function show($id = null)
    {
        if (!$id) {
            return abort(404);
        }
        $data = Role::findOrFail($id);
        return view('admin.page.update_role', compact('data'));
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nameRole' => 'required',
        ], [
            'nameRole.required' => 'Vui lòng nhập tên vai trò !',
        ]);
        if ($validation->fails()) {
            return response()->json(['status' => 202, 'msg' => $validation->errors()]);
        }

        $checkName = Role::where("id", "!=", $request->id)->where('nameRole', "=", trim(ucfirst($request->nameRole)))->count();
        if ($checkName > 0) {
            return response()->json(['status' => 204, 'msg' => 'Tên vai trò đã tồn tại vui lòng chọn tên khác !', 'field' => 'nameRole']);
        }
        $update = Role::find($request->id)->update([
            'nameRole' => trim(ucfirst($request->nameRole)),
            'der' => $request->der,
            'updated_at' => now()
        ]);
        $updatePivot = Role::find($request->id)->func()->sync($request->function);
        $addHistory = ActHistory::create([
            'nameLogin' => auth()->guard('web')->user()->name,
            'Time' => now(),
            'ipAddress' => $request->ip(),
            'action' => 'Cập nhật thông tin vai trò ' . trim(ucfirst($request->nameRole)),
            'format_date'=>now()->toDateString(),
            'created_at' => now()
        ]);
        if ($update && $updatePivot && $addHistory) {
            return response()->json(['status' => 200, 'msg' => 'Cập nhật vai trò thành công !']);
        }
    }


    public function destroy($id)
    {
        //
    }
}
