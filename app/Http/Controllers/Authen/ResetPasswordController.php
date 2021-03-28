<?php

namespace App\Http\Controllers\Authen;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
   
 
     public function resetPass(Request $request)
     {

        $rule= [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ];
        $messages = [
            'email.required' => 'Email không được để trống!',
            'email.email' => 'Email không đúng định dạng',
            'email.exists' => 'Email không chính xác!',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min'=>'Mật khẩu ít nhất 6 ký tự',
            'password_confirmation.required'=>'Mật khẩu không được để trống',
            'password_confirmation.same' => 'Mật khẩu không giống nhau',
        ];

        $validator =  Validator::make($request->all(),$rule,$messages);
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors($validator);
        }

         $updatePassword = DB::table('password_resets')
                             ->where(['email' => $request->email, 'token' => $request->token])
                             ->first();
 
         if(!$updatePassword)
             return back()->withInput()->with('error', 'Mã không hợp lệ!');
 
           User::where('email', $request->email)
                       ->update(['password' => Hash::make($request->password)]);
 
           DB::table('password_resets')->where(['email'=> $request->email])->delete();
 
           return redirect(route('login'))->with('message', 'Mật khẩu của bạn đã được đổi thành công!');
     }
}