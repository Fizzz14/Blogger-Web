<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'bio',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // TAMBAHKAN INI
    ];

    // Relationships
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function bookmarkedArticles()
    {
        return $this->belongsToMany(Article::class, 'article_user_bookmarks')
                    ->withTimestamps();
    }

    public function likes()
    {
        return $this->belongsToMany(Article::class, 'article_user_likes')
                    ->withTimestamps();
    }

    public function hasLikedArticle(Article $article)
    {
        return $this->likes()->where('article_id', $article->id)->exists();
    }

    // Helper Methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function getAvatarUrl()
    {
        if ($this->avatar) {
            return Storage::url($this->avatar);
        }

        // Default avatar dari Gravatar atau local
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=200";
    }
}
