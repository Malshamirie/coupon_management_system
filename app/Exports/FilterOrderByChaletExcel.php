<?php

namespace App\Exports;

use App\Models\Booking;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class FilterOrderByChaletExcel implements FromView, WithEvents, ShouldAutoSize
{

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }


    protected $chalet_id;

    function __construct($chalet_id) {
        $this->chalet_id = $chalet_id;
    }



    public function view(): View
    {
        if($this->chalet_id == 0)
        {
            $orders = Booking::orderBy('id', 'desc')->paginate(25);
            return view('backend.pages.bookingCustomers.orders_excel', [
                'orders' => $orders,
            ]);
        }
        else
        {
            $orders = Booking::where('chalet_id', $this->chalet_id)->orderBy('id', 'desc')->paginate(25);
            return view('backend.pages.bookingCustomers.orders_excel', [
                'orders' => $orders,
            ]);
        }
    }


}
