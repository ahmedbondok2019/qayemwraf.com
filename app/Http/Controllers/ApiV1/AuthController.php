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

class AuthController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * Register
     * 
     * Register a new user and return a token.
     * 
     * @group Authentication
     * @bodyParam name string required The name of the user. Example: John Doe
     * @bodyParam email string required The email of the user. Example: john@example.com
     * @bodyParam phone string required The phone number. Example: 01021456325
     * @bodyParam country_id int required ID of the country. Example: 1
     * @bodyParam password string required The password. Example: password123
     * @header Content-Type multipart/form-data
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
        ], 'User registered successfully');
    }

    /**
     * Login
     * 
     * Authenticate user and return a token.
     * 
     * @group Authentication
     * @bodyParam login string required Email or Phone of the user. Example: john@example.com or 01021456325
     * @bodyParam password string required The password. Example: password123
     * @header Content-Type multipart/form-data
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->login)
            ->orWhere('phone', $request->login)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Invalid login credentials', 401);
        }

        if ($request->temp_user_id) {
            $this->mergeGuestData($user->id, $request->temp_user_id);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 'Login successful');
    }

    /**
     * Merge Guest Data
     * 
     * Move cart and wishlist items from guest ID to user ID.
     */
    private function mergeGuestData($userId, $tempUserId)
    {
        // Merge Cart
        Cart::where('temp_user_id', $tempUserId)->update([
            'user_id' => $userId,
            'temp_user_id' => null
        ]);

        // Merge Wishlist
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
     * Social Login
     * 
     * Login or Register via social media (Google, Facebook, Apple).
     * 
     * @group Authentication
     * @bodyParam provider string required The provider name (google, facebook, apple). Example: google
     * @bodyParam provider_id string required The unique ID from the provider.
     * @bodyParam email string nullable The email of the user.
     * @bodyParam name string nullable The name of the user.
     * @bodyParam image string nullable The image URL of the user.
     */
    public function socialLogin(SocialLoginRequest $request)
    {
        $providerField = $request->provider . '_id';
        
        // Find user by social ID
        $user = User::where($providerField, $request->provider_id)->first();

        if (!$user && $request->email) {
            // Find by email if social ID not found
            $user = User::where('email', $request->email)->first();
            
            if ($user) {
                // Link social ID to existing account
                $user->update([$providerField => $request->provider_id]);
            }
        }

        if (!$user) {
            // Create new user
            $user = User::create([
                'name' => $request->name ?? $request->provider . ' User',
                'email' => $request->email,
                'phone' => $request->phone ?? "0111111111",
                'image' => $request->image,
                $providerField => $request->provider_id,
                'password' => Hash::make(rand(10000000, 99999999)), // Random password
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
        ], 'Social login successful');
    }

    /**
     * Logout
     * 
     * Log the user out (Invalidate the token).
     * 
     * @authenticated
     * @group Authentication
     * @response {
     *  "success": true,
     *  "message": "Successfully logged out"
     * }
     */
    public function logout(\Illuminate\Http\Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse(null, 'Successfully logged out');
    }

    /**
     * Delete Account
     * 
     * Delete the authenticated user's account.
     * 
     * @authenticated
     * @group Authentication
     * @response {
     *  "success": true,
     *  "message": "Account deleted successfully"
     * }
     */
    public function deleteAccount(\Illuminate\Http\Request $request)
    {
        $user = $request->user();
        
        // Delete tokens first
        $user->tokens()->delete();
        
        // Delete user
        $user->delete();

        return $this->successResponse(null, 'Account deleted successfully');
    }

    /**
     * Forget Password
     * 
     * Send an OTP to the user's email for password reset.
     * 
     * @group Authentication
     * @bodyParam email string required The email of the user. Example: john@example.com
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

        return $this->successResponse(null, 'تم ارسال كود التحقق الى بريدك الإلكتروني');
    }

    /**
     * Reset Password
     * 
     * Reset user password using OTP.
     * 
     * @group Authentication
     * @bodyParam email string required The email address. Example: john@example.com
     * @bodyParam otp string required The OTP received. Example: 1234
     * @bodyParam password string required New password. Example: newpassword123
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

        // Delete the OTP after successful reset
        $check->delete();

        return $this->successResponse(null, 'تم تغيير كلمة المرور بنجاح');
    }

    /**
     * Subscribe to Topic
     * 
     * Subscribe a device to a specific Firebase topic (e.g., 'offers').
     * 
     * @group Authentication
     * @bodyParam fcm_token string required The Firebase Cloud Messaging token.
     * @bodyParam topic string required The topic to subscribe to. Default: offers
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
            
            // Save token to database
            \App\Models\UserFcmToken::updateOrCreate(
                ['fcm_token' => $request->fcm_token],
                [
                    'user_id' => $userId,
                    'device_id' => $request->device_id,
                    'device_type' => $request->device_type,
                ]
            );
            
            return $this->successResponse(null, 'Subscribed to topic successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to subscribe: ' . $e->getMessage(), 500);
        }
    }
}
