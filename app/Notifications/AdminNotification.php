<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminNotification extends Notification
{
    use Queueable;

    protected $message;
    protected $orderId;
    protected $sellerId;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $orderId, $sellerId)
    {
        $this->message = $message;
        $this->orderId = $orderId;
        $this->sellerId = $sellerId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database']; // Assuming you only want to send email notifications
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
{
    return (new MailMessage)
        ->from(auth()->user()->email, auth()->user()->name)
        ->subject('Order Confirmation Request')
        ->line($this->message)
        ->action('View Orders', url('/admin/orders'))
        ->line('Thank you for using our platform!');
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
            'message' => $this->message,
            'order_id' => $this->orderId,
            'seller_id' => $this->sellerId,
        ];
    }
}
