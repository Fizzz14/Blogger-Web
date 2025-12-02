<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Exports\ArticlesExport;
use Maatwebsite\Excel\Facades\Excel;

class ArticleController extends Controller
{
    // Hanya admin & staff yang bisa akses
    public function index()
    {
        $articles = Article::with(['user', 'category'])->latest()->get();
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

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

        return redirect()->route('articles.index')
            ->with('success', $request->status === 'published' ? 'Article published!' : 'Article saved as draft!');
    }

    public function show(Article $article)
    {
        $article->increment('view_count');
        $article->load(['user', 'category', 'comments.user']);
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

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

        return redirect()->route('articles.index')
            ->with('success', 'Article updated successfully!');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')
            ->with('success', 'Article moved to trash.');
    }

    public function trash()
    {
        $articles = Article::onlyTrashed()->with(['user', 'category'])->latest()->get();
        return view('articles.trash', compact('articles'));
    }

    public function restore($id)
    {
        $article = Article::withTrashed()->findOrFail($id);
        $article->restore();
        return redirect()->route('articles.trash')->with('success', 'Article restored.');
    }

    public function forceDelete($id)
    {
        $article = Article::withTrashed()->findOrFail($id);
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }
        $article->forceDelete();
        return redirect()->route('articles.trash')->with('success', 'Article permanently deleted.');
    }

    public function toggleLike(Article $article)
    {
        $article->increment('like_count');
        return back()->with('success', 'Article liked!');
    }

  public function export()
    {
        $filename = 'articles-' . date('Y-m-d-H-i-s') . '.xlsx';
        return Excel::download(new ArticlesExport(), $filename);
    }
}
