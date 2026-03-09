<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\helper\HelperController;
use App\Models\BlogCategory;
use App\Models\BlogCategoryTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yajra\DataTables\Facades\DataTables;

class BlogCategoryController extends BackendController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BlogCategory::with('translation')->orderByDesc('id');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function ($row) {
                    return $row->translation->title ?? '---';
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox" class="custom-control-input status-switch" 
                                       id="status_' . $row->id . '" 
                                       data-id="' . $row->id . '"
                                       ' . $checked . '>
                                <label class="custom-control-label" for="status_' . $row->id . '"></label>
                            </div>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">
                                <a href="' . route('admin.blog_categories.edit', $row->id) . '" class="btn btn-sm btn-warning">
                                    <i data-feather="edit"></i>
                                </a>
                                <form action="' . route('admin.blog_categories.destroy', $row->id) . '" method="POST" class="d-inline delete-form">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-sm btn-danger confirm-delete">
                                        <i data-feather="trash"></i>
                                    </button>
                                </form>
                            </div>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('dashboard.admin.blog_categories.index');
    }

    public function create()
    {
        return view('dashboard.admin.blog_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $category = BlogCategory::create([
            'view_index' => $request->view_index ?? 0,
            'status' => $request->status,
        ]);

        BlogCategoryTranslation::create([
            'blog_category_id' => $category->id,
            'title' => $request->title,
            'slug' => HelperController::make_slug($request->slug ?? $request->title),
            'description' => $request->description,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'lang_id' => app()->getLocale(),
        ]);

        alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));
        return redirect()->route('admin.blog_categories.index');
    }

    public function edit(BlogCategory $blog_category)
    {
        $category = $blog_category->load('translation');
        return view('dashboard.admin.blog_categories.edit', compact('category'));
    }

    public function update(Request $request, BlogCategory $blog_category)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $blog_category->update([
            'view_index' => $request->view_index ?? 0,
            'status' => $request->status,
        ]);

        $translation = BlogCategoryTranslation::updateOrCreate(
            ['blog_category_id' => $blog_category->id, 'lang_id' => app()->getLocale()],
            [
                'title' => $request->title,
                'slug' => HelperController::make_slug($request->slug ?? $request->title),
                'description' => $request->description,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
            ]
        );

        alert()->success(trans_db('dashboard.updated'), trans_db('dashboard.congratulation'));
        return redirect()->route('admin.blog_categories.index');
    }

    public function destroy(BlogCategory $blog_category)
    {
        $blog_category->delete();
        alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.congratulation'));
        return redirect()->route('admin.blog_categories.index');
    }

    public function change_status(Request $request)
    {
        $category = BlogCategory::find($request->id);
        $category->update(['status' => $request->status]);
        return response()->json(['data' => 'success']);
    }
}
