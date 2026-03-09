<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\helper\HelperController;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends BackendController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::with(['BlogTranslation', 'category.translation'])->orderByDesc('id');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function ($row) {
                    return $row->BlogTranslation->title ?? '---';
                })
                ->addColumn('category', function ($row) {
                    return $row->category->translation->title ?? trans_db('dashboard.No Category');
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
                                <a href="' . route('admin.blogs.edit', $row->id) . '" class="btn btn-sm btn-warning">
                                    <i data-feather="edit"></i>
                                </a>
                                <a href="' . route('admin.blogs.addTrans', $row->id) . '" class="btn btn-sm btn-info" title="' . trans_db('dashboard.Translations') . '">
                                    <i data-feather="globe"></i>
                                </a>
                                <form action="' . route('admin.blogs.delete', $row->id) . '" method="POST" class="d-inline delete-form">
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

        return view('dashboard.admin.blogs.index');
    }

    public function create()
    {
        $categories = BlogCategory::with('translation')->where('status', 1)->get();
        return view('dashboard.admin.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image_name = null;
        if ($request->hasFile('image')) {
            $data = self::imageUpload($request);
            $image_name = $data['image'];
        }

        $blog = Blog::create([
            'blog_category_id' => $request->blog_category_id,
            'view_index' => $request->view_index ?? 0,
            'status' => $request->status ?? 1,
        ]);

        BlogTranslation::create([
            'blog_id' => $blog->id,
            'title' => $request->title,
            'slug' => HelperController::make_slug($request->slug ?? $request->title),
            'description' => $request->description,
            'tags' => $request->tags,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'image' => $image_name,
            'Author' => Auth::id(),
            'lang_id' => app()->getLocale(),
        ]);

        alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));
        return redirect()->route('admin.blogs.index');
    }

    public function edit($id)
    {
        $blog = Blog::with('BlogTranslation')->findOrFail($id);
        $categories = BlogCategory::with('translation')->where('status', 1)->get();
        return view('dashboard.admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
        ]);

        if ($request->hasFile('image')) {
            $data = self::imageUpload($request);
            $image_name = $data['image'];
        } else {
            $image_name = $blog->BlogTranslation->image;
        }

        $blog->update([
            'blog_category_id' => $request->blog_category_id,
            'view_index' => $request->view_index ?? 0,
            'status' => $request->status ?? 1,
        ]);

        BlogTranslation::updateOrCreate(
            ['blog_id' => $blog->id, 'lang_id' => app()->getLocale()],
            [
                'title' => $request->title,
                'slug' => HelperController::make_slug($request->slug ?? $request->title),
                'description' => $request->description,
                'tags' => $request->tags,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
                'image' => $image_name,
                'Author' => Auth::id(),
            ]
        );

        alert()->success(trans_db('dashboard.updated'), trans_db('dashboard.congratulation'));
        return redirect()->route('admin.blogs.index');
    }

    public function delete($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.congratulation'));
        return redirect()->route('admin.blogs.index');
    }

    public function change_status(Request $request)
    {
        $blog = Blog::find($request->blog_id);
        $blog->update(['status' => $request->status]);
        return response()->json(['data' => 'success']);
    }

    public function addTrans($id)
    {
        $blog = Blog::findOrFail($id);
        return view('dashboard.admin.blogs.trans', compact('blog'));
    }

    public function storeTrans(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        BlogTranslation::create([
            'blog_id' => $blog->id,
            'title' => $request->title,
            'slug' => HelperController::make_slug($request->slug ?? $request->title),
            'description' => $request->description,
            'tags' => $request->tags,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'image' => $blog->BlogTranslation->image, // Use same image for all translations usually
            'Author' => Auth::id(),
            'lang_id' => app()->getLocale(),
        ]);

        alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));
        return redirect()->route('admin.blogs.index');
    }

    public static function imageUpload(Request $request)
    {
        $image_name = Str::slug($request->title) . '-' . time() . '.' . $request->image->extension();
        $request->image->move(public_path('website/images/blog'), $image_name);
        return ['image' => $image_name];
    }
}
