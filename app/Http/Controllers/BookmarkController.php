<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function toggle(Article $article)
    {
        if ($article->status !== 'published') {
            if (request()->ajax()) {
                return response()->json(['error' => 'Cannot save unpublished article.'], 403);
            }
            return back()->with('error', 'Cannot save unpublished article.');
        }

        $user = Auth::user();
        $isBookmarked = $user->bookmarkedArticles()->where('article_id', $article->id)->exists();

        if ($isBookmarked) {
            // Remove bookmark
            $user->bookmarkedArticles()->detach($article->id);
            $message = 'Article removed from bookmarks.';
            $bookmarked = false;
        } else {
            // Add bookmark
            $user->bookmarkedArticles()->attach($article->id);
            $message = 'Article bookmarked successfully.';
            $bookmarked = true;
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'bookmarked' => $bookmarked,
                'message' => $message
            ]);
        }

        return back()->with('success', $message);
    }

    public function index()
    {
        $user = Auth::user();
        $bookmarkedArticles = $user->bookmarkedArticles()
            ->with(['user', 'category'])
            ->latest()
            ->paginate(12);

        return view('reader.bookmarks', compact('bookmarkedArticles'));
    }
}