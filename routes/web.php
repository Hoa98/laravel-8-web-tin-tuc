<?php

use App\Http\Controllers\Authen;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use function PHPSTORM_META\type;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PagesController::class,'index'])->name('homepage');

Route::get('{url}.{id}.html', [PagesController::class,'post']);

Route::get('search-post', [PagesController::class,'searchPost']);

Route::post('comment', [PagesController::class,'comment'])->name('post.comment');

Route::post('post/api/tang-view', [PagesController::class, 'tangView'])
->name('post.tangView');


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});


Route::post('login',[Authen\LoginController::class,'userLogin'])->name('user.login');

Route::post('register',[Authen\RegisterController::class,'register'])->name('user.register');

Route::get('active-account/{email}/{token}',[Authen\RegisterController::class,'emailVerify'])->name('email.verify');

Route::post('forgot_pass',[Authen\ForgotPasswordController::class,'postForgot'])->name('user.forgot_pass');

Route::any('logout',function(){
    Auth::logout();
    return redirect()->back();
})->name('logout');


Route::get('/reset-password/{token}', function ($token) {
    return view('backend.auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', [Authen\ResetPasswordController::class,'resetPass'])
        ->middleware('guest')->name('password.update');

Route::get('{url}', [PagesController::class,'category']);