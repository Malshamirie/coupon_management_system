<?php

namespace App\Imports;

use App\Models\ProductCode;
use Maatwebsite\Excel\Concerns\ToModel;

class CodeImport implements ToModel
{
    public function model(array $row)
    {
        return new ProductCode([
            'code' => trim($row[0])
        ]);
    }
}


