<?php

namespace App\Notifications;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Session;

class AdminNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $admin;

    private $order;

    public function __construct(Admin $admin, $order)
    {
        $this->admin = $admin;
        $this->order = $order;
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->admin->id,
            'title' => Session::get('user_notification_title'),
            'image' => Session::get('user_notification_image'),
            'date' => Carbon::today(),
            // 'url' => 'https://souqelmlabes.com/' . app()->getLocale() . '/notifications/' . $this->id
            'url' => Session::get('user_notification_url'),
        ];

        // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
