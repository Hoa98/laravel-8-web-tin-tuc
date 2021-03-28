<?php

namespace App\Imports;

use App\Models\Category;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CategoryImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Category([
            'name' => $row['name'],
            'cate_url' => $row['cate_url'],
            'logo' => $row['logo'],
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);
    }
    public function rules(): array
    {
        return [
            'name' => 'unique:categories,name',
            'cate_url' => 'unique:categories,cate_url',
        ];
    }

    public function customValidationMessages()
{
    return [
        'name.unique' => 'Danh mục đã tồn tại.',
        'cate_url.unique' => 'Đường dẫn danh mục đã tồn tại.',
    ];
}
}