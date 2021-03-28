<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $fillable = ['name','cate_url','logo'];
    
    public function posts(){
        return $this->hasMany(Post::class,'cate_id');
    }
}