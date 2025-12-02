<?php
// app/Exports/CategoriesExport.php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CategoriesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Category::withCount('articles')->get();
    }

    public function headings(): array
    {
        return [
            'Category ID',
            'Nama Kategori',
            'Jumlah Artikel',
            'Tanggal Dibuat'
        ];
    }

    public function map($category): array
    {
        return [
            $category->category_id,
            $category->name_category,
            $category->articles_count,
            $category->created_at->format('d-m-Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => '9B59B6']
                ]
            ],

            'A' => ['width' => 12],
            'B' => ['width' => 25],
            'C' => ['width' => 15],
            'D' => ['width' => 20],
        ];
    }
}
