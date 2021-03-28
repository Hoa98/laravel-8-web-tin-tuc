<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PostExport implements FromCollection,WithHeadings
{
     public function headings():array    
    {
        return [
            'id',
            'title',
            'post_url',
            'cate_id',
            'content',
            'short_desc',
            'image',
            'author',
            'created_at',
        ];
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Post::all();
        $posts = Post::all();
       $posts->load('category');
        foreach ($posts as $row) {
            $post[] = array(
                '0' => $row->id,
                '1' => $row->title,
                '2' => $row->post_url,
                '3' => $row->category->name,
                '4' => $row->content,
                '5' => $row->short_desc,
                '6' => asset($row->image),
                '7' => $row->author,
                '8' => $row->created_at,
            );
        }

        return (collect($post));
    }
}