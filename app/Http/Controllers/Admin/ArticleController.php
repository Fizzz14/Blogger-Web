<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Exports\Admin\ArticlesExport;
use App\Imports\ArticlesImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ArticleController extends Controller
{
    /**
     * Display a listing of the articles.
     */
    public function index()
    {
        $articles = Article::with(['user', 'category'])->latest()->get();
        $categories = Category::all();
        return view('admin.articles.index', compact('articles', 'categories'));
    }

    /**
     * Show the form for creating a new article.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($request->title) . '-' . uniqid();

        if ($request->status === 'published') {
            $data['published_at'] = now();
        }

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')
            ->with('success', $request->status === 'published' ? 'Article published!' : 'Article saved as draft!');
    }

    /**
     * Display the specified article.
     */
    public function show(Article $article)
    {
        $article->increment('view_count');
        $article->load(['user', 'category', 'comments.user']);
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified article.
     */
    public function edit(Article $article)
    {
        $categories = Category::all();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title) . '-' . uniqid();

        if ($request->status === 'published' && !$article->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('featured_image')) {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article updated successfully!');
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')
            ->with('success', 'Article moved to trash.');
    }

    /**
     * Display a listing of the trashed articles.
     */
    public function trash()
    {
        $articles = Article::onlyTrashed()->with(['user', 'category'])->latest()->get();
        return view('admin.articles.trash', compact('articles'));
    }

    /**
     * Restore the specified article from trash.
     */
    public function restore($id)
    {
        $article = Article::withTrashed()->findOrFail($id);
        $article->restore();
        return redirect()->route('admin.articles.trash')->with('success', 'Article restored.');
    }

    /**
     * Permanently delete the specified article from storage.
     */
    public function forceDelete($id)
    {
        $article = Article::withTrashed()->findOrFail($id);
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }
        $article->forceDelete();
        return redirect()->route('admin.articles.trash')->with('success', 'Article permanently deleted.');
    }

    /**
     * Export articles to Excel.
     */
    public function export()
    {
        try {
            return Excel::download(new ArticlesExport, 'articles_' . date('Y-m-d') . '.xlsx');
        } catch (\Exception $e) {
            return redirect()->route('admin.articles.index')->with('error', 'Export error: ' . $e->getMessage());
        }
    }

    /**
     * Import articles from Excel.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new ArticlesImport, $request->file('file'));
            return redirect()->route('admin.articles.index')->with('success', 'Articles imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.articles.index')->with('error', 'Error importing articles: ' . $e->getMessage());
        }
    }
}
