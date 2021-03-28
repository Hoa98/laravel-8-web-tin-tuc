<?php

namespace App\Scraper;

use App\Models\Category;
use App\Models\Post;
use Exception;
use Goutte\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class Dantri
{

    protected $collections = [
        [
            'slug' => 'su-kien.htm',
            'name' => 'Sự kiện'
        ],
        [
            'slug' => 'xa-hoi.htm',
            'name' => 'Xã hội'
        ],
        [
            'slug' => 'the-gioi.htm',
            'name' => 'Thế giới'
        ],
        [
            'slug' => 'du-lich.htm',
            'name' => 'Du lịch'
        ],
        [
            'slug' => 'kinh-doanh.htm',
            'name' => 'Kinh doanh'
        ],
        // [
        //     'slug' => 'van-hoa.htm',
        //     'name' => 'Văn hoá'
        // ],
        // [
        //     'slug' => 'giai-tri.htm',
        //     'name' => 'Giải trí'
        // ],
        // [
        //     'slug' => 'suc-khoe.htm',
        //     'name' => 'Sức khoẻ'
        // ],
        // [
        //     'slug' => 'phap-luat.htm',
        //     'name' => 'Pháp luật'
        // ],
        // [
        //     'slug' => 'the-thao.htm',
        //     'name' => 'Thể thao'
        // ],
        // [
        //     'slug' => 'lao-dong-viec-lam.htm',
        //     'name' => 'Việc làm'
        // ]
    ];
    
    public function scrape()
    {
        foreach($this->collections as $collection){
            $category = Category::where('cate_url','=',Str::slug($collection['name'],'-'))->first();

            if($category == null){
                $category = new Category();
                $category->name = $collection['name'];
                $category->cate_url = Str::slug($collection['name'],'-');
                $category->save();
            }
            $this->crawler($collection['slug'],$category->id);
        }
        
    }

    public static function crawler($collection,$category)
    {
        $url = 'https://dantri.com.vn/'.$collection;

        $client = new Client();

        $crawler = $client->request('GET', $url);

        // crawler href
        try{
           $link = $crawler->filter('ul.dt-list.dt-list--lg li h3.news-item__title a')->each(
                function (Crawler $node){
                  return  $node->attr('href');
                }
            );
        }catch(Exception $e){
            print_r($e->getMessage());
        }finally{
            foreach($link as $l){
                
                $urlPost = 'https://dantri.com.vn'.$l;
                // print($urlPost);
                self::srapePost($urlPost,$category);
            }
          
        }
        return true;
      
    }
    public static function srapePost($url,$category)
    {
        $client = new Client();

        $crawler = $client->request('GET', $url);

        try {
            $titles = $crawler->filter('h1.dt-news__title')->each(
                function ($node){
                    return $node->text();
                });
                if(isset($titles[0])){
                    $title = $titles[0];
                    $post_url = Str::slug($title,'-');
                }
            $contents= $crawler->filter('.dt-news__body .dt-news__content')->each(
                function ($node){
                    return $node->text();
                });
                if(isset($contents[0])){
                    $content = $contents[0];
                }
            $short_descs= $crawler->filter('.dt-news__body .dt-news__sapo h2')->each(
                function ($node){
                    return $node->text();
                });
                if(isset($short_descs[0])){
                    $short_desc = $short_descs[0];
                }
            $images= $crawler->filter('.dt-news__content .image img')->each(
                function ($node){
                    return $node->attr('src');
                });
                if(isset($images[0])){
                    $nImage = basename($images[0]);
                    $fp = public_path('images/post/').$nImage;
                    file_put_contents( $fp, file_get_contents($images[0]) );
                    $imageName = 'images/post/'.$nImage;
                }
        } catch(Exception $e){
            print_r($e->getMessage());
        }
       if(isset($title) && isset($post_url) && isset($content)&&isset($short_desc) && isset($imageName)){
            
        $post = Post::where('post_url','=',$post_url)->first();

        if($post == null){

            $post = new Post();
            $post->title=$title;
            $post->post_url=$post_url;
            $post->content=$content;
            $post->short_desc=$short_desc;
            $post->image=$imageName;
            $post->cate_id=$category;
            $post->author=Auth::user()->name;
            $post->save();
        }
       }
        return true;
    }
}