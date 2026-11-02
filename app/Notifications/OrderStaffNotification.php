<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderStaffNotification extends Notification
{
    use Queueable;

    public function __construct(public Order $order, public string $event) {}
    public function via(object $notifiable): array { return ['database']; }
    public function toArray(object $notifiable): array
    {
        return ['event'=>$this->event,'order_id'=>$this->order->id,'order_number'=>$this->order->order_number,'customer'=>$this->order->customer_name,'url'=>route('admin.orders.show',$this->order)];
    }
}
