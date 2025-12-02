<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Exports\CommentsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class CommentManagementController extends Controller
{
    public function index()
    {
        $comments = Comment::with(['user', 'article', 'parent'])->latest()->get();

        // Use different view based on user role
        if (Auth::user()->isAdmin()) {
            return view('admin.comments.index', compact('comments'));
        } else {
            return view('staff.comments.index', compact('comments'));
        }
    }

    public function show(Comment $comment)
    {
        $comment->load(['user', 'article', 'replies.user', 'parent']);

        // Use different view based on user role
        if (Auth::user()->isAdmin()) {
            return view('admin.comments.show', compact('comment'));
        } else {
            return view('staff.comments.show', compact('comment'));
        }
    }

    public function edit(Comment $comment)
    {
        $comment->load(['user', 'article', 'parent']);

        // Use different view based on user role
        if (Auth::user()->isAdmin()) {
            return view('admin.comments.edit', compact('comment'));
        } else {
            return view('staff.comments.edit', compact('comment'));
        }
    }

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

        $route = Auth::user()->isAdmin() ? 'admin.comments.index' : 'staff.comments.index';
        return redirect()->route($route)
            ->with('success', 'Comment updated successfully.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        $route = Auth::user()->isAdmin() ? 'admin.comments.index' : 'staff.comments.index';
        return redirect()->route($route)
            ->with('success', 'Comment deleted successfully.');
    }

    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => true]);
        $route = Auth::user()->isAdmin() ? 'admin.comments.index' : 'staff.comments.index';
        return redirect()->route($route)->with('success', 'Comment approved.');
    }

    public function unapprove(Comment $comment)
    {
        $comment->update(['is_approved' => false]);
        $route = Auth::user()->isAdmin() ? 'admin.comments.index' : 'staff.comments.index';
        return redirect()->route($route)->with('success', 'Comment unapproved.');
    }

     public function export()
    {
        $filename = 'comments-' . date('Y-m-d-H-i-s') . '.xlsx';
        return Excel::download(new CommentsExport(), $filename);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new CommentsExport(), $request->file('file'));

            $route = Auth::user()->isAdmin() ? 'admin.comments.index' : 'staff.comments.index';
            return redirect()->route($route)->with('success', 'Comments imported successfully.');
        } catch (\Exception $e) {
            $route = Auth::user()->isAdmin() ? 'admin.comments.index' : 'staff.comments.index';
            return redirect()->route($route)->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
