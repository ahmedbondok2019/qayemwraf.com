<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use App\Http\Requests\ApiV1\Address\AddressStoreRequest;
use App\Http\Requests\ApiV1\Address\AddressUpdateRequest;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;
use App\Http\Resources\ApiV1\AddressResource;

/**
 *  عناوين شحن المستخدم
 * 
 * يتولى جلب قائمة العناوين، إضافة عنوان جديد، تعديل عنوان، حذف عنوان، وتحديد العنوان الرئيسي للشحن.
 */
class UserAddressController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * جلب قائمة عناوين المستخدم
     * 
     * يعيد قائمة بجميع عناوين الشحن المسجلة للمستخدم الحالي مع أسماء الدولة والمحافظة والمدينة.
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $addresses = $request->user()->address()
            ->with(['country_rel.translation', 'governorate_rel.translation', 'city_rel.translation'])
            ->get();

        return $this->successResponse(AddressResource::collection($addresses));
    }

    /**
     * إضافة عنوان شحن جديد
     * 
     * ينشئ عنوان شحن جديد للمستخدم ويحفظ البيانات الجغرافية ورقم التواصل.
     */
    public function store(AddressStoreRequest $request)
    {
        if ($request->is_main) {
            UserAddress::where('user_id', $request->user()->id)->update(['is_main' => 0]);
        }

        $address = $request->user()->address()->create($request->all());

        return $this->successResponse(new AddressResource($address->load(['country_rel.translation', 'governorate_rel.translation', 'city_rel.translation'])), 'تمت إضافة العنوان بنجاح');
    }

    /**
     * تعديل بيانات عنوان شحن
     * 
     * يحدّث تفاصيل عنوان شحن محدد للمستخدم.
     */
    public function update(AddressUpdateRequest $request, $id)
    {
        $address = $request->user()->address()->find($id);

        if (!$address) {
            return $this->errorResponse('العنوان غير موجود', 404);
        }

        if ($request->is_main) {
            UserAddress::where('user_id', $request->user()->id)->update(['is_main' => 0]);
        }

        $address->update($request->all());

        return $this->successResponse(new AddressResource($address->load(['country_rel.translation', 'governorate_rel.translation', 'city_rel.translation'])), 'تم تحديث العنوان بنجاح');
    }

    /**
     * حذف عنوان شحن
     * 
     * يزيل عنوان شحن محدد للمستخدم من النظام.
     */
    public function destroy(\Illuminate\Http\Request $request, $id)
    {
        $address = $request->user()->address()->find($id);

        if (!$address) {
            return $this->errorResponse('العنوان غير موجود', 404);
        }

        $address->delete();

        return $this->successResponse(null, 'تم حذف العنوان بنجاح');
    }

    /**
     * تعيين عنوان كعنوان رئيسي
     * 
     * يحدد عنواناً معيناً ليكون عنوان الشحن الرئيسي الافتراضي للمستخدم.
     */
    public function setMain(\Illuminate\Http\Request $request, $id)
    {
        $address = $request->user()->address()->find($id);

        if (!$address) {
            return $this->errorResponse('العنوان غير موجود', 404);
        }

        UserAddress::where('user_id', $request->user()->id)->update(['is_main' => 0]);
        $address->update(['is_main' => 1]);

        return $this->successResponse(new AddressResource($address->load(['country_rel.translation', 'governorate_rel.translation', 'city_rel.translation'])), 'تم تعيين العنوان كعنوان رئيسي بنجاح');
    }
}
