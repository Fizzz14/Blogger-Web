<?php
// app/Exports/CommentsExport.php

namespace App\Exports;

use App\Models\Comment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CommentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ToModel, WithValidation, WithColumnWidths, WithEvents
{
    public function collection()
    {
        return Comment::with(['user', 'article'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Komentar',
            'Artikel',
            'Penulis',
            'Status',
            'Tanggal Komentar',
            'Tanggal Dibuat'
        ];
    }

    public function map($comment): array
    {
        return [
            $comment->id,
            strip_tags(str_replace(["\r\n", "\n", "\r"], " ", $comment->content)),
            $comment->article->title ?? 'Artikel dihapus',
            $comment->user->name ?? 'User dihapus',
            $comment->is_approved ? 'Approved' : 'Pending',
            $comment->created_at->format('d M Y H:i'),
            $comment->updated_at->format('d M Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Set style for header row
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => '0275d8']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ]
        ]);
        
        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(8);   // ID
        $sheet->getColumnDimension('B')->setWidth(60);  // Komentar
        $sheet->getColumnDimension('C')->setWidth(30);  // Artikel
        $sheet->getColumnDimension('D')->setWidth(20);  // Penulis
        $sheet->getColumnDimension('E')->setWidth(12);  // Status
        $sheet->getColumnDimension('F')->setWidth(18);  // Tanggal Komentar
        $sheet->getColumnDimension('G')->setWidth(18);  // Tanggal Dibuat
        
        // Set text wrap for content column
        $sheet->getStyle('B:B')->getAlignment()->setWrapText(true);
        
        // Set row height for all rows
        $sheet->getDefaultRowDimension()->setRowHeight(20);
        
        // Set border for all cells
        $sheet->getStyle('A1:G' . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);
        
        // Set alternating row colors
        $sheet->getStyle('A2:G' . $sheet->getHighestRow())->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'F8F9FA']
            ]
        ]);
        
        return [];
    }

    public function model(array $row)
    {
        // Skip header row
        if ($row[0] === 'Comment ID') {
            return null;
        }

        // Find or create user
        $user = \App\Models\User::where('name', $row[3])->first();
        if (!$user) {
            $user = \App\Models\User::create([
                'name' => $row[3],
                'email' => 'imported_' . uniqid() . '@example.com',
                'password' => bcrypt('password'),
                'role' => 'reader',
            ]);
        }

        // Find article by title
        $article = \App\Models\Article::where('title', $row[2])->first();
        if (!$article) {
            // Create a default article if not found
            $category = \App\Models\Category::first();
            if (!$category) {
                $category = \App\Models\Category::create([
                    'name' => 'General',
                    'slug' => 'general',
                    'color' => '#000000',
                ]);
            }
            $article = \App\Models\Article::create([
                'title' => $row[2],
                'slug' => \Illuminate\Support\Str::slug($row[2]),
                'content' => 'Imported article',
                'status' => 'published',
                'user_id' => $user->id,
                'category_id' => $category->id,
            ]);
        }

        return new Comment([
            'content' => $row[1],
            'user_id' => $user->id,
            'article_id' => $article->id,
            'is_approved' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function rules(): array
    {
        return [
            '1' => 'required|string|max:1000', // content
            '2' => 'required|string', // article title
            '3' => 'required|string', // user name
        ];
    }
    
    public function columnWidths(): array
    {
        return [
            'A' => 8,   // ID
            'B' => 60,  // Komentar
            'C' => 30,  // Artikel
            'D' => 20,  // Penulis
            'E' => 12,  // Status
            'F' => 18,  // Tanggal Komentar
            'G' => 18,  // Tanggal Dibuat
        ];
    }
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Set auto filter for the entire table
                $sheet->setAutoFilter($sheet->calculateWorksheetDimension());
                
                // Freeze the first row
                $sheet->freezePane('A2');
                
                // Set title for the sheet
                $sheet->setTitle('Comments Report');
                
                // Set page setup
                $sheet->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
                    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                    
                // Set margins
                $sheet->getPageMargins()->setTop(0.5);
                $sheet->getPageMargins()->setRight(0.5);
                $sheet->getPageMargins()->setLeft(0.5);
                $sheet->getPageMargins()->setBottom(0.5);
                
                // Set header for printing
                $sheet->getHeaderFooter()->setOddHeader('&C&BComments Report - &D');
                $sheet->getHeaderFooter()->setOddFooter('&CPage &P of &N');
            },
        ];
    }
}
