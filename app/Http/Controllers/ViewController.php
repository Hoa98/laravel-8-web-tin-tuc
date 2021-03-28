<?php

namespace App\Http\Controllers;

use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewController extends Controller
{
    public function handleChart()
    {
        $comments = DB::table('comments')->count();
        $blogs = DB::table('posts')->count();
        $users = DB::table('users')->count();
        $categories = DB::table('categories')->count();

        //Tháng trong năm
        $views = View::select(DB::raw("SUM(views) as sum"))
                    ->whereYear('created_date', date('Y'))
                    ->groupBy(DB::raw("Month(created_date)"))
                    ->pluck('sum');
        
        $months = View::select(DB::raw("Month(created_date) as month"))
            ->whereYear('created_date', date('Y'))
            ->groupBy(DB::raw("Month(created_date)"))
            ->pluck('month');
        
        $datas = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach($months as $index => $month)
        {
            $datas[$month-1] = (int)$views[$index];
        }
        // ngày trong tháng
        $viewsDay = View::select(DB::raw("SUM(views) as sum"))
                    ->whereYear('created_date', date('Y'))
                    ->whereMonth('created_date', date('m'))
                    ->groupBy(DB::raw("Day(created_date)"))
                    ->pluck('sum');
        
        $days = View::select(DB::raw("Day(created_date) as day"))
                ->whereYear('created_date', date('Y'))
                ->whereMonth('created_date', date('m'))
                ->groupBy(DB::raw("Day(created_date)"))
                ->pluck('day');
        $dataDay = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        foreach($days as $index => $day)
        {
            $dataDay[$day-1] = (int)$viewsDay[$index];
        }

        // năm
        $viewsYear = View::select(DB::raw("SUM(views) as sum"))
                ->groupBy(DB::raw("YEAR(created_date)"))
                ->pluck('sum');

        $years = View::select(DB::raw("Year(created_date) as year"))
                ->groupBy(DB::raw("year(created_date)"))
                ->pluck('year');
        $cateYear=[];
        $dataYear=[];
        foreach($viewsYear as $index => $y)
        {
            $dataYear[$index] = (int)$viewsYear[$index];
        }
        foreach($years as $index => $year)
        {
            $cateYear[$index] = 'Năm '.$years[$index];
        }
        return view('backend.index', compact('datas','dataDay','cateYear','dataYear','comments','blogs','users','categories'));
    }
}