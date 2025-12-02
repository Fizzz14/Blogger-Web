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
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CommentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ToModel, WithValidation
{
    public function collection()
    {
        return Comment::with(['user', 'article'])->get();
    }

    public function headings(): array
    {
        return [
            'Comment ID',
            'Komentar',
            'Artikel',
            'User',
            'Tanggal Komentar',
            'Like',
            'Tanggal Dibuat'
        ];
    }

    public function map($comment): array
    {
        return [
            $comment->comment_id,
            strip_tags($comment->content),
            $comment->article->title ?? 'Artikel dihapus',
            $comment->user->name ?? 'User dihapus',
            $comment->date->format('d-m-Y H:i'),
            $comment->like ? 'Yes' : 'No',
            $comment->created_at->format('d-m-Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => 'E74C3C']
                ]
            ],

            'A' => ['width' => 12],
            'B' => ['width' => 50],
            'C' => ['width' => 30],
            'D' => ['width' => 20],
            'E' => ['width' => 20],
            'F' => ['width' => 10],
            'G' => ['width' => 20],
        ];
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
}
