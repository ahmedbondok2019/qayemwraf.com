<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectTranslation;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProjectController extends Controller
{
    use UploadImageTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('translations')->orderBy('sort_order', 'asc')->orderBy('id', 'desc')->paginate(15);

        return view('dashboard.admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'video' => 'nullable|string',
            'link' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $rules["title_$localeCode"] = 'required|string|max:255';
            $rules["description_$localeCode"] = 'nullable|string';
        }

        $request->validate($rules);

        $project = new Project;
        $project->link = $request->link;
        $project->video = $request->video;
        $project->sort_order = $request->sort_order ?? 0;
        $project->is_active = $request->has('is_active') ? true : false;

        if ($request->hasFile('image')) {
            // Upload with watermark applied automatically
            $project->image = $this->uploadImage($request->file('image'), 'projects', null, null, true);
        }

        $project->save();

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            ProjectTranslation::create([
                'project_id' => $project->id,
                'locale' => $localeCode,
                'title' => $request->input("title_$localeCode"),
                'description' => $request->input("description_$localeCode"),
            ]);
        }

        return redirect()->route('admin.projects.index')->with('success', trans_db('dashboard.saved') ?: 'تم الحفظ بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $project = Project::with('translations')->findOrFail($id);

        return view('dashboard.admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $rules = [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'video' => 'nullable|string',
            'link' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $rules["title_$localeCode"] = 'required|string|max:255';
            $rules["description_$localeCode"] = 'nullable|string';
        }

        $request->validate($rules);

        $project->link = $request->link;
        $project->video = $request->video;
        $project->sort_order = $request->sort_order ?? 0;
        $project->is_active = $request->has('is_active') ? true : false;

        if ($request->hasFile('image')) {
            // Upload with watermark applied automatically
            $project->image = $this->uploadImage($request->file('image'), 'projects', null, null, true);
        }

        $project->save();

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            ProjectTranslation::updateOrCreate(
                [
                    'project_id' => $project->id,
                    'locale' => $localeCode,
                ],
                [
                    'title' => $request->input("title_$localeCode"),
                    'description' => $request->input("description_$localeCode"),
                ]
            );
        }

        return redirect()->route('admin.projects.index')->with('success', trans_db('dashboard.updated') ?: 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', trans_db('dashboard.deleted') ?: 'تم الحذف بنجاح');
    }

    /**
     * Change project status via AJAX.
     */
    public function change_status(Request $request)
    {
        $project = Project::findOrFail($request->id);
        $project->is_active = $request->status;
        $project->save();

        return response()->json(['status' => true, 'message' => 'Status updated successfully']);
    }
}
