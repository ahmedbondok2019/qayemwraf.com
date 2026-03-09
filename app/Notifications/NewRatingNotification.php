<?php

namespace App\Notifications;

use App\Models\Rating;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewRatingNotification extends Notification
{
    use Queueable;

    protected $rating;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Rating $rating)
    {
        $this->rating = $rating;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'type' => 'new_rating',
            'rating_id' => $this->rating->id,
            'user_name' => $this->rating->user->name ?? 'Guest',
            'product_name' => $this->rating->product->translation->name ?? 'Product',
            'rating_value' => $this->rating->rating,
            'comment' => $this->rating->comment,
            'title' => 'تقييم جديد للمنتج',
            'message' => 'قام ' . ($this->rating->user->name ?? 'عميل') . ' بتقييم منتج ' . ($this->rating->product->translation->name ?? '') . ' بـ ' . $this->rating->rating . ' نجوم.',
            'url' => route('admin.ratings.index'), // Assuming there's an admin route for ratings
        ];
    }
}
