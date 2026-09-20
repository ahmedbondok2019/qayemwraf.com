<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiV1\ProjectResource;
use App\Models\Project;
use App\Traits\ApiPaginationTrait;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

/**
 * @group 25. المشروعات والأعمال (Projects)
 *
 * يوفر الواجهات الخاصة بجلب قائمة مشروعات الشركة المنفذة وتفاصيل كل مشروع.
 */
class ProjectController extends Controller
{
    use ApiPaginationTrait, ApiResponseTrait;

    /**
     * جلب قائمة المشروعات
     *
     * يعيد قائمة المشروعات المنفذة المفعّلة مع دعم التقسيم لصفحات (Pagination).
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 15);
        $query = Project::active()->with(['translation', 'translations']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('translations', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $projects = $query->paginate($perPage);

        return $this->successResponse(
            $this->paginateResponse($projects, ProjectResource::collection($projects))
        );
    }

    /**
     * جلب تفاصيل مشروع محدد
     */
    public function show($id)
    {
        $project = Project::active()
            ->with(['translation', 'translations'])
            ->find($id);

        if (! $project) {
            return $this->errorResponse('المشروع غير موجود أو غير متاح', 404);
        }

        return $this->successResponse(new ProjectResource($project));
    }
}
