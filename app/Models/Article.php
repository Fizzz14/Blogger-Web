<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Article extends Model
{
    use HasFactory, SoftDeletes;

        protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'published_at',
        'status',
        'view_count',
        'like_count',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Relationships

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'article_id');
    }

    public function bookmarkedByUsers()
    {
        return $this->belongsToMany(User::class, 'article_user_bookmarks')
                    ->withTimestamps();
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'article_user_likes')
                    ->withTimestamps();
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    // Helper Methods

    public function getReadingTime()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        return ceil($wordCount / 200); // 200 words per minute
    }

    public function isPublished()
    {
        return $this->status === 'published' && $this->published_at <= now();
    }
}
