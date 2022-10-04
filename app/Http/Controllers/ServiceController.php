<?php

namespace App\Http\Controllers;

use App\Models\Numbers;
use App\Models\Services;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\ActHistory;

class ServiceController extends Controller
{

    public function index()
    {

        $arr_time = [];
        if (isset($_GET['key'])) {
            $key = $_GET['key'];
            $services = Services::where(function ($query) use ($key) {
                $query->where('name', 'like', '%' . $key . '%');
                $query->orWhere('der', 'like', '%' . $key . '%');
                $query->orWhere('code_services', 'like', '%' . $key . '%');
            })->paginate(9);
            $services->appends(['key' => $key]);
        } else {
            $services = Services::orderBy('created_at', 'desc')->paginate(9);
        }
        $rs = Services::all();
        foreach ($rs as $key => $value) {
            $time = new Carbon($value->created_at);
            $arr_time[] = $time->toDateString();
        }
        $dateLimit = count($arr_time) > 0 ? min($arr_time) : "00";
        return view('admin.page.all_services', compact('services', 'dateLimit'));
    }

    public function filter(Request $request)
    {
        $output = '';
        $begin = $request->begin;
        $end = $request->end;
        if ($request->stt == 3) {
            $rs = Services::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->take(9)->get();
            $count =  Services::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->count();
        } else {
            $rs = Services::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('status_active', '=', $request->stt)->take(9)->get();
            $count = Services::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('status_active', '=', $request->stt)->count();
        }
        if ($count > 0) {
            foreach ($rs as $key => $value) {
                $active = ($value->status_active == 1) ? '<i style="color:#35C75A;" class="fa fa-circle"></i> Hoạt động' : '<i style="color:#EC3740;" class="	fa fa-circle"></i> Ngưng hoạt động';
                $output .= '               <tr>
                                                <td>' . $value->code_services . '</td>
                                                <td>' . $value->name . '</td>
                                                <td>' . $value->der . '</td>
                                                <td>' . $active . '</td>
                                                <td><a href="/admin/services/show/' . $value->id . '">Chi tiết</a></td>
                                                <td><a href="/admin/services/edit/' . $value->id . '">Cập nhật</a></td>
                                          </tr>';
            }
            $id = $value->id;
            if ($count > 9) {
                $output .= '   <tr class="tr-view-more-services">
                                     <td class="text-center" colspan="8"><button data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-services-filter">Xem thêm...</button></td>
                              </tr>';
            }
        } else {
            $output .= '   <tr>
                              <td class="text-center" colspan="8">Không tìm thấy kết quả nào !</td>
                           </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }
    public function viewMore(Request $request)
    {
        $output = '';
        $begin = $request->begin;
        $end = $request->end;
        if ($request->stt == 3) {
            $rs = Services::where("id", ">", $request->id)->where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->take(9)->get();
            $count =  Services::where("id", ">", $request->id)->where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->count();
        } else {
            $rs = Services::where("id", ">", $request->id)->where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('status_active', '=', $request->stt)->take(9)->get();
            $count = Services::where("id", ">", $request->id)->where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('status_active', '=', $request->stt)->count();
        }
        foreach ($rs as $key => $value) {
            $active = ($value->status_active == 1) ? '<i style="color:#35C75A;" class="fa fa-circle"></i> Hoạt động' : '<i style="color:#EC3740;" class="	fa fa-circle"></i> Ngưng hoạt động';
            $output .= '               <tr>
                                            <td>' . $value->code_services . '</td>
                                            <td>' . $value->name . '</td>
                                            <td>' . $value->der . '</td>
                                            <td>' . $active . '</td>
                                            <td><a href="/admin/services/show/' . $value->id . '">Chi tiết</a></td>
                                            <td><a href="/admin/services/edit/' . $value->id . '">Cập nhật</a></td>
                                      </tr>';
        }
        $id = $value->id;
        if ($count > 9) {
            $output .= '   <tr class="tr-view-more-services">
                                 <td class="text-center" colspan="8"><button data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-services-filter">Xem thêm...</button></td>
                          </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }
    public function keyup(Request $request)
    {
        $output = '';
        $begin = $request->begin;
        $end = $request->end;
        $key = $request->key;
        if ($request->stt == 3) {
            $rs = Services::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where(function ($query) use ($key) {
                $query->where('name', 'like', '%' . $key . '%');
                $query->orWhere('der', 'like', '%' . $key . '%');
                $query->orWhere('code_services', 'like', '%' . $key . '%');
            })->take(9)
                ->get();
            $count =  Services::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where(function ($query) use ($key) {
                $query->where('name', 'like', '%' . $key . '%');
                $query->orWhere('der', 'like', '%' . $key . '%');
                $query->orWhere('code_services', 'like', '%' . $key . '%');
            })->count();
        } else {
            $rs = Services::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('status_active', '=', $request->stt)
                ->where(function ($query) use ($key) {
                    $query->where('name', 'like', '%' . $key . '%');
                    $query->orWhere('der', 'like', '%' . $key . '%');
                    $query->orWhere('code_services', 'like', '%' . $key . '%');
                })->take(9)
                ->get();
            $count = Services::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('status_active', '=', $request->stt)
                ->where(function ($query) use ($key) {
                    $query->where('name', 'like', '%' . $key . '%');
                    $query->orWhere('der', 'like', '%' . $key . '%');
                    $query->orWhere('code_services', 'like', '%' . $key . '%');
                })->count();
        }
        if ($count > 0) {
            foreach ($rs as $key => $value) {
                $active = ($value->status_active == 1) ? '<i style="color:#35C75A;" class="fa fa-circle"></i> Hoạt động' : '<i style="color:#EC3740;" class="	fa fa-circle"></i> Ngưng hoạt động';
                $output .= '               <tr>
                                                <td>' . $value->code_services . '</td>
                                                <td>' . $value->name . '</td>
                                                <td>' . $value->der . '</td>
                                                <td>' . $active . '</td>
                                                <td><a href="/admin/services/show/' . $value->id . '">Chi tiết</a></td>
                                                <td><a href="/admin/services/edit/' . $value->id . '">Cập nhật</a></td>
                                          </tr>';
            }
            $id = $value->id;
            if ($count > 9) {
                $output .= '   <tr class="tr-view-more-services">
                                     <td class="text-center" colspan="8"><button onclick="viewMoreKeyup(this)" data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary">Xem thêm...</button></td>
                              </tr>';
            }
        } else {
            $output .= '   <tr>
                              <td class="text-center" colspan="8">Không có tìm thấy của kết quả nào</td>
                           </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }
    public function viewMoreKeyup(Request $request)
    {
        $output = '';
        $begin = $request->begin;
        $end = $request->end;
        $key = $request->key;
        if ($request->stt == 3) {
            $rs = Services::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where(function ($query) use ($key) {
                $query->where('name', 'like', '%' . $key . '%');
                $query->orWhere('der', 'like', '%' . $key . '%');
                $query->orWhere('code_services', 'like', '%' . $key . '%');
            })->where('id', '>', $request->id)
                ->take(9)
                ->get();
            $count =  Services::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where(function ($query) use ($key) {
                $query->where('name', 'like', '%' . $key . '%');
                $query->orWhere('der', 'like', '%' . $key . '%');
                $query->orWhere('code_services', 'like', '%' . $key . '%');
            })->where('id', '>', $request->id)
                ->count();
        } else {
            $rs = Services::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('status_active', '=', $request->stt)
                ->where(function ($query) use ($key) {
                    $query->where('name', 'like', '%' . $key . '%');
                    $query->orWhere('der', 'like', '%' . $key . '%');
                    $query->orWhere('code_services', 'like', '%' . $key . '%');
                })
                ->where('id', '>', $request->id)
                ->take(9)
                ->get();
            $count = Services::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('status_active', '=', $request->stt)
                ->where(function ($query) use ($key) {
                    $query->where('name', 'like', '%' . $key . '%');
                    $query->orWhere('der', 'like', '%' . $key . '%');
                    $query->orWhere('code_services', 'like', '%' . $key . '%');
                })
                ->where('id', '>', $request->id)
                ->count();
        }
        foreach ($rs as $key => $value) {
            $active = ($value->status_active == 1) ? '<i style="color:#35C75A;" class="fa fa-circle"></i> Hoạt động' : '<i style="color:#EC3740;" class="	fa fa-circle"></i> Ngưng hoạt động';
            $output .= '               <tr>
                                            <td>' . $value->code_services . '</td>
                                            <td>' . $value->name . '</td>
                                            <td>' . $value->der . '</td>
                                            <td>' . $active . '</td>
                                            <td><a href="/admin/services/show/' . $value->id . '">Chi tiết</a></td>
                                            <td><a href="/admin/services/edit/' . $value->id . '">Cập nhật</a></td>
                                      </tr>';
        }
        $id = $value->id;
        if ($count > 9) {
            $output .= '   <tr class="tr-view-more-services">
                                 <td class="text-center" colspan="8"><button onclick="viewMoreKeyup(this)" data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary">Xem thêm...</button></td>
                          </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }
    public function create()
    {
        return view('admin.page.create_services');
    }


    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'codeServices' => 'required',
            'nameServices' => 'required',
        ], [
            'nameServices.required' => 'Vui lòng nhập tên dịch vụ !',
            'codeServices.required' => 'Vui lòng nhập mã dịch vụ !',
        ]);
        if ($validation->fails()) {
            return response()->json(['status' => 202, 'msg' => $validation->errors()]);
        } else {
            $checkName = Services::where('name', '=', trim(ucfirst($request->nameServices)))->count();
            if ($checkName > 0) {
                return response()->json(['status' => 204, 'msg' => 'Tên dịch vụ ' . $request->nameServices .  ' đã tồn tại !']);
            }
        }

        $rule = implode(',', $request->rule);
        $insert = Services::create([
            'name' => trim(strip_tags(ucfirst($request->nameServices))),
            'code_services' => trim(strip_tags($request->codeServices)),
            'der' => trim(strip_tags($request->der)),
            'number_rule' => $rule,
            'created_at' => now(),
            'format_date' => now()->toDateString(),
        ])->id;
        $dataNew = Services::find($insert);
        $addHistory = ActHistory::create([
            'nameLogin' => auth()->guard('web')->user()->name,
            'Time' => now(),
            'ipAddress' => $request->ip(),
            'action' => 'Thêm mới dịch vụ ' . $dataNew->name,
            'format_date' => now()->toDateString(),
            'created_at' => now()
        ]);
        if ($insert && $addHistory) {
            return response()->json(['status' => 200, 'msg' => 'Đã thêm dịch vụ thành công !']);
        }
    }


    public function show($id = null)
    {
        if (!$id) {
            return abort(404);
        }
        $arrTime = [];
        $data = Services::findOrFail($id);
        $number = Numbers::where("services_id", "=", $data->id)->paginate(8);
        $number->appends(['numerical' => 'all']);
        $dataTime =  Numbers::where("services_id", "=", $data->id)->get();

        foreach ($dataTime as $key => $value) {
            $arrTime[] = $value->format_date;
        }
        $dateLimit = count($arrTime) > 0 ? min($arrTime) : "00";
        return view('admin.page.detail_services', compact('data', 'number', 'dateLimit'));
    }

    public function filterNumbersServices(Request $request)
    {
        $output = '';
        $arrTime = [];
        $begin = $request->begin;
        $end = $request->end;
        if ($request->stt != 4) {
            $data = Numbers::where("services_id", "=", $request->id)
                ->where('status', '=', $request->stt)
                ->where(function ($query) use ($begin, $end) {
                    $query->where('format_date', '>=', $begin);
                    $query->where('format_date', '<=', $end);
                })->take(8)->get();
            $count = Numbers::where("services_id", "=", $request->id)
                ->where('status', '=', $request->stt)
                ->where(function ($query) use ($begin, $end) {
                    $query->where('format_date', '>=', $begin);
                    $query->where('format_date', '<=', $end);
                })->count();
        } elseif ($request->stt == 4) {
            $data = Numbers::where("services_id", "=", $request->id)
                ->where(function ($query) use ($begin, $end) {
                    $query->where('format_date', '>=', $begin);
                    $query->where('format_date', '<=', $end);
                })->take(8)->get();
            $count = Numbers::where("services_id", "=", $request->id)
                ->where(function ($query) use ($begin, $end) {
                    $query->where('format_date', '>=', $begin);
                    $query->where('format_date', '<=', $end);
                })->count();
        }
        if ($count > 0) {
            foreach ($data as $key => $value) {
                if ($value->status == 1) {
                    $stt = '<i style="color:#5490EB;" class="fa fa-circle"></i> Đang thực hiện';
                } elseif ($value->status == 2) {
                    $stt = '<i style="color: #34CD26;" class="fa fa-circle"></i> Đã hoàn thành';
                } elseif ($value->status == 3) {
                    $stt = '<i style="color: #6C7585;" class="fa fa-circle"></i> Vắng';
                }

                $output .= '              <tr>
                    <td>' . $value->number . '</td>
                    <td>
                         ' . $stt . '
                    </td>

                </tr>';
            }
            $id = $value->id;
            if ($count > 8) {
                $output .= '     <tr class="tr-view-more-numbers-in-detail-services">
                                          <td class="text-center" colspan="2"><button onclick="viewMoreNumberInDeatilService(this)" data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-numbers-in-detail-services">Xem thêm...</button></td>
                                     </tr>';
            }
        } else {
            $output .= '     <tr>
                                   <td class="text-center" colspan="2">Không tìm thấy kết quả nào !</td>
                             </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }

    public function viewMoreNumbersInService(Request $request)
    {
        $output = '';
        $begin = $request->begin;
        $end = $request->end;
        if ($request->stt != 4) {
            $data = Numbers::where("id", ">", $request->idNumMax)
                ->where("services_id", "=", $request->id)
                ->where('status', '=', $request->stt)
                ->where(function ($query) use ($begin, $end) {
                    $query->where('format_date', '>=', $begin);
                    $query->where('format_date', '<=', $end);
                })->take(8)->get();
            $count = Numbers::where("id", ">", $request->idNumMax)
                ->where("services_id", "=", $request->id)
                ->where('status', '=', $request->stt)
                ->where(function ($query) use ($begin, $end) {
                    $query->where('format_date', '>=', $begin);
                    $query->where('format_date', '<=', $end);
                })->count();
        } elseif ($request->stt == 4) {
            $data = Numbers::where("id", ">", $request->idNumMax)
                ->where("services_id", "=", $request->id)
                ->where(function ($query) use ($begin, $end) {
                    $query->where('format_date', '>=', $begin);
                    $query->where('format_date', '<=', $end);
                })->take(8)->get();
            $count = Numbers::where("id", ">", $request->idNumMax)
                ->where("services_id", "=", $request->id)
                ->where(function ($query) use ($begin, $end) {
                    $query->where('format_date', '>=', $begin);
                    $query->where('format_date', '<=', $end);
                })->count();
        }
        if ($count > 0) {
            foreach ($data as $key => $value) {
                if ($value->status == 1) {
                    $stt = '<i style="color:#5490EB;" class="fa fa-circle"></i> Đang thực hiện';
                } elseif ($value->status == 2) {
                    $stt = '<i style="color: #34CD26;" class="fa fa-circle"></i> Đã hoàn thành';
                } elseif ($value->status == 3) {
                    $stt = '<i style="color: #6C7585;" class="fa fa-circle"></i> Vắng';
                }

                $output .= '              <tr>
                    <td>' . $value->number . '</td>
                    <td>
                         ' . $stt . '
                    </td>

                </tr>';
            }
            $id = $value->id;
            if ($count > 8) {
                $output .= '     <tr class="tr-view-more-numbers-in-detail-services">
                                          <td class="text-center" colspan="2"><button onclick="viewMoreNumberInDeatilService(this)" data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-numbers-in-detail-services">Xem thêm...</button></td>
                                     </tr>';
            }
        } else {
            $output .= '     <tr>
                                   <td class="text-center" colspan="2">Không tìm thấy kết quả nào !</td>
                             </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }

    public function edit($id = null)
    {
        if (!$id) {
            return abort(404);
        }
        $data = Services::findOrFail($id);
        return view('admin.page.update_services', compact('data'));
    }

    public function keyupSearchNumbers(Request $request)
    {
        $output = '';
        $key = $request->key;
        $idSer = $request->id;
        $stt = $request->stt;
        $arrTime = [];
        $data = Numbers::where("services_id", "=", $idSer)->where("number", 'like', '%' . $key . '%')->take(8)->get();
        $dataTime =  Numbers::where("services_id", "=", $idSer)->where("number", 'like', '%' . $key . '%')->get();
        $count = Numbers::where("services_id", "=", $idSer)->where("number", 'like', '%' . $key . '%')->count();
        if (count($dataTime) > 0) {
            foreach ($dataTime as $key => $value) {
                $arrTime[] = $value->format_date;
            }
            $dateLimit = min($arrTime);
        } else {
            $dateLimit = "0000";
        }
        if ($count > 0) {
            foreach ($data as $key => $value) {
                if ($value->status == 1) {
                    $stt = '<i style="color:#5490EB;" class="fa fa-circle"></i> Đang thực hiện';
                } elseif ($value->status == 2) {
                    $stt = '<i style="color: #34CD26;" class="fa fa-circle"></i> Đã hoàn thành';
                } elseif ($value->status == 3) {
                    $stt = '<i style="color: #6C7585;" class="fa fa-circle"></i> Vắng';
                }

                $output .= '              <tr>
                        <td>' . $value->number . '</td>
                        <td>
                             ' . $stt . '
                        </td>
    
                    </tr>';
            }
            $id = $value->id;
            if ($count > 8) {
                $output .= '     <tr class="tr-view-more-numbers-in-detail-services">
                                              <td class="text-center" colspan="2"><button onclick="viewMoreResultsNumbersKeyupNumbers(this)" data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-numbers-keyup-in-detail-services">Xem thêm...</button></td>
                                         </tr>';
            }
        } else {
            $output .= '     <tr>
                                       <td class="text-center" colspan="2">Không tìm thấy kết quả nào !</td>
                                 </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output, 'limitD' => $dateLimit]);
    }

    public function viewMoreKeyupResultSearchNumbers(Request $request)
    {
        $output = '';
        $key = $request->key;
        $idSer = $request->id;
        $data = Numbers::where("id", ">", $request->idMax)->where("services_id", "=", $idSer)->where("number", 'like', '%' . $key . '%')->take(8)->get();
        $count = Numbers::where("id", ">", $request->idMax)->where("services_id", "=", $idSer)->where("number", 'like', '%' . $key . '%')->count();
        if ($count > 0) {
            foreach ($data as $key => $value) {
                if ($value->status == 1) {
                    $stt = '<i style="color:#5490EB;" class="fa fa-circle"></i> Đang thực hiện';
                } elseif ($value->status == 2) {
                    $stt = '<i style="color: #34CD26;" class="fa fa-circle"></i> Đã hoàn thành';
                } elseif ($value->status == 3) {
                    $stt = '<i style="color: #6C7585;" class="fa fa-circle"></i> Vắng';
                }

                $output .= '              <tr>
                        <td>' . $value->number . '</td>
                        <td>
                             ' . $stt . '
                        </td>
    
                    </tr>';
            }
            $id = $value->id;
            if ($count > 8) {
                $output .= '     <tr class="tr-view-more-numbers-in-detail-services">
                                              <td class="text-center" colspan="2"><button onclick="viewMoreResultsNumbersKeyupNumbers(this)" data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-numbers-keyup-in-detail-services">Xem thêm...</button></td>
                                         </tr>';
            }
        } else {
            $output .= '     <tr>
                                       <td class="text-center" colspan="2">Không tìm thấy kết quả nào !</td>
                                 </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'codeServices' => 'required',
            'nameServices' => 'required',
        ], [
            'nameServices.required' => 'Vui lòng nhập tên dịch vụ !',
            'codeServices.required' => 'Vui lòng nhập mã dịch vụ !',
        ]);
        if ($validation->fails()) {
            return response()->json(['status' => 202, 'msg' => $validation->errors()]);
        } else {
            $checkName = Services::where('name', '=', trim(ucfirst($request->nameServices)))->where('id', '!=', $request->id)->count();
            if ($checkName > 0) {
                return response()->json(['status' => 208, 'msg' => 'Tên dịch vụ ' . $request->nameServices .  ' đã tồn tại !']);
            }
        }
        $rule = implode(',', $request->rule);
        $update = Services::find($request->id)->update([
            'name' => trim(strip_tags(ucfirst($request->nameServices))),
            'code_services' => trim(strip_tags($request->codeServices)),
            'der' => trim(strip_tags($request->der)),
            'number_rule' => $rule,
            'updated_at' => now(),
        ]);
        $addHistory = ActHistory::create([
            'nameLogin' => auth()->guard('web')->user()->name,
            'Time' => now(),
            'ipAddress' => $request->ip(),
            'action' => 'Cập nhật thông tin dịch vụ ' . trim(strip_tags(ucfirst($request->nameServices))),
            'format_date' => now()->toDateString(),
            'created_at' => now()
        ]);
        if ($update && $addHistory) {
            return response()->json(['status' => 200, 'msg' => 'Đã cập nhật dịch vụ thành công !']);
        }
    }


    public function destroy($id)
    {
        //
    }
}
