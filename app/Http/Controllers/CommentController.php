<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        Comment::create([
            'article_id' => $article->id,
            'user_id' => Auth::id(),
            'parent_id' => $request->parent_id,
            'content' => $request->content,
        ]);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Comment added successfully.');
    }

    public function destroy(Comment $comment)
    {
        $user = Auth::user();

        // Manual authorization check
        if ($user->id !== $comment->user_id && !$user->isAdmin() && !$user->isStaff()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}
