<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Upload;

class DataImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array  $row)
    {
        return new Upload([
            'no_so'  => $row['so_no_coupon'],
            'no_agen' => $row['sold_to_party'],
            'name_agen'    => $row['sold_to_party_name'],
            'no_customer'    => $row['ship_to_party'],
            'name_customer'    => $row['ship_to_party_name'],
            'quantity'    => $row['qty'],
        ]);
    }
}
