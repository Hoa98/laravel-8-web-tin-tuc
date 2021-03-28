<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('backend.layouts.sidebar', function ($view) {
            $menus = [
                [
                    "url" => route('admin'),
                    'text' => "Tổng quan",
                    "hasChild" => false,
                    "icon" => "nav-icon fas fa-tachometer-alt"
                ],
                [
                    "text" => "Danh mục",
                    "hasChild" => true,
                    "icon" => "nav-icon fas fa-th",
                    "childs" => [
                        [
                            "text" => "Danh sách",
                            "url" => route('cate.index')
                        ],
                        [
                            "text" => "Tạo mới",
                            "url" => route('cate.add')
                        ],
                        [
                            "text" => "Nhập\xuất dữ liệu",
                            "url" => route('cate.importView')
                        ]
                    ]
                ],
                [
                    "text" => "Bài viết",
                    "hasChild" => true,
                    "icon" => "nav-icon fas fa-table",
                    "childs" => [
                        [
                            "text" => "Danh sách",
                            "url" => route('post.index')
                        ],
                        [
                            "text" => "Tạo mới",
                            "url" => route('post.add')
                        ],
                        [
                            "text" => "Nhập\xuất dữ liệu",
                            "url" => route('post.importView')
                        ]
                    ]
                        ],
                [
                    "text" => "Người dùng",
                    "hasChild" => true,
                    "icon" => "nav-icon fas fa-user",
                    "childs" => [
                        [
                            "text" => "Danh sách",
                            "url" => route('user.index')
                        ],
                        [
                            "text" => "Tạo mới",
                            "url" => route('user.add')
                        ],
                        [
                            "text" => "Nhập\xuất dữ liệu",
                            "url" => route('user.importView')
                        ]
                    ]
                        ],
                [
                    "text" => "Bình luận",
                    "hasChild" => true,
                    "icon" => "nav-icon fas fa-comment",
                    "childs" => [
                        [
                            "text" => "Danh sách",
                            "url" => route('comment.index')
                        ]
                    ]
                ]
            ];
            $view->with('menus', $menus);
        });
    }
}