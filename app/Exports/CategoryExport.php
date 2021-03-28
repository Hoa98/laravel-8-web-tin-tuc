<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class CategoryExport implements FromCollection,WithHeadings
{
    public function headings():array    
    {
        return [
            'id',
            'name',
            'cate_url',
            'logo',
            'created_at',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $cates= Category::all();
        foreach ($cates as $row) {
            $cate[] = array(
                '0' => $row->id,
                '1' => $row->name,
                '2' => $row->cate_url,
                '3' => url($row->logo),
                '4' => $row->created_at,
            );
        }

        return (collect($cate));
    }
}