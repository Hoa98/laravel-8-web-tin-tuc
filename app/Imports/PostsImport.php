<?php

namespace App\Imports;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PostsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

         return new Post([
            'title' => $row['title'],
            'post_url' => $row['post_url'],
            'cate_id' => $row['cate_id'],
            'content' => $row['content'],
            'short_desc' => $row['short_desc'],
            'image' => $row['image'],
            'author' =>  Auth::user()->name,
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|unique:posts,title',
            'post_url' => 'unique:posts,post_url',
            'cate_id' => 'required',
            'content' => 'required',
            'short_desc' => 'required',
            'image' => 'required',
            'author' => 'required',
        ];
    }

    public function customValidationMessages()
{
    return [
        'title.unique' => 'Tiêu đề bài viết đã tồn tại.',
        'post_url.unique' => 'Đường dẫn bài viết đã tồn tại.',
    ];
}
}