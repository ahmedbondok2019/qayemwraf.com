<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiV1\User\ProfileUpdateRequest;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group User Profile
 * 
 * APIs for managing the authenticated user's profile.
 */
class ProfileController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * Get Profile
     * 
     * Get the authenticated user's profile information.
     * 
     * @authenticated
     */
    public function show(Request $request)
    {
        return $this->successResponse($request->user());
    }

    /**
     * Update Profile
     * 
     * Update the authenticated user's profile information.
     * 
     * @authenticated
     * @bodyParam name string Optional new name.
     * @bodyParam email string Optional new email.
     * @bodyParam phone string Optional new phone number.
     * @bodyParam country_id int Optional new country ID.
     * @bodyParam password string Optional new password.
     * @bodyParam password_confirmation string Required if password is provided.
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

        return $this->successResponse($user, 'Profile updated successfully');
    }

    /**
     * Update FCM Token
     * 
     * Update the authenticated user's FCM token.
     * 
     * @authenticated
     * @bodyParam fcm_token string required New FCM token.
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

        // Also ensure they are subscribed to 'offers'
        try {
            app(\App\Services\FirebaseService::class)->subscribeToTopic($request->fcm_token, 'offers');
        } catch (\Exception $e) {
            // Log or ignore
        }

        return $this->successResponse(null, 'FCM Token updated successfully');
    }
}
