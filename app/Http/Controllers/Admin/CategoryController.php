<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Exports\CategoriesExport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('articles')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'color' => 'required|string|max:7',
            'description' => 'nullable|string|max:500',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'color' => $request->color,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'color' => 'required|string|max:7',
            'description' => 'nullable|string|max:500',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'color' => $request->color,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        if ($category->articles()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category with articles.');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }

    public function export()
    {
        try {
            return Excel::download(new CategoriesExport, 'categories_' . date('Y-m-d') . '.xlsx');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')->with('error', 'Export error: ' . $e->getMessage());
        }
    }


}
