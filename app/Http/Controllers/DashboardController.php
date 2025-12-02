<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Jika request dari welcome page, langsung render
        if ($request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json(['authenticated' => Auth::check()]);
        }

        $user = Auth::user();

        // Redirect berdasarkan role
        if ($user->isAdmin() || $user->isStaff()) {
            // Tampilkan dashboard admin/staff
            return $this->adminDashboard();
        } else {
            // Redirect ke reader dashboard untuk user biasa
            return redirect()->route('reader.dashboard');
        }
    }

    private function adminDashboard()
    {
        $user = Auth::user();

        // Basic stats for admin/staff
        $stats = [
            'total_articles' => Article::count(),
            'published_articles' => Article::where('status', 'published')->count(),
            'draft_articles' => Article::where('status', 'draft')->count(),
            'total_categories' => Category::count(),
        ];

        // Admin-only stats
        if ($user->isAdmin()) {
            $stats['total_users'] = User::where('role', 'user')->count();
            $stats['total_staff'] = User::where('role', 'staff')->count();
            $stats['total_comments'] = Comment::count();
        }

        // Recent articles
        $recentArticles = Article::with(['user', 'category'])
            ->latest()
            ->take(5)
            ->get();

        // Popular articles (most viewed)
        $popularArticles = Article::published()
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get();

        // Use different view based on user role
        if ($user->isAdmin()) {
            return view('admin.dashboard', compact('stats', 'recentArticles', 'popularArticles', 'user'));
        } else {
            // Add comments stats for staff
            $stats['total_comments'] = Comment::count();
            $stats['pending_comments'] = Comment::where('is_approved', false)->count();
            return view('staff.dashboard', compact('stats', 'recentArticles', 'popularArticles', 'user'));
        }
    }
}
