<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;
    protected $table = "posts";
    
    protected $fillable = [
        'title', 'post_url', 'content', 'cate_id',
        'short_desc', 'image','author'
    ];
   
    public function category()
    {
        return $this->belongsTo(Category::class, 'cate_id');
    }
    
    public function comments(){
        return $this->hasMany(Comment::class,'post_id');
    }
    public function view(){
        return $this->hasMany(View::class,'post_id');
    }
    
}