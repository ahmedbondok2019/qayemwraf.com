<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PhoneCheck;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;
use App\Http\Requests\ApiV1\Auth\RegisterRequest;
use App\Http\Requests\ApiV1\Auth\LoginRequest;
use App\Http\Requests\ApiV1\Auth\ForgetPasswordRequest;
use App\Http\Requests\ApiV1\Auth\ResetPasswordRequest;
use App\Http\Requests\ApiV1\Auth\SocialLoginRequest;

/**
 * @group 01. المصادقة والحسابات (Auth)
 * 
 * يتولى العمليات الخاصة بتسجيل الحسابات الجديدة، تسجيل الدخول،
 * تسجيل الدخول عبر شبكات التواصل، استعادة كلمة المرور، الاشتراك في الإشعارات، وإلغاء الحسابات.
 */
class AuthController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * تسجيل حساب مستخدم جديد
     * 
     * ينشئ حساباً جديداً للمستخدم ويعيد رمز المصادقة (Bearer Token).
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country_id' => $request->country_id,
            'password' => Hash::make($request->password),
            'status' => 1,
        ]);

        if ($request->temp_user_id) {
            $this->mergeGuestData($user->id, $request->temp_user_id);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 'تم تسجيل الحساب بنجاح');
    }

    /**
     * تسجيل الدخول
     * 
     * يتحقق من بيانات الدخول (البريد أو الهاتف مع كلمة المرور) ويعيد رمز الوصول للمستخدم.
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->login)
            ->orWhere('phone', $request->login)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->errorResponse('بيانات الدخول غير صحيحة', 401);
        }

        if ($request->temp_user_id) {
            $this->mergeGuestData($user->id, $request->temp_user_id);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 'تم تسجيل الدخول بنجاح');
    }

    /**
     * دمج بيانات الزائر مؤقتاً
     * 
     * ينقل عناصر السلة والمفضلة من المعرف المؤقت للزائر إلى معرف المستخدم المسجل.
     */
    private function mergeGuestData($userId, $tempUserId)
    {
        // دمج عناصر السلة
        Cart::where('temp_user_id', $tempUserId)->update([
            'user_id' => $userId,
            'temp_user_id' => null
        ]);

        // دمج عناصر المفضلة
        $guestWishlist = Wishlist::where('temp_user_id', $tempUserId)->get();
        foreach ($guestWishlist as $item) {
            $exists = Wishlist::where('user_id', $userId)
                ->where('product_id', $item->product_id)
                ->first();
            
            if ($exists) {
                $item->delete();
            } else {
                $item->update([
                    'user_id' => $userId,
                    'temp_user_id' => null
                ]);
            }
        }
    }

    /**
     * تسجيل الدخول عبر شبكات التواصل الاجتماعي
     * 
     * تسجيل أو ربط حساب عبر شبكات التواصل (جوجل / فيسبوك / أبل).
     */
    public function socialLogin(SocialLoginRequest $request)
    {
        $providerField = $request->provider . '_id';
        
        $user = User::where($providerField, $request->provider_id)->first();

        if (!$user && $request->email) {
            $user = User::where('email', $request->email)->first();
            
            if ($user) {
                $user->update([$providerField => $request->provider_id]);
            }
        }

        if (!$user) {
            $user = User::create([
                'name' => $request->name ?? $request->provider . ' User',
                'email' => $request->email,
                'phone' => $request->phone ?? "0111111111",
                'image' => $request->image,
                $providerField => $request->provider_id,
                'password' => Hash::make(rand(10000000, 99999999)),
                'status' => 1,
                'country_id' => $request->country_id ?? 1,
            ]);
        }

        if ($request->temp_user_id) {
            $this->mergeGuestData($user->id, $request->temp_user_id);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 'تم تسجيل الدخول عبر شبكة التواصل بنجاح');
    }

    /**
     * تسجيل الخروج
     * 
     * يلغي رمز الوصول الحالي للمستخدم وينتهي الجلسة الحالية.
     */
    public function logout(\Illuminate\Http\Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse(null, 'تم تسجيل الخروج بنجاح');
    }

    /**
     * حذف حساب المستخدم
     * 
     * يحذف حساب المستخدم الحالي نهائياً مع كافة الرموز والبيانات المرتبطة.
     */
    public function deleteAccount(\Illuminate\Http\Request $request)
    {
        $user = $request->user();
        
        $user->tokens()->delete();
        $user->delete();

        return $this->successResponse(null, 'تم حذف الحساب بنجاح');
    }

    /**
     * نسيت كلمة المرور
     * 
     * يرسل كود التحقق (OTP) إلى البريد الإلكتروني للمستخدم لاستعادة كلمة المرور.
     */
    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $otp = rand(1000, 9999);
        
        PhoneCheck::updateOrCreate(
            ['phone' => $request->email],
            ['check_code' => $otp, 'status' => 0]
        );

        $user = User::where('email', $request->email)->first();
        if ($user && $user->email) {
            Mail::to($user->email)->send(new OtpMail($otp));
        }

        return $this->successResponse(null, 'تم إرسال كود التحقق إلى بريدك الإلكتروني');
    }

    /**
     * إعادة تعيين كلمة المرور
     * 
     * يغيّر كلمة المرور للمستخدم بعد التأكد من صحة كود التحقق المدخل.
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $check = PhoneCheck::where('phone', $request->email)
            ->where('check_code', $request->otp)
            ->first();

        if (!$check) {
            return $this->errorResponse('كود التحقق غير صحيح', 422);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        $check->delete();

        return $this->successResponse(null, 'تم تغيير كلمة المرور بنجاح');
    }

    /**
     * الاشتراك في موضوع الإشعارات (FCM Topic)
     * 
     * يشترك جهاز المستخدم في استقبال الإشعارات عبر Firebase (مثل العروض والأخبار).
     */
    public function subscribeToTopic(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
            'topic' => 'nullable|string',
            'device_id' => 'nullable|string',
            'device_type' => 'nullable|string',
        ]);

        $topic = $request->topic ?: 'offers';
        
        try {
            $firebaseService = app(\App\Services\FirebaseService::class);
            $firebaseService->subscribeToTopic($request->fcm_token, $topic);
            
            $userId = auth('sanctum')->id();
            
            \App\Models\UserFcmToken::updateOrCreate(
                ['fcm_token' => $request->fcm_token],
                [
                    'user_id' => $userId,
                    'device_id' => $request->device_id,
                    'device_type' => $request->device_type,
                ]
            );
            
            return $this->successResponse(null, 'تم الاشتراك في الإشعارات بنجاح');
        } catch (\Exception $e) {
            return $this->errorResponse('فشل الاشتراك في الإشعارات: ' . $e->getMessage(), 500);
        }
    }
}
