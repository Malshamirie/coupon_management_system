<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class YourOrderIsReceived extends Mailable
{
    use Queueable, SerializesModels;



    public $order;
    public function __construct(Booking $booking)
    {
        $this->order = $booking;
    }



    public function build()
    {
        return $this->view('mail.your-order-is-received')
            ->subject('طلب حجز شاليه من شاليهاتي');
    }
}
