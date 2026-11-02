<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class OrderStatusMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public function __construct(public Order $order, public string $label, public ?string $note = null) {}
    public function build(): static
    {
        return $this->subject('Order '.$this->order->order_number.' — '.$this->label)
            ->view('emails.orders.status');
    }
}
