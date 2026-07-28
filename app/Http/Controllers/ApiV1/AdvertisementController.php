<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Http\Resources\ApiV1\AdvertisementResource;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;

/**
 * @group 19. الإعلانات (Advertisements)
 * 
 * يتولى جلب الإعلانات البنريّة النشطة والمتاحة للعرض في أماكن مختلفة داخل التطبيق.
 */
class AdvertisementController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * جلب قائمة الإعلانات البنريّة
     * 
     * يعيد قائمة بالإعلانات النشطة مع دعم الفلترة حسب الموضع (popup, home, sidebar, etc).
     */
    public function index(Request $request)
    {
        $query = Advertisement::active()->with(['translation']);

        if ($request->has('position')) {
            $positions = explode(',', $request->position);
            $query->whereIn('location', array_map('trim', $positions));
        }

        $advertisements = $query->latest()->get();

        return $this->successResponse(AdvertisementResource::collection($advertisements));
    }
}
