<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Exports\Admin\CommentsExport;
use App\Imports\CommentsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CommentController extends Controller
{
    /**
     * Display a listing of the comments.
     */
    public function index()
    {
        $comments = Comment::with(['user', 'article', 'parent'])->latest()->get();
        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Display the specified comment.
     */
    public function show(Comment $comment)
    {
        $comment->load(['user', 'article', 'replies.user', 'parent']);
        return view('admin.comments.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified comment.
     */
    public function edit(Comment $comment)
    {
        $comment->load(['user', 'article', 'parent']);
        return view('admin.comments.edit', compact('comment'));
    }

    /**
     * Update the specified comment in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'is_approved' => 'required|boolean'
        ]);

        $comment->update([
            'content' => $request->content,
            'is_approved' => $request->is_approved
        ]);

        return redirect()->route('admin.comments.index')
            ->with('success', 'Comment updated successfully.');
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.comments.index')
            ->with('success', 'Comment deleted successfully.');
    }

    /**
     * Approve the specified comment.
     */
    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => true]);
        return back()->with('success', 'Comment approved.');
    }

    /**
     * Unapprove the specified comment.
     */
    public function unapprove(Comment $comment)
    {
        $comment->update(['is_approved' => false]);
        return back()->with('success', 'Comment unapproved.');
    }

    /**
     * Export comments to Excel.
     */
    public function export()
    {
        try {
            return Excel::download(new CommentsExport, 'comments_' . date('Y-m-d') . '.xlsx');
        } catch (\Exception $e) {
            return redirect()->route('admin.comments.index')->with('error', 'Export error: ' . $e->getMessage());
        }
    }

    /**
     * Import comments from Excel.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new CommentsImport, $request->file('file'));
            return redirect()->route('admin.comments.index')->with('success', 'Comments imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.comments.index')->with('error', 'Error importing comments: ' . $e->getMessage());
        }
    }
}
