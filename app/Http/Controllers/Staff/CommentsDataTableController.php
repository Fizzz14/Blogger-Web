<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CommentsDataTableController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Comment::with(['user', 'article']);

            // Apply search filter
            if ($request->search) {
                $data->where(function($query) use ($request) {
                    $query->where('content', 'like', '%' . $request->search . '%')
                          ->orWhereHas('user', function($q) use ($request) {
                              $q->where('name', 'like', '%' . $request->search . '%');
                          })
                          ->orWhereHas('article', function($q) use ($request) {
                              $q->where('title', 'like', '%' . $request->search . '%');
                          });
                });
            }

            // Apply status filter
            if ($request->status !== null && $request->status !== '') {
                $data->where('approved', $request->status);
            }

            // Apply article filter
            if ($request->article) {
                $data->where('article_id', $request->article);
            }

            $data->latest();

            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('content', function($row) {
                    return \Illuminate\Support\Str::limit(strip_tags($row->content), 100);
                })
                ->addColumn('author', function($row) {
                    return $row->user ? $row->user->name : 'Guest';
                })
                ->addColumn('article', function($row) {
                    return $row->article ?
                        '<a href="' . route('articles.show', $row->article->id) . '" target="_blank">' . $row->article->title . '</a>' :
                        '<span class="text-muted">Article Deleted</span>';
                })
                ->addColumn('status', function($row) {
                    $statusClass = $row->is_approved ? 'bg-success' : 'bg-warning';
                    $statusText = $row->is_approved ? 'Approved' : 'Pending';
                    return '<span class="badge ' . $statusClass . '">' . $statusText . '</span>';
                })
                ->addColumn('created_at', function($row) {
                    return $row->created_at->format('M d, Y H:i');
                })
                ->addColumn('action', function($row) {
                    $btn = '<div class="btn-group" role="group">
                            <a href="' . route('staff.comments.show', $row->id) . '" class="btn btn-sm btn-outline-info" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="' . route('staff.comments.edit', $row->id) . '" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>';

                    if ($row->is_approved) {
                        $btn .= '<form action="' . route('staff.comments.unapprove', $row->id) . '" method="POST" class="d-inline">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-sm btn-outline-warning" title="Unapprove" onclick="return confirm(\"Are you sure you want to unapprove this comment?\")">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </form>';
                    } else {
                        $btn .= '<form action="' . route('staff.comments.approve', $row->id) . '" method="POST" class="d-inline">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-sm btn-outline-success" title="Approve" onclick="return confirm(\"Are you sure you want to approve this comment?\")">
                                    <i class="bi bi-check-circle"></i>
                                </button>
                            </form>';
                    }

                    $btn .= '<form action="' . route('staff.comments.destroy', $row->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm(\"Are you sure you want to delete this comment?\")">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>';
                    return $btn;
                })
                ->rawColumns(['content', 'article', 'status', 'action'])
                ->make(true);
        }

        $articles = \App\Models\Article::select('id', 'title')->latest()->get();
        return view('staff.comments.datatables', compact('articles'));
    }
}
