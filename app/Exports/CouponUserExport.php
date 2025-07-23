<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class CouponUserExport implements FromView, WithEvents, ShouldAutoSize
{

    protected $usercodes;
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }

    function __construct($usercodes) {
        $this->usercodes = $usercodes;
    }

    public function view(): View
    {

        return view('backend.pages.usercodes.report-excel', [
            'usercodes' => $this->usercodes,
        ]);
    }

}
