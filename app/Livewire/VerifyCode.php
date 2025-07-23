<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProductCode;

class VerifyCode extends Component
{
    public $serial_number;
    public $search_result;
    public $error_message;

    // تعريف القواعد للفاليديشن
    protected $rules = [
        'serial_number' => 'required|string|min:16',
    ];

    // التحقق الفوري عند تحديث الحقول
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function search()
    {
        $this->validate();

        $this->search_result = Coupon::where('code', $this->serial_number)->first();

        if (!$this->search_result) {
            $this->error_message = 'The entered key is not found in our records so it should be a FAKE PRODUCT!!. Please reach your seller for more details';
        } else {
            $this->error_message = null;
        }
    }

    public function render()
    {
        return view('livewire.verify-code');
    }
}
