<?php

namespace App\Modules\User\Exports;

use App\Modules\Authentication\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromCollection,WithHeadings,WithMapping
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'ID',
            'Name',
            'Email',
            'Phone',
            'Role',
            'Created At',
        ];
    }
    public function map($data): array
    {
         return[
            $data->id,
            $data->name,
            $data->email,
            $data->phone,
            $data->current_role,
            $data->created_at->diffForHumans(),
         ];
    }
    public function collection()
    {
        return User::with('roles')->get();
    }
}
