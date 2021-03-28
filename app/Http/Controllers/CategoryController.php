<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\View;
use Yajra\DataTables\DataTables;
Use App\Exports\CategoryExport;
use App\Imports\CategoryImport;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
   public function getIndex()
   {
       return view('backend.categories.index');
   }

   public function index(Request $request)
   {
      if($request->ajax()){
         $query = Category::select(['id','name','logo'])->orderBy('id', 'desc')->get();
         $query->load('posts');
         return DataTables::of($query) 
                ->editColumn('logo', function ($query) {
                     return '<img src="' . asset($query->logo) . '" alt="Logo" style="max-width:60px;">';
               })
               ->addColumn('action', function ($query) {
                     return '<a href="'. route('cate.edit', ['id' => $query->id]) .'" title="Cập nhật danh mục" class="btn-sm btn-info d-inline-block mb-2"><i class="fas fa-edit"></i></a> 
                     <a href="'. route('cate.remove', ['id' => $query->id]) .'" title="Xoá danh mục" class="btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></a>';
               })
               ->editColumn('posts', function ($query) {
                     return count($query->posts);
               })
               ->filter(function ($instance) use ($request) {

                  if (!empty($request->get('search'))) {
                      $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                          if (Str::contains(Str::lower($row['id']), Str::lower($request->get('search')))){
                              return true;
                          }else if (Str::contains(Str::lower($row['name']), Str::lower($request->get('search')))) {
                              return true;
                          }

                          return false;
                      });
                  }

              })
               ->rawColumns(['logo', 'action','posts'])
               ->make(true);
      }
      return view('backend.categories.index');
   }
   public function addCate(){
      return view('backend.categories.add-cate');
   }

   public function saveAdd(StoreCategoryRequest $request)
   {
      $name = $request->name;
     $logoName = 'images/default.jpg';
   if($request->hasFile('logo')){
      $logo = $request->logo;
      $image = time().'-'.$logo->getClientOriginalName();
      $logo->move(public_path('images/cate'),$image);
      $logoName = 'images/cate/'.$image;
   }
      $slug = Str::slug($name,'-');
      $c = Category::where('cate_url','=', $slug)->first();
      if($c){
         $slug = $slug.'-1';
      }
      $cate= new Category();
      $cate->name =$name;
      $cate->cate_url = $slug;
      $cate->logo = $logoName;
      $cate->save();
      return redirect(route('cate.index'))->with('category_added','Danh mục mới đã thêm thành công');
   }

   public function editCate($id)
   {
      $cate = Category::find($id);
      return view('backend.categories.edit-cate',compact('cate'));
   }

   public function updateCate(StoreCategoryRequest $request)
   {
      $cate = Category::find($request->id);
      $logoName = $cate->logo;
      $name = $request->name;
      if($request->hasFile('logo')){
      $logo = $request->logo;
      $image = time().'-'.$logo->getClientOriginalName();
      $logo->move(public_path('images/cate'),$image);
      $logoName = 'images/cate/'.$image;
      }
     
      $slug = Str::slug($name,'-');
      $c = Category::where('cate_url','=', $slug)
                     ->where('id','!=',$request->id)
                     ->first();
      if($c){
         $slug = $slug.'-1';
      }
      $cate->name =$name;
      $cate->cate_url = $slug;
      $cate->logo = $logoName;
      $cate->save();
      return redirect(route('cate.index'))->with('cate_updated','Cập nhật danh mục thành công');
   }

   public function deleteCate($id)
   {
      $post = Post::where('cate_id',$id)->get();
      foreach($post as $p){
         View::where('post_id',$p->id)->delete();
         Comment::where('post_id',$p->id)->delete();
         if($p->image != 'images/default.jpg' && file_exists(public_path($p->image))){
            unlink(public_path($p->image));
          }
      }
      Post::where('cate_id',$id)->delete();
      $cate = Category::find($id);
      if($cate->logo != 'images/default.jpg' && file_exists(public_path($cate->logo))){
         unlink(public_path($cate->logo));
       }
      $cate->delete();
      return back()->with('cate_deleted','Xoá danh mục thành công!');
   }

   
   public function exportIntoExcel()
   {
      return Excel::download(new CategoryExport, 'catelist.xlsx');
   }

   public function importExportView()
   {
      return view('backend.categories.import');
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
      Excel::import(new CategoryImport,request()->file('file'));
     return redirect(route('cate.index'))->with('post_added','Nhập dữ liệu thành công!');
     } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
      $failures = $e->failures();
      return view('backend.categories.import',compact('failures'));
     }
   }
}