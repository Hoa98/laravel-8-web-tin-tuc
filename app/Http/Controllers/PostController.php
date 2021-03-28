<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
Use App\Exports\PostExport;
use App\Imports\PostsImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class PostController extends Controller
{
    public function getIndex()
    {
     return view('backend.posts.index');
    }

    public function index(Request $request)
    {
       if($request->ajax()){
          $query = Post::select(['id','title','image','author','cate_id'])->orderBy('id', 'desc')->get();
          $query->load('comments');
          $query->load('view');
          $query->load('category');
          return DataTables::of($query) 
                 ->editColumn('image', function ($query) {
                      return '<img src="' . asset($query->image) . '" alt="image" style="max-width:60px;">';
                })
                  ->editColumn('comments', function($query){
                     return count($query->comments);
               })
               ->editColumn('view', function($query){
                     return $query->view->sum('views');
               })
               ->editColumn('cate_id', function ($query) {
                     return $query->category->name;
               })
                ->addColumn('action', function ($query) {
                      return '<a href="'. route('post.edit', ['id' => $query->id]) .'" title="Cập nhật bài viết" class="btn-sm btn-info d-inline-block mb-2"><i class="fas fa-edit"></i></a> 
                      <a href="'. route('post.remove', ['id' => $query->id]) .'" title="Xoá bài viết" class="btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></a>';
                })
                
                ->filter(function ($instance) use ($request) {
 
                   if (!empty($request->get('search'))) {
                       $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                           if (Str::contains(Str::lower($row['id']), Str::lower($request->get('search')))){
                               return true;
                           }else if (Str::contains(Str::lower($row['title']), Str::lower($request->get('search')))) {
                               return true;
                           }
                           else if (Str::contains(Str::lower($row['cate_id']), Str::lower($request->get('search')))) {
                               return true;
                           }
                           else if (Str::contains(Str::lower($row['author']), Str::lower($request->get('search')))) {
                               return true;
                           }
                           return false;
                       });
                   }
 
               })
                ->rawColumns(['image', 'action','cate_id','comments','view'])
                ->make(true);
       }
       return view('backend.posts.index');
    }

    public function addPost(){
        $cates = Category::all();
       return view('backend.posts.add-post',compact('cates'));
    }
 
    public function saveAdd(StorePostRequest $request)
    {
      $title = $request->title;
      $imageName = 'images/default.jpg';
      $cate_id = $request->cate_id;
      $content = $request->content;
      $short_desc = $request->short_desc;
      $author = $request->author;
    if($request->hasFile('image')){
       $image = $request->image;
       $images = time().'-'.$image->getClientOriginalName();
       $image->move(public_path('images/post'),$images);
       $imageName = 'images/post/'.$images;
    }
      $slug = Str::slug($title,'-');
      $p = Post::where('post_url','=', $slug)->first();
      if($p){
         $slug = $slug.'-1';
      }
       $post= new Post();
       $post->title =$title;
       $post->post_url = $slug;
       $post->image = $imageName;
       $post->cate_id = $cate_id;
       $post->content = $content;
       $post->short_desc = $short_desc;
       $post->author = $author;
       $post->save();
       return redirect(route('post.index'))->with('post_added','Bài viết mới đã thêm thành công');
    }
 
    public function editPost($id)
    {
       $post = Post::find($id);
       $cates = Category::all();
       return view('backend.posts.edit-post',compact('post','cates'));
    }
 
    public function updatePost(StorePostRequest $request)
    {
       $post = Post::find($request->id);
       $imageName = $post->image;
       $title = $request->title;
       $cate_id = $request->cate_id;
       $content = $request->content;
       $short_desc = $request->short_desc;
       $author = $request->author;
 
       if($request->hasFile('image')){
         $image = $request->image;
         $images = time().'-'.$image->getClientOriginalName();
         $image->move(public_path('images/post'),$images);
         $imageName = 'images/post/'.$images;
      }
      $slug = Str::slug($title,'-');
      $p = Post::where('post_url','=', $slug)
                     ->where('id','!=',$request->id)
                     ->first();
      if($p){
         $slug = $slug.'-1';
      }
       $post->title =$title;
       $post->post_url = $slug;
       $post->image = $imageName;
       $post->cate_id = $cate_id;
       $post->content = $content;
       $post->short_desc = $short_desc;
       $post->author = $author;
       $post->save();
       return redirect(route('post.index'))->with('post_updated','Cập nhật bài viết thành công');
    }
 
    public function deletePost($id)
    {
       View::where('post_id',$id)->delete();
       Comment::where('post_id',$id)->delete();
       $post = Post::find($id);
       if($post->image != 'images/default.jpg' && file_exists(public_path($post->image))){
         unlink(public_path($post->image));
       }
       $post->delete();
       return back()->with('post_deleted','Xoá bài viết thành công!');
    }

    public function exportIntoExcel()
    {
       return Excel::download(new PostExport, 'postlist.xlsx');
    }

   //  public function exportIntoCSV()
   //  {
   //     return Excel::download(new PostExport,'postlist.csv');
   //  }

    public function importExportView()
    {
       return view('backend.posts.import');
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
      Excel::import(new PostsImport,request()->file('file'));
      return redirect(route('post.index'))->with('post_added','Nhập dữ liệu thành công!');
     } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
      $failures = $e->failures();
      return view('backend.posts.import',compact('failures'));
     }
    }
 }