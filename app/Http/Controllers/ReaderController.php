<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReaderController extends Controller
{
   public function dashboard()
{
    $user = Auth::user();

    // Recent articles dari semua kategori
    $recentArticles = Article::with(['user', 'category'])
        ->with(['likedByUsers' => function($query) {
            $query->where('user_id', auth()->id());
        }])
        ->where('status', 'published')
        ->latest()
        ->take(6)
        ->get();

    // Popular articles (most viewed)
    $popularArticles = Article::with(['user', 'category'])
        ->where('status', 'published')
        ->orderBy('view_count', 'desc')
        ->take(5)
        ->get();

    // Articles by category untuk menu horizontal
    $categories = Category::with(['articles' => function($query) {
        $query->where('status', 'published')->latest()->take(3);
    }])->get();

    // User activity stats - perbaiki yang mungkin error
    $userStats = [
        'articles_read' => 0, // placeholder - bisa diisi dengan reading history jika ada
        'comments_made' => $user->comments()->count(),
        'likes_given' => 0, // placeholder untuk likes - relasi likes belum didefinisikan
    ];

    return view('reader.dashboard', compact(
        'recentArticles',
        'popularArticles',
        'categories',
        'userStats'
    ));
}

    public function articles()
    {
        $articles = Article::with(['user', 'category'])
            ->where('status', 'published')
            ->latest()
            ->paginate(12);

        $categories = Category::all();

        return view('reader.articles', compact('articles', 'categories'));
    }

    public function articlesByCategory(Category $category)
    {
        $articles = Article::with(['user', 'category'])
            ->where('category_id', $category->id)
            ->where('status', 'published')
            ->latest()
            ->paginate(12);

        $categories = Category::all();

        return view('reader.articles-category', compact('articles', 'categories', 'category'));
    }

    public function showArticle(Article $article)
    {
        // Only show published articles to regular users
        if ($article->status !== 'published') {
            abort(404);
        }

        $article->increment('view_count');
        $article->load(['user', 'category', 'comments.user']);

        // Related articles
        $relatedArticles = Article::with(['user', 'category'])
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->latest()
            ->take(4)
            ->get();

        return view('reader.article-show', compact('article', 'relatedArticles'));
    }

    public function toggleLike(Article $article)
    {
        if ($article->status !== 'published') {
            if (request()->ajax()) {
                return response()->json(['error' => 'Cannot like unpublished article.'], 403);
            }
            return back()->with('error', 'Cannot like unpublished article.');
        }

        $user = auth()->user();

        // Check if user has already liked this article
        $hasLiked = $user->likes()->where('article_id', $article->id)->exists();

        if ($hasLiked) {
            // Unlike the article
            $user->likes()->detach($article->id);
            $article->decrement('like_count');
            $message = 'Article unliked!';
        } else {
            // Like the article
            $user->likes()->attach($article->id);
            $article->increment('like_count');
            $message = 'Article liked!';
        }

        if (request()->ajax()) {
            // Reload the article to get the updated like count
            $article->refresh();

            // Check if user has liked the article after the toggle
            $isLiked = $user->likes()->where('article_id', $article->id)->exists();

            return response()->json([
                'success' => true,
                'like_count' => $article->like_count,
                'liked' => $isLiked,
                'message' => $message
            ]);
        }

        return back()->with('success', $message);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $articles = Article::with(['user', 'category'])
            ->where('status', 'published')
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%");
            })
            ->latest()
            ->paginate(12);

        $categories = Category::all();

        return view('reader.search', compact('articles', 'categories', 'query'));
    }
}
