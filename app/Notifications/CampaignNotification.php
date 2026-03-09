<?php

namespace App\Notifications;

use App\Models\Broadcast;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CampaignNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $broadcast;

    /**
     * Create a new notification instance.
     */
    public function __construct(Broadcast $broadcast)
    {
        $this->broadcast = $broadcast;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = [];
        if (in_array('website', $this->broadcast->channels)) {
            $channels[] = 'database';
        }
        if (in_array('email', $this->broadcast->channels)) {
            $channels[] = 'mail';
        }
        // SMS and WhatsApp would need specific drivers/channels
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
                    ->subject($this->broadcast->title)
                    ->line($this->broadcast->content);

        if ($this->broadcast->link) {
            $mail->action('View Details', route('frontend.broadcast.click', $this->broadcast->id));
        }

        return $mail;
    }

    /**
     * Get the database representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'broadcast',
            'broadcast_id' => $this->broadcast->id,
            'title' => $this->broadcast->title,
            'content' => $this->broadcast->content,
            'image' => $this->broadcast->image,
            'url' => $this->broadcast->link ? route('frontend.broadcast.click', $this->broadcast->id) : null,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
