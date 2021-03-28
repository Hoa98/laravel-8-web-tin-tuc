<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    
    public function index()
    {
       $now= Carbon::now('Asia/Ho_Chi_Minh');
        Carbon::setLocale('vi');
        $cate = Category::select('name','cate_url')->join('posts','categories.id','=','cate_id')->take(13)->distinct()->get();

        //Lấy bài viết có lượt view cao nhất trong 2 ngày gần đây
        $postView = Post::select('posts.id','title','post_url','cate_id','image','posts.created_at', DB::raw('SUM(views.views) as view'))
                            ->join('views','posts.id','=','post_id')
                            ->whereDate('created_date', $now->toDateString())
                            ->orWhereDate('created_date', $now->subDays()->toDateString())
                            // ->orWhereDate('created_date', $now->subDays(1)->toDateString())
                            ->groupBy('posts.id','title','post_url','cate_id','image','posts.created_at')
                            ->orderBy('view','desc')
                            ->take(6)
                            ->get();
        $postView->load('category');

        $postNews = Post::orderBy('id','desc')->take(5)->get();
        $postNews->load('view');

        $comingPost = Post::orderBy('id','desc')->take(3)->get();
        $comingPost->load('category');
        $comingPost->load('comments');
        $comingPost->load('view');

        $postHealth = Post::orderBy('id','desc')->where('cate_id','=',1)->take(4)->get();
        $postHealth->load('view');
        $postWorld = Post::orderBy('id','desc')->where('cate_id','=',2)->take(6)->get();
        $postWorld->load('view');
        $postEconomy = Post::orderBy('id','desc')->where('cate_id','=',3)->take(4)->get();
        $postEconomy->load('view');
        $postEconomy->load('comments');
        return view('frontend.index', compact('cate','postView','postNews','comingPost','postHealth','postWorld','postEconomy'));
    }

    public function category(Request $request)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        Carbon::setLocale('vi');
        $cateId = Category::select('id')->where('cate_url','=',$request->url)->first();
        $id = $cateId->id;
        $cate = Category::select('name','cate_url')->join('posts','categories.id','=','cate_id')->take(13)->distinct()->get();

         //Lấy bài viết có lượt view cao nhất trong 2 ngày gần đây
        $postView = Post::select('posts.id','title','post_url','cate_id','image','posts.created_at', DB::raw('SUM(views.views) as view'))
                        ->join('views','posts.id','=','post_id')
                        ->whereDate('created_date', $now->toDateString())
                        ->orWhereDate('created_date', $now->subDays()->toDateString())
                        // ->orWhereDate('created_date', $now->subDays(1)->toDateString())
                        ->groupBy('posts.id','title','post_url','cate_id','image','posts.created_at')
                        ->orderBy('view','desc')
                        ->take(6)
                        ->get();
        $postView->load('category');

        $postNews = Post::orderBy('id','desc')->take(5)->get();
        $postNews->load('view');
        $postWorld = Post::orderBy('id','desc')->where('cate_id','=',2)->take(6)->get();
        $postCate = Post::orderBy('id','desc')->where('cate_id','=',$id)->paginate(4);
        $postCate->load('view');
        $postCate->load('comments');
        $postCate->load('category');
       
        return view('frontend.categories-post', compact('cate','postView','postNews','postWorld','postCate'));
    }
    public function post(Request $request)
    {
       $now= Carbon::now('Asia/Ho_Chi_Minh');
        Carbon::setLocale('vi');
        $post = Post::where('post_url','=',$request->url)->first();
        $post->load('comments');
        
        $comments = Comment::join('users', 'users.id', '=', 'comments.user_id')
                            ->select('comments.id','content','comments.created_at', 'users.name', 'users.avatar')
                            ->where('post_id','=',$post->id)
                            ->where('status','=',1)
                            ->get();
       
        $cateId = $post->cate_id;
        $cate = Category::select('name','cate_url')->join('posts','categories.id','=','cate_id')->take(13)->distinct()->get();

        //Lấy bài viết có lượt view cao nhất trong 2 ngày gần đây
        $postView = Post::select('posts.id','title','post_url','cate_id','image','posts.created_at', DB::raw('SUM(views.views) as view'))
                            ->join('views','posts.id','=','post_id')
                            ->whereDate('created_date', $now->toDateString())
                            ->orWhereDate('created_date', $now->subDays()->toDateString())
                            // ->orWhereDate('created_date', $now->subDays(1)->toDateString())
                            ->groupBy('posts.id','title','post_url','cate_id','image','posts.created_at')
                            ->orderBy('view','desc')
                            ->take(6)
                            ->get();
    
        $postView->load('category');    

        $postNews = Post::orderBy('id','desc')->take(5)->get();
        $postNews->load('view');
        $postRelate = Post::orderBy('id','desc')->where('cate_id','=',$cateId)
                                                ->where('id','!=',$post->id)->take(4)->get();

        $postRelate->load('view');
        $postRelate->load('comments');
        $postRelate->load('category');
        $postWorld = Post::orderBy('id','desc')->where('cate_id','=',2)->take(6)->get();
        return view('frontend.post-detail', compact('cate','comments','postView','postNews','postWorld','post','postRelate'));
    }

    public function tangView(Request $request){
        // 1 kiểm tra xem có views của bài viết đang cần tìm trong ngày hôm nay không ?
        // nếu có thì tăng view
        // nếu không có thì tạo mới và add views = 1
        $today = Carbon::now('Asia/Ho_Chi_Minh');
        $postView = View::where('post_id', $request->id)
                        ->whereDate('created_date', $today->toDateString())
                        ->first();
        if($postView){
            $postView->views += 1;
        }else{
            $postView = new View();
            $postView->post_id = $request->id;
            $postView->views = 1;
            $postView->created_date = now();
        }
        $postView->save();
        $view = Post::where('id','=',$request->id)->first();
        return response()->json($view->view->sum('views'));
    }

    public function comment(Request $request)
    {
        $rule= [
            'content' => 'required|min:8',
        ];
        $messages = [
            'content.required' => 'Vui lòng nhập nội dung!',
            'content.min' => 'Ít nhất 8 ký tự!',
        ];

        $validator =  Validator::make($request->all(),$rule,$messages);
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors($validator);
        }else{
            $status = 0;
            if(Auth::user()->role==1){
                $status = 1;
            }
            $com= new Comment();
            $com->content = $request->content;
            $com->post_id = $request->post_id;
            $com->user_id = $request->user_id;
            $com->status = $status;
            $com->save();
            return redirect()->back()->with('comment_added','Bình luận của bạn đang chờ xác nhận');
        }
    }

    public function searchPost(Request $request)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        Carbon::setLocale('vi');
        $cate = Category::select('name','cate_url')->join('posts','categories.id','=','cate_id')->take(13)->distinct()->get();

        $postNews = Post::orderBy('id','desc')->take(5)->get();
        $postNews->load('view');
         //Lấy bài viết có lượt view cao nhất trong 2 ngày gần đây
        $postView = Post::select('posts.id','title','post_url','cate_id','image','posts.created_at', DB::raw('SUM(views.views) as view'))
                        ->join('views','posts.id','=','post_id')
                        ->whereDate('created_date', $now->toDateString())
                        ->orWhereDate('created_date', $now->subDays()->toDateString())
                        // ->orWhereDate('created_date', $now->subDays(1)->toDateString())
                        ->groupBy('posts.id','title','post_url','cate_id','image','posts.created_at')
                        ->orderBy('view','desc')
                        ->take(6)
                        ->get();
        $postView->load('category');
        
        $rule= [
            'keyword' => 'required',
        ];
        $messages = [
            'keyword.required' => 'Bạn chưa nhập từ khoá!',
        ];

        $validator =  Validator::make($request->all(),$rule,$messages);
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors($validator);
        }else{
            $keyword = $request->keyword;
            $posts= Post::where('title','like',"%".$keyword."%")
            ->paginate(6);
            $posts->load('view');
            $posts->load('comments');
            $posts->load('category');
            $posts->withPath('?keyword=' . $keyword);
            $posts->load('category');

        return view('frontend.search-post', compact('posts','postView','postNews','cate','keyword'));
        }
    }
}