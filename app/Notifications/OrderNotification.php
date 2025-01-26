<?php 


namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderNotification extends Notification
{
    use Queueable;

    protected $message;
    protected $orderId;
    protected $sellerId;
    protected $orderDetails;

    /**
     * Create a new notification instance.
     *
     * @param string $message
     * @param int $orderId
     * @param int $sellerId
     * @param array $orderDetails
     */
    public function __construct($message, $orderId, $sellerId, $orderDetails)
    {
        $this->message = $message;
        $this->orderId = $orderId;
        $this->sellerId = $sellerId;
        $this->orderDetails = $orderDetails;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'order_id' => $this->orderId,
            'seller_id' => $this->sellerId,
            'order_details' => $this->orderDetails,  
        ];
    }
   

}
