<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'article_id',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    // Helper Methods
    public static function isLiked($userId, $articleId)
    {
        return self::where('user_id', $userId)
                   ->where('article_id', $articleId)
                   ->exists();
    }
}
