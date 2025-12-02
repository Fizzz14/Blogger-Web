<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ArticlesDataTableController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Article::with(['user', 'category']);
            
            // Apply search filter
            if ($request->search) {
                $data->where(function($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->search . '%')
                          ->orWhere('content', 'like', '%' . $request->search . '%')
                          ->orWhere('excerpt', 'like', '%' . $request->search . '%');
                });
            }
            
            // Apply status filter
            if ($request->status) {
                $data->where('status', $request->status);
            }
            
            // Apply category filter
            if ($request->category) {
                $data->where('category_id', $request->category);
            }
            
            $data->latest();

            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('title', function($row) {
                    return '<strong>' . $row->title . '</strong>';
                })
                ->addColumn('author', function($row) {
                    return $row->user ? $row->user->name : 'Unknown';
                })
                ->addColumn('category', function($row) {
                    return $row->category ? 
                        '<span class="badge" style="background-color: ' . $row->category->color . ';">' . $row->category->name . '</span>' : 
                        '<span class="text-muted">No Category</span>';
                })
                ->addColumn('status', function($row) {
                    $statusClass = $row->status === 'published' ? 'bg-success' : 'bg-secondary';
                    return '<span class="badge ' . $statusClass . '">' . ucfirst($row->status) . '</span>';
                })
                ->addColumn('views', function($row) {
                    return '<span class="badge bg-info">' . number_format($row->view_count) . '</span>';
                })
                ->addColumn('likes', function($row) {
                    return '<span class="badge bg-danger">' . number_format($row->like_count) . '</span>';
                })
                ->addColumn('created_at', function($row) {
                    return $row->created_at->format('M d, Y');
                })
                ->addColumn('action', function($row) {
                    $btn = '<div class="btn-group" role="group">
                            <a href="' . route('articles.show', $row->id) . '" class="btn btn-sm btn-outline-info" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="' . route('articles.edit', $row->id) . '" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>';

                    if ($row->trashed()) {
                        $btn .= '<form action="' . route('articles.restore', $row->id) . '" method="POST" class="d-inline">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-sm btn-outline-warning" title="Restore" onclick="return confirm('Are you sure you want to restore this article?')">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </form>
                            <form action="' . route('articles.forceDelete', $row->id) . '" method="POST" class="d-inline">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Permanently" onclick="return confirm('Are you sure you want to permanently delete this article?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>';
                    } else {
                        $btn .= '<form action="' . route('articles.destroy', $row->id) . '" method="POST" class="d-inline">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Move to Trash" onclick="return confirm('Are you sure you want to move this article to trash?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>';
                    }

                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['title', 'category', 'status', 'views', 'likes', 'action'])
                ->make(true);
        }

        $categories = \App\Models\Category::all();
        return view('staff.articles.datatables', compact('categories'));
    }
}
