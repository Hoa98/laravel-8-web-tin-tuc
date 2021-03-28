<?php

namespace App\Http\Controllers\Authen;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
       
        $rule= [
            'res_name' => 'required|min:2',
            'res_email' => 'required|email|unique:users,email',
            'res_password' => 'required|min:6',
            'res_password_confirmation' => 'required|same:res_password',
        ];
        $messages = [
            'res_name.required' => 'Họ tên không được để trống!',
            'res_name.min' => 'Họ tên tối thiểu 2 ký tự!',
            'res_email.required' => 'Email không được để trống!',
            'res_email.email' => 'Email không đúng định dạng',
            'res_email.unique' => 'Email đã tồn tại',
            'res_password.required' => 'Mật khẩu không được để trống!',
            'res_password.min' => 'Mật khẩu tối thiểu 6 kí tự',
            'res_password_confirmation.required' => 'Mật khẩu không được để trống',
            'res_password_confirmation.same' => 'Mật khẩu không giống nhau',
        ];

        $validator =  Validator::make($request->all(),$rule,$messages);
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors($validator);
        }else{
             $avatarName = 'images/user-default.jpg';
             $user= new User();
             $user->name =$request->res_name;
             $user->avatar = $avatarName;
             $user->email = $request->res_email;
             $user->role = 2;
             $user->password = Hash::make($request->res_password);
             $user->save();

             $token = Str::random(60);

        DB::table('password_resets')->insert(
            ['email' => $request->res_email, 'token' => $token, 'created_at' => Carbon::now()]
        );

        Mail::send('backend.auth.email-verify',['token' => $token,'email'=>$request->res_email], function($message) use ($request) {
                  $message->from('chuthihoa98bgg@gmail.com');
                  $message->to($request->res_email);
                  $message->subject('Chỉ còn 1 bước nữa để kích hoạt tài khoản!');
               });

        return back()->with('message', 'Chúng tôi đã gửi qua email một liên kết để kích hoạt tài khoản của bạn!');
            //  return redirect()
            //             ->back()
            //             ->with('user_reg','Đăng ký thành công');
        }
    }

    public function emailVerify(Request $request)       
    {
        $user = User::where('email','=',$request->email)
                    ->where('email_verified_at','=',null)
                    ->first();
        if($user){
            $active = DB::table('password_resets')
            ->where(['email' => $request->email, 'token' => $request->token])
            ->first();

            if(!$active)
                 return view('backend.auth.active-account')->with('message', 'Kích hoạt tài khoản không thành công!');

            User::where('email', $request->email)
                ->update(['email_verified_at' => Carbon::now()]);

            DB::table('password_resets')->where(['email'=> $request->email])->delete();

            return view('backend.auth.active-account')->with('message', 'Kích hoạt tài khoản thành công!'); 
        }else{
            return redirect(route('homepage'));
        }
    }
}