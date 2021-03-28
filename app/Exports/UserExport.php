<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class UserExport implements FromCollection,WithHeadings
{
    public function headings():array    
    {
        return [
            'id',
            'name',
            'email',
            'email_verified_at',
            'password',
            'avatar',
            'role',
            'created_at',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return User::all();
          $users = User::all();
        foreach ($users as $row) {
            $user[] = array(
                '0' => $row->id,
                '1' => $row->name,
                '2' => $row->email,
                '3' => $row->email_verified_at,
                '4' => $row->password,
                '5' => url($row->avatar),
                '6' => $row->role,
                '7' => $row->created_at,
            );
        }

        return (collect($user));
    }
}