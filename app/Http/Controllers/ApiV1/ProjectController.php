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
        $perPage = $request->input('per_page', 15);
        $projects = Project::active()
            ->with(['translation', 'translations'])
            ->paginate($perPage);

        return $this->paginatedResponse($projects, ProjectResource::class);
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
