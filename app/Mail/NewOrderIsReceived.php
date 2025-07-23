<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Chalet;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrderIsReceived extends Mailable
{
    use Queueable, SerializesModels;



    public $order, $chalet;
    public function __construct(Booking $booking, Chalet $chalet)
    {
        $this->order = $booking;
        $this->chalet = $chalet;
    }




    public function build()
    {
        return $this->view('mail.new-order-is-received')
            ->subject('طلب حجز شاليه من شاليهاتي');
    }
}
