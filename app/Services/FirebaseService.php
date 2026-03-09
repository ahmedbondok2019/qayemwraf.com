<?php

namespace App\Services;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        try {
            $this->messaging = Firebase::messaging();
        } catch (\Exception $e) {
            Log::error('Firebase initialization failed: ' . $e->getMessage());
            $this->messaging = null;
        }
    }

    /**
     * Send notification to a specific token
     */
    public function sendToToken($token, $title, $body, $data = [])
    {
        if (!$this->messaging || !$token) return null;

        try {
            $notification = Notification::create($title, $body);
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification($notification)
                ->withData($data);

            return $this->messaging->send($message);
        } catch (\Exception $e) {
            Log::error('Firebase sendToToken failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Send notification to multiple tokens
     */
    public function sendToTokens(array $tokens, $title, $body, $data = [])
    {
        if (!$this->messaging || empty($tokens)) return null;

        try {
            $notification = Notification::create($title, $body);
            $message = CloudMessage::new()
                ->withNotification($notification)
                ->withData($data);

            return $this->messaging->sendMulticast($message, $tokens);
        } catch (\Exception $e) {
            Log::error('Firebase sendToTokens failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Send notification to a topic (e.g. 'offers')
     */
    public function sendToTopic($topic, $title, $body, $data = [])
    {
        if (!$this->messaging) return null;

        try {
            $notification = Notification::create($title, $body);
            $message = CloudMessage::withTarget('topic', $topic)
                ->withNotification($notification)
                ->withData($data);

            return $this->messaging->send($message);
        } catch (\Exception $e) {
            Log::error('Firebase sendToTopic failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Subscribe a token to a topic
     */
    public function subscribeToTopic($token, $topic)
    {
        if (!$this->messaging || !$token) return null;

        try {
            return $this->messaging->subscribeToTopic($topic, $token);
        } catch (\Exception $e) {
            Log::error('Firebase subscribeToTopic failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Send notification to all devices of a user
     */
    public function sendToUser(\App\Models\User $user, $title, $body, $data = [])
    {
        $tokens = $user->fcmTokens()->pluck('fcm_token')->toArray();
        if (empty($tokens)) return null;

        return $this->sendToTokens($tokens, $title, $body, $data);
    }
}
