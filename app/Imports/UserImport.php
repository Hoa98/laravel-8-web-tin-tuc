<?php

namespace App\Imports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Hash;


class UserImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'email_verified_at' => $row['email_verified_at'],
            'password' => Hash::make($row['password']),
            'avatar' => $row['avatar'],
            'role' => $row['role'],
            'created_at' =>Carbon::now()->toDateTimeString(),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'unique:users,email',
            'role' => 'required',
            'password' => 'required',
        ];
    }

    public function customValidationMessages()
{
    return [
        'email.unique' => 'Email đã tồn tại.',
    ];
}
}