<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Comment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
Use App\Exports\UserExport;
use App\Imports\UserImport;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Monolog\Handler\ElasticaHandler;

class UserController extends Controller
{
    public function getIndex()
    {
     return view('backend.users.index');
    }

    public function index(Request $request)
    {
       if($request->ajax()){
          $query = User::select(['id','name','email','avatar','role'])
                        ->where('id','!=',Auth::id())
                        ->orderBy('id', 'desc')->get();
          return DataTables::of($query) 
                 ->editColumn('avatar', function ($query) {
                      return '<img src="' . asset($query->avatar) . '" alt="avatar" style="max-width:60px;">';
                })
                ->addColumn('action', function ($query) {
                     return '<a href="'. route('user.edit', ['id' => $query->id]) .'" title="Sửa" class="btn-sm btn-info"><i class="fas fa-edit"></i></a>
                     <a href="'. route('user.remove', ['id' => $query->id]) .'" title="Xoá" class="btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></a>' ;
                })
                ->editColumn('role', function ($query) {
                      if($query->role == 1){
                         return 'Quản trị';
                      }else{
                         return 'Người dùng';
                      }
                })
                ->filter(function ($instance) use ($request) {
 
                   if (!empty($request->get('search'))) {
                       $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                           if (Str::contains(Str::lower($row['id']), Str::lower($request->get('search')))){
                               return true;
                           }else if (Str::contains(Str::lower($row['name']), Str::lower($request->get('search')))) {
                               return true;
                           }else if (Str::contains(Str::lower($row['email']), Str::lower($request->get('search')))) {
                               return true;
                           }
 
                           return false;
                       });
                   }
 
               })
                ->rawColumns(['avatar', 'action','role'])
                ->make(true);
       }
       return view('backend.users.index');
    }

    public function addUser(){
        return view('backend.users.add-user');
     }

     public function saveAdd(StoreUserRequest $request)
   {
      $name = $request->name;
     $avatarName = 'images/user-default.jpg';
   if($request->hasFile('avatar')){
      $avatar = $request->avatar;
      $image = time().'-'.$avatar->getClientOriginalName();
      $avatar->move(public_path('images/user'),$image);
      $avatarName = 'images/user/'.$image;
   }
      $user= new User();
      $user->name =$name;
      $user->avatar = $avatarName;
      $user->email = $request->email;
      $user->role = $request->role;
      $user->email_verified_at = Carbon::now();
      $user->password = Hash::make($request->password);
      $user->save();
      return redirect(route('user.index'))->with('user_added','Tài khoản mới đã thêm thành công');
   }

   public function editUser($id)
   {
      $user = User::find($id);
      return view('backend.users.edit-user',compact('user'));
   }

   public function updateUser(StoreUserRequest $request)
   {
      $user = User::find($request->id);
     $avatarName = $user->avatar;
   if($request->hasFile('avatar')){
      $avatar = $request->avatar;
      $image = time().'-'.$avatar->getClientOriginalName();
      $avatar->move(public_path('images/user'),$image);
      $avatarName = 'images/user/'.$image;
   }
      $user->name =$request->name;
      $user->avatar = $avatarName;
      $user->email = $request->email;
      $user->role = $request->role;
      $user->save();
      return redirect(route('user.index'))->with('user_updated','Cập nhật tài khoản thành công');
   }

   public function deleteUser($id)
   {
      $user = User::find($id);
      Comment::where('user_id',$id)->delete();
      if($user->avatar != 'images/user-default.jpg'){
         unlink(public_path($user->avatar));
       }
      $user->delete();
      return back()->with('user_deleted','Xoá tài khoản thành công!');
   }

   public function resPass(Request $request)
   {
      
      $rule= [
         'password' => 'required|min:6',
         'res_pass' => 'required|min:6',
         'confirm_pass' => 'required|same:res_pass',
     ];
     $messages = [
         'password.required' => 'Mật khẩu không được để trống!',
         'password.min' => 'Mật khẩu tối thiểu 6 kí tự',
         'res_pass.required' => 'Mật khẩu không được để trống!',
         'res_pass.min' => 'Mật khẩu tối thiểu 6 kí tự',
         'confirm_pass.required' => 'Mật khẩu không được để trống',
         'confirm_pass.same' => 'Mật khẩu xác nhận không giống nhau',
     ];

     $validator =  Validator::make($request->all(),$rule,$messages);
     if ($validator->fails()) {
         return redirect()
                     ->back()
                     ->withInput()
                     ->withErrors($validator);
     }else{
          $user = User::find($request->id);
          if (Hash::check($request->password, $user->password)) {
            $user->password = Hash::make($request->res_pass);
            $user->save();
            return redirect()
                       ->back()
                       ->with('res_pass','Đổi mật khẩu thành công');
          }else{
            return redirect()
                            ->back()
                            ->withInput()
                            ->withErrors( [
                                'password' =>  "Mật khẩu không đúng!"
                            ]);
          }
         
     }
   }

   public function profile()
   {
      return view('backend.users.edit-admin');
   }

   public function updateProfile(StoreUserRequest $request)
   {
      $user = User::find($request->id);
     $avatarName = $user->avatar;
   if($request->hasFile('avatar')){
      $avatar = $request->avatar;
      $image = time().'-'.$avatar->getClientOriginalName();
      $avatar->move(public_path('images/user'),$image);
      $avatarName = 'images/user/'.$image;
   }
      $user->name = $request->name;
      $user->avatar = $avatarName;
      $user->email = $request->email;
      $user->role = $request->role;
      $user->save();
      Auth::user()->email = $user->email;
      Auth::user()->avatar = $user->avatar;
      Auth::user()->role = $user->role;
      Auth::user()->name = $user->name;
      Auth::user()->id = $user->id;
      return redirect(route('admin.profile'))->with('user_updated','Cập nhật tài khoản thành công');
   }

   public function resetPassAdmin(Request $request)
   {
      
      $rule= [
         'password' => 'required|min:6',
         'res_pass' => 'required|min:6',
         'confirm_pass' => 'required|same:res_pass',
     ];
     $messages = [
         'password.required' => 'Mật khẩu không được để trống!',
         'password.min' => 'Mật khẩu tối thiểu 6 kí tự',
         'res_pass.required' => 'Mật khẩu không được để trống!',
         'res_pass.min' => 'Mật khẩu tối thiểu 6 kí tự',
         'confirm_pass.required' => 'Mật khẩu không được để trống',
         'confirm_pass.same' => 'Mật khẩu xác nhận không giống nhau',
     ];

     $validator =  Validator::make($request->all(),$rule,$messages);
     if ($validator->fails()) {
         return redirect()
                     ->back()
                     ->withInput()
                     ->withErrors($validator);
     }else{
          $user = User::find($request->id);
          if (Hash::check($request->password, $user->password)) {
            $user->password = Hash::make($request->res_pass);
            $user->save();
            Auth::user()->password = $user->password;
            return redirect()
                       ->back()
                       ->with('res_pass','Đổi mật khẩu thành công');
          }else{
            return redirect()
                            ->back()
                            ->withInput()
                            ->withErrors( [
                                'password' =>  "Mật khẩu không đúng!"
                            ]);
          }
         
     }
   }

   public function exportIntoExcel()
   {
      return Excel::download(new UserExport, 'userlist.xlsx');
   }

   public function importExportView()
   {
      return view('backend.users.import');
   }

   public function import(Request $request)
   {
     $rule= [
        'file' => 'required|mimes:xls,xlsx,csv',
    ];
    $messages = [
        'file.required' => 'Bạn chưa chọn file!',
        'file.mimes' => 'File không đúng định dạng',
    ];

    $validator =  Validator::make($request->all(),$rule,$messages);
    if ($validator->fails()) {
        return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
    }
     try {
      Excel::import(new UserImport,request()->file('file'));
     return redirect(route('user.index'))->with('post_added','Nhập dữ liệu thành công!');
     } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
      $failures = $e->failures();
      return view('backend.users.import',compact('failures'));
     }
   }
}