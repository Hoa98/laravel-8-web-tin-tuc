<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Authen;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;
use App\Console\Commands\ScrapeCommand;
use Illuminate\Http\Request;

Route::middleware('check.login')->group(function () {
   
    Route::get('/', [ViewController::class, 'handleChart'])->name('admin');

    Route::get('scrape',[ScrapeCommand::class,'handle'])->name('scrape');

    Route::get('profile',[UserController::class,'profile'])->name('admin.profile');
    Route::post('profile',[UserController::class,'updateProfile'])->name('admin.updateProfile');
    Route::post('password',  [UserController::class, 'resetPassAdmin'])->name('admin.resetPass');

    Route::prefix('danh-muc')->group(function(){
        Route::get('/', [CategoryController::class, 'getIndex'])->name('cate.index');

        Route::get('/ajax/cate', [CategoryController::class, 'index'])->name('cate.api');
    
        Route::get('{id}/remove', [CategoryController::class, 'deleteCate'])->name('cate.remove');
    
        Route::get('add',  [CategoryController::class, 'addCate'])->name('cate.add');
    
        Route::post('add',  [CategoryController::class, 'saveAdd'])->name('cate.saveAdd');
        
        Route::get('edit/{id}',  [CategoryController::class, 'editCate'])->name('cate.edit');
        
        Route::post('update-cate',  [CategoryController::class, 'updateCate'])->name('cate.update');
        Route::get('export-excel',  [CategoryController::class, 'exportIntoExcel'])->name('cate.export');

        Route::get('importExportView',  [CategoryController::class, 'importExportView'])->name('cate.importView');
       
        Route::post('import',  [CategoryController::class, 'import'])->name('cate.import');
    });

    Route::prefix('bai-viet')->group(function(){
        Route::get('/', [PostController::class, 'getIndex'])->name('post.index');

        Route::get('/ajax/post', [PostController::class, 'index'])->name('post.api');
    
        Route::get('{id}/remove', [PostController::class, 'deletepost'])->name('post.remove');
    
        Route::get('add',  [PostController::class, 'addPost'])->name('post.add');
    
        Route::post('add',  [PostController::class, 'saveAdd'])->name('post.saveAdd');
        
        Route::get('edit/{id}',  [PostController::class, 'editPost'])->name('post.edit');
        
        Route::post('update-post',  [PostController::class, 'updatePost'])->name('post.update');
       
        Route::get('export-excel',  [PostController::class, 'exportIntoExcel'])->name('post.export');

        Route::get('importExportView',  [PostController::class, 'importExportView'])->name('post.importView');
       
        Route::post('import',  [PostController::class, 'import'])->name('post.import');
    });

    Route::prefix('tai-khoan')->group(function(){
        Route::get('/', [UserController::class, 'getIndex'])->name('user.index');
    
        Route::get('/ajax/user', [UserController::class, 'index'])->name('user.api');

        Route::get('{id}/remove', [UserController::class, 'deleteUser'])->name('user.remove');
    
        Route::get('add',  [UserController::class, 'addUser'])->name('user.add');
    
        Route::post('add',  [UserController::class, 'saveAdd'])->name('user.saveAdd');
        
        Route::get('edit/{id}',  [UserController::class, 'editUser'])->name('user.edit');
        
        Route::post('update-user',  [UserController::class, 'updateUser'])->name('user.update');

        Route::post('resset-pass',  [UserController::class, 'resPass'])->name('user.res-pass');

        Route::get('export-excel',  [UserController::class, 'exportIntoExcel'])->name('user.export');

        Route::get('importExportView',  [UserController::class, 'importExportView'])->name('user.importView');
       
        Route::post('import',  [UserController::class, 'import'])->name('user.import');
    });

    Route::prefix('binh-luan')->group(function(){
        Route::get('/', [CommentController::class, 'getIndex'])->name('comment.index');

        Route::get('/ajax/com', [CommentController::class, 'index'])->name('comment.api');
    
        Route::get('{id}/remove', [CommentController::class, 'deleteCom'])->name('comment.remove');
    
        Route::get('edit/{id}/{status}',  [CommentController::class, 'editStatus'])->name('comment.status');
    });
    

});

Route::middleware('guest')->group(function () {
    return view('backend.auth.login');
});

Route::get('login',[Authen\LoginController::class,'getLogin'])->name('login');

Route::post('login',[Authen\LoginController::class,'postLogin'])->name('admin.login');

Route::any('logout',function(Request $request){
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect(route('login'));
})->name('admin.logout');


Route::get('/forgot-password', function () {
    return view('backend.auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', [Authen\ForgotPasswordController::class,'postForgot'])
        ->middleware('guest')->name('password.email');