<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoriesDataTableController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::withCount('articles');
            
            // Apply search filter
            if ($request->search) {
                $data->where(function($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%')
                          ->orWhere('description', 'like', '%' . $request->search . '%');
                });
            }
            
            // Apply articles filter
            if ($request->articles === 'has_articles') {
                $data->whereHas('articles');
            } elseif ($request->articles === 'no_articles') {
                $data->doesntHave('articles');
            }
            
            // Apply color filter
            if ($request->color) {
                $data->where('color', $request->color);
            }
            
            $data->latest();

            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('name', function($row) {
                    return '<span class="badge" style="background-color: ' . $row->color . ';">' . $row->name . '</span>';
                })
                ->addColumn('color', function($row) {
                    return '<span class="d-inline-block" style="width: 20px; height: 20px; background-color: ' . $row->color . '; border-radius: 4px;"></span>
                            <code class="ms-2">' . $row->color . '</code>';
                })
                ->addColumn('articles_count', function($row) {
                    return '<span class="badge bg-info">' . $row->articles_count . '</span>';
                })
                ->addColumn('description', function($row) {
                    return \Illuminate\Support\Str::limit($row->description, 50);
                })
                ->addColumn('action', function($row) {
                    $btn = '<div class="btn-group" role="group">
                            <a href="' . route('categories.edit', $row->id) . '" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="' . route('categories.destroy', $row->id) . '" method="POST" class="d-inline">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm(\'Are you sure you want to delete this category?\')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>';
                    return $btn;
                })
                ->rawColumns(['name', 'color', 'articles_count', 'action'])
                ->make(true);
        }

        $colors = \App\Models\Category::distinct()->pluck('color')->toArray();
        return view('staff.categories.datatables', compact('colors'));
    }
}
