<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryOrder extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $shipped_via = '';
                switch ($this->shipped_via) {
                    case 0:
                        $shipped_via = 'Jalur Darat';
                        break;
                    case 1:
                        $shipped_via = 'Jalur Laut';
                        break;
                    case 2:
                        $shipped_via = 'Jalur Laut / Jalur Darat';
                        break;
                }

                $status = '';
                switch ($this->status) {
                    case 0:
                        $status = 'Menunggu persutujuan agen';
                        break;
                    case 1:
                        $status = 'menunggu driver';
                        break;
                    case 2:
                        $status = 'dalam pengiriman';
                        break;
                    case 3:
                        $status = 'Telah Dikirim';
                        break;
                }
        return [
            'id'=>$this->id,
            'delivery_order_number'=>$this->delivery_order_number,
            'effective_date_start'=>$this->effective_date_start->format('l, d F Y'),
            'effective_date_end'=>$this->effective_date_end->format('l, d F Y'),
            'product'=>$this->product,
            'quantity'=>$this->quantity,
            'shipped_with'=>$this->shipped_with,
            'shipped_via'=>$shipped_via,
            'no_vehicles'=>$this->no_vehicles,
            'km_start'=>$this->km_start,
            'km_end'=>$this->km_end,
            'sg_meter'=>$this->sg_meter,
            'top_seal'=>$this->top_seal,
            'bottom_seal'=>$this->bottom_seal,
            'temperature'=>$this->temperature,
            'departure_time'=>$this->departure_time == null ? null:  $this->departure_time->format('l, d F Y H:i:s'),
            'arrival_time'=>$this->arrival_time == null ? null:  $this->arrival_time->format('l, d F Y H:i:s'),
            'unloading_start_time'=>$this->unloading_start_time,
            'unloading_end_time'=>$this->unloading_end_time,
            'departure_time_depot'=>$this->departure_time_depot,
            'status'=>$status,
            'sales_order'=>$this->sales_order,
            'customer'=>$this->customer,
            'driver'=>$this->driver,
            'bast'=>url('/uploads/' . $this->bast)
        ];
    }
}
