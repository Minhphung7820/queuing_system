<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function myAccount()
    {
        return view('admin.page.my_account');
    }
    public function login()
    {
        return view('admin.page.login');
    }
    public function changeAvatar(Request $request)
    {
  
          $user = Auth::guard('web')->user();
          $folderPath = public_path('backend/layout/img/'); 
          $image_parts = explode(";base64,", $request->base); 
          $image_type_aux = explode("image/", $image_parts[0]); 
          $image_type = $image_type_aux[1]; 
          $image_base64 = base64_decode($image_parts[1]); 
          $nameFile = uniqid() .".". $image_type;
          $file = $folderPath . $nameFile; 
          file_put_contents($file, $image_base64); 
          User::find($user->id)->update([
             'avt'=>$nameFile,
          ]);
          return response()->json(['status'=>200,'msg'=>'Cập nhật thành công !']); 
    }
    public function _login(Request $request)
    {
        if (Auth::guard('web')->attempt(['name' => trim($request->name), 'password' => $request->password])) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 202]);
        }
    }

    public function forgot()
    {
        return view('admin.page.forgot');
    }
    public function _forgot(Request $request)
    {
        $check =  User::where("email", "=", $request->email)->count();
        if ($check == 0) {
            return response()->json(['status' => 202]);
        }
        User::where("email", "=", $request->email)->update([
            'email_verification' => md5($request->email)
        ]);
        $data = array(
            'link' => url("/xac-thuc-email/" . md5($request->email))
        );
        $send =  Mail::to($request->email)->send(new EmailVerification($data));
        if ($send) {
            return response()->json(['status' => 200]);
        }
    }
    public function verifi($code_email)
    {
        $check = User::where("email_verification", "=", $code_email)->count();
        if ($check == 0) {
            return abort(404);
        }

        $data = User::where("email_verification", "=", $code_email)->first();
        return view('admin.page.reset_pass', compact('data'));
    }
    public function reset(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'password' => 'min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/',
            'confirm_password'=>'same:password'
        ], [
            'password.min' => "Mật khẩu ít nhất 8 ký tự.",
            "password.regex" => "Mật khẩu phải có ít nhất 1 chữ thường , chữ in hoa và chữ số.",
            'confirm_password.same'=>'Nhập lại mật khẩu không đúng.'
        ]);
        if ($validation->fails()) {
            return response()->json(['status' => 202, 'msg' => $validation->errors()]);
        }
        $reset = User::find($request->id)->update([
            'password' => bcrypt($request->password),
        ]);
        if($reset){
            return response()->json(['status' => 200,'msg'=>'Đặt lại mật khẩu thành công !']);
        }
    }
    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/dang-nhap');
    }
    public function _logout(Request $request)
    {
        Auth::guard('web')->logout();
        return response()->json(['status'=>200]);
    }
}
