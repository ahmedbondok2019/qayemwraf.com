<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiV1\User\ProfileUpdateRequest;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group 12. الملف الشخصي (Profile)
 * 
 * يتولى جلب بيانات الملف الشخصي، تحديث المعلومات الشخصية وكلمة المرور، وتحديث رموز الإشعارات (FCM Token).
 */
class ProfileController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * جلب الملف الشخصي
     * 
     * يعيد كافة البيانات والعلومات الشخصية الخاصة بالمستخدم الحالي المسجل.
     */
    public function show(Request $request)
    {
        return $this->successResponse($request->user());
    }

    /**
     * تحديث البيانات الشخصية
     * 
     * يحدّث الاسم، البريد، رقم الهاتف، الدولة، أو كلمة المرور الخاصة بالمستخدم.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return $this->successResponse($user, 'تم تحديث الملف الشخصي بنجاح');
    }

    /**
     * تحديث رمز الإشعارات (FCM Token)
     * 
     * يحدّث رمز الإشعارات التنبيهية الخاصة بجهاز المستخدم لارسال الإشعارات عبر Firebase.
     */
    public function updateFcmToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
            'device_id' => 'nullable|string',
            'device_type' => 'nullable|string',
        ]);

        $user = $request->user();
        
        \App\Models\UserFcmToken::updateOrCreate(
            ['fcm_token' => $request->fcm_token],
            [
                'user_id' => $user->id,
                'device_id' => $request->device_id,
                'device_type' => $request->device_type,
            ]
        );

        try {
            app(\App\Services\FirebaseService::class)->subscribeToTopic($request->fcm_token, 'offers');
        } catch (\Exception $e) {
        }

        return $this->successResponse(null, 'تم تحديث رمز الإشعارات بنجاح');
    }
}
