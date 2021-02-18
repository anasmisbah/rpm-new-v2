<?php

namespace App\Exports;

use App\DeliveryOrder;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DeliveryOrderExport implements FromView,WithColumnWidths, WithEvents
{
    public function __construct(string $id)
    {
        $this->id = $id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $delivery_order = DeliveryOrder::findOrFail($this->id);
        $sales_order = $delivery_order->sales_order;
        $agen = $sales_order->agen;
        $date = Carbon::now();
        $quantity_terbilang = ucwords($this->terbilang($delivery_order->quantity)." ".$delivery_order->piece);

        return view('delivery_order.print4',compact('sales_order','agen','delivery_order','date','quantity_terbilang'));
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10.29,
            'B' => 6.57,
            'C' => 3.57,
            'D' => 3.57,
            'E' => 3,
            'F' => 10.29,
            'G' => 9.29,
            'H' => 12.14,
            'I' => 7.29,
            'J' => 15.57,
            'K' => 9.14,
            'L' => 7.86,
            'M' => 9.29,

        ];
    }



    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                // Set first row height
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(21);
                $event->sheet->getDelegate()->getRowDimension(2)->setRowHeight(10.5);
                $event->sheet->getDelegate()->getRowDimension(3)->setRowHeight(18);
                $event->sheet->getDelegate()->getRowDimension(4)->setRowHeight(15.75);
                $event->sheet->getDelegate()->getRowDimension(5)->setRowHeight(7.5);
                $event->sheet->getDelegate()->getRowDimension(6)->setRowHeight(15.75);
                $event->sheet->getDelegate()->getRowDimension(7)->setRowHeight(12.75);
                $event->sheet->getDelegate()->getRowDimension(8)->setRowHeight(12.75);
                $event->sheet->getDelegate()->getRowDimension(9)->setRowHeight(10.5);
                $event->sheet->getDelegate()->getRowDimension(10)->setRowHeight(12.75);
                $event->sheet->getDelegate()->getRowDimension(11)->setRowHeight(12.75);
                $event->sheet->getDelegate()->getRowDimension(12)->setRowHeight(15.75);
                $event->sheet->getDelegate()->getRowDimension(13)->setRowHeight(12.75);
                $event->sheet->getDelegate()->getRowDimension(14)->setRowHeight(10.5);
                $event->sheet->getDelegate()->getRowDimension(15)->setRowHeight(10.5);
                $event->sheet->getDelegate()->getRowDimension(16)->setRowHeight(12.75);
                $event->sheet->getDelegate()->getRowDimension(17)->setRowHeight(8.25);
                $event->sheet->getDelegate()->getRowDimension(18)->setRowHeight(15);
                $event->sheet->getDelegate()->getRowDimension(19)->setRowHeight(12.75);
                $event->sheet->getDelegate()->getRowDimension(20)->setRowHeight(9.75);
                $event->sheet->getDelegate()->getRowDimension(21)->setRowHeight(12.5);
                $event->sheet->getDelegate()->getRowDimension(22)->setRowHeight(12);
                $event->sheet->getDelegate()->getRowDimension(23)->setRowHeight(11.25);
                $event->sheet->getDelegate()->getRowDimension(24)->setRowHeight(16.5);
                $event->sheet->getDelegate()->getRowDimension(25)->setRowHeight(12.75);
                $event->sheet->getDelegate()->getRowDimension(26)->setRowHeight(12.75);
                $event->sheet->getDelegate()->getRowDimension(27)->setRowHeight(13.5);
                $event->sheet->getDelegate()->getRowDimension(28)->setRowHeight(12.75);
                $event->sheet->getDelegate()->getRowDimension(29)->setRowHeight(9.75);
                $event->sheet->getDelegate()->getRowDimension(30)->setRowHeight(13.5);
                $event->sheet->getDelegate()->getRowDimension(31)->setRowHeight(15.75);
                $event->sheet->getDelegate()->getRowDimension(32)->setRowHeight(12.75);
                $event->sheet->getDelegate()->getRowDimension(33)->setRowHeight(12.75);
                $event->sheet->getDelegate()->getRowDimension(34)->setRowHeight(14.25);
                $event->sheet->getDelegate()->getRowDimension(35)->setRowHeight(16.5);
                $event->sheet->getDelegate()->getRowDimension(36)->setRowHeight(12.75);
                $event->sheet->getDelegate()->getRowDimension(37)->setRowHeight(12.75);
                $event->sheet->getDelegate()->getRowDimension(38)->setRowHeight(9);
                $event->sheet->getDelegate()->getRowDimension(39)->setRowHeight(9.75);
                $event->sheet->getDelegate()->getRowDimension(40)->setRowHeight(12.75);

                // Set column width
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(8.43);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(6.43);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(2.29);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(2);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(2.14);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(10.71);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(9.14);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(5.86);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(7.14);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(15.57);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(7);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(12.29);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(8);
            },
        ];
    }

    private function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
            $temp = $this->penyebut($nilai - 10). " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
        }
        return $temp;
    }

    private function terbilang($nilai) {
        if($nilai<0) {
            $hasil = "minus ". trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }
        return $hasil;
    }
}
