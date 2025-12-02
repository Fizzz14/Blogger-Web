<?php
// app/Exports/UsersExport.php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return User::all();
    }

    public function headings(): array
    {
        return [
            'User ID',
            'Nama',
            'Email',
            'Role',
            'Tanggal Dibuat',
            'Tanggal Diupdate'
        ];
    }

    public function map($user): array
    {
        return [
            $user->user_id,
            $user->name,
            $user->email,
            $user->role,
            $user->created_at->format('d-m-Y H:i'),
            $user->updated_at->format('d-m-Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => '3498DB']
                ]
            ],

            'A' => ['width' => 10],
            'B' => ['width' => 25],
            'C' => ['width' => 30],
            'D' => ['width' => 15],
            'E' => ['width' => 20],
            'F' => ['width' => 20],
        ];
    }
}
