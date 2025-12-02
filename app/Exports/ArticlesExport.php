<?php

namespace App\Exports;

use App\Models\Article;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ArticlesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Article::with(['category', 'user'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Judul',
            'Konten',
            'Kategori',
            'Penulis',
            'Status',
            'Jumlah View',
            'Jumlah Like',
            'Tanggal Dibuat',
            'Tanggal Diupdate'
        ];
    }

    public function map($article): array
    {
        return [
            $article->id,
            $article->title,
            strip_tags($article->content), // Hilangkan HTML tags
            $article->category->name ?? '-',
            $article->user->name ?? '-',
            $article->status,
            $article->view_count ?? 0,
            $article->like_count ?? 0,
            $article->created_at->format('d-m-Y H:i'),
            $article->updated_at->format('d-m-Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header row style
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => '3498DB']
                ]
            ],

            // Auto size columns
            'A' => ['width' => 10],
            'B' => ['width' => 30],
            'C' => ['width' => 50],
            'D' => ['width' => 20],
            'E' => ['width' => 20],
            'F' => ['width' => 15],
            'G' => ['width' => 15],
            'H' => ['width' => 15],
            'I' => ['width' => 20],
            'J' => ['width' => 20],
        ];
    }
}
