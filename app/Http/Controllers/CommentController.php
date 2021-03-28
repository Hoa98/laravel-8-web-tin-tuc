<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    public function getIndex()
   {
       return view('backend.comments.index');
   }

   public function index(Request $request)
   {
      if($request->ajax()){
         $query = Comment::join('users', 'users.id', '=', 'comments.user_id')
                        ->join('posts', 'posts.id', '=', 'comments.post_id')
                        ->select(['comments.id','name','email','comments.content','status','title'])->orderBy('comments.id', 'desc')->get();
        
         return DataTables::of($query) 
               ->addColumn('action', function ($query) {
                     return '<a href="'. route('comment.remove', ['id' => $query->id]) .'" title="Xoá bình luận" class="btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></a>';
               })
               ->editColumn('status', function ($query) {
                if($query->status == 1){
                    return '<a href="'. route('comment.status', ['id' => $query->id,'status'=>0]) .'" title="Cập nhật trạng thái" class="btn-sm btn-success">Hiện</a>';
                 }else{
                    return '<a href="'. route('comment.status', ['id' => $query->id,'status'=>1]) .'" title="Cập nhật trạng thái" class="btn-sm btn-warning">Ẩn</a>';
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
                          }else if (Str::contains(Str::lower($row['title']), Str::lower($request->get('search')))) {
                              return true;
                          }else if (Str::contains(Str::lower($row['status']), Str::lower($request->get('search')))) {
                              return true;
                          }

                          return false;
                      });
                  }

              })
               ->rawColumns(['action','status'])
               ->make(true);
      }
      return view('backend.categories.index');
   }

   public function deleteCom($id)
   {
     Comment::find($id)->delete();
      return back()->with('com_deleted','Xoá bình luận thành công!');
   }

   public function editStatus(Request $request)
   {
       $com = Comment::find($request->id);
       $com->status = $request->status;
       $com->save();
       return redirect(route('comment.index'))->with('com_updated','Cập nhật trạng thái thành công');
   }
}