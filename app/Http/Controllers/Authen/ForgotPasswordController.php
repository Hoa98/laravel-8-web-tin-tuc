<?php

namespace App\Http\Controllers\Authen;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{


    public function postForgot(Request $request)
    {
        $rule= [
            'reset_email' => 'required|email|exists:users,email',
        ];
        $messages = [
            'reset_email.required' => 'Email không được để trống!',
            'reset_email.email' => 'Email không đúng định dạng',
            'reset_email.exists' => 'Email không chính xác!',
        ];

        $validator =  Validator::make($request->all(),$rule,$messages);
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors($validator);
        }

        $token = Str::random(60);

        DB::table('password_resets')->insert(
            ['email' => $request->reset_email, 'token' => $token, 'created_at' => Carbon::now()]
        );

        Mail::send('backend.auth.password-verify',['token' => $token], function($message) use ($request) {
                  $message->from('chuthihoa98bgg@gmail.com');
                  $message->to($request->reset_email);
                  $message->subject('Thông báo đặt lại mật khẩu');
               });

        return back()->with('message', 'Chúng tôi đã gửi qua email một liên kết đặt lại mật khẩu của bạn!');
    }
}