<?php

namespace App\Http\Controllers\Authen;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function getLogin()
    {
        if (Auth::check()) {
            // nếu đăng nhập thành công thì 
            return redirect(route('admin'));
        } else {
            return view('backend.auth.login');
        }

    }
  
    public function postLogin(LoginRequest $request)
    {
        $user = User::where('email','=',$request->email)->first();
        if($user->email_verified_at == null){
            return redirect()
            ->back()
            ->withInput()
            ->withErrors( [
                'password' =>  "Tài khoản chưa được kích hoạt!"
            ]); 
        }else{
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password],$request->remember)){
                $request->session()->regenerate();
                if(Auth::user()->role==1){
                    return redirect(route('admin'));
                }
                return redirect(route('homepage'));
            }else{
                return redirect()
                                ->back()
                                ->withInput()
                                ->withErrors( [
                                    'password' =>  "Tài khoản/mật khẩu không đúng!"
                                ]);
            }
        }
       
    }
    public function userLogin(LoginRequest $request)
    {
        $user = User::where('email','=',$request->email)->first();
        if($user->email_verified_at == null){
            return redirect()
            ->back()
            ->withInput()
            ->withErrors( [
                'password' =>  "Tài khoản chưa được kích hoạt!"
            ]); 
        }else{
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password],$request->remember)){
                $request->session()->regenerate();
                
                return redirect()->back()->with('user_log','Xin chào '.Auth::user()->name);
            }else{
                return redirect()
                                ->back()
                                ->withInput()
                                ->withErrors( [
                                    'password' =>  "Tài khoản/mật khẩu không đúng!"
                                ]);
               
            }
        }
        
    }

  
}