<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Order;
class ShoppingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $orderDetail = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $orderDetail)
    {
        $this->order = $order;
        $this->orderDetail = $orderDetail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.shopping');
    }
}
