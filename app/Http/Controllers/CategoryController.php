<?php

namespace App\Http\Controllers;

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
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
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

        return redirect()->route('categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
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

        return redirect()->route('categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        if ($category->articles()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Cannot delete category with articles.');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted.');
    }

    public function show(Category $category)
    {
        return response()->json(['data' => $category]);
    }
  public function export()
    {
        $filename = 'categories-' . date('Y-m-d-H-i-s') . '.xlsx';
        return Excel::download(new CategoriesExport(), $filename);
    }

}
