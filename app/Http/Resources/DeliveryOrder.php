<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\DriverResource;
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
            'effective_date_start'=>$this->effective_date_start->dayName.", ".$this->effective_date_start->day." ".$this->effective_date_start->monthName." ".$this->effective_date_start->year,
            'effective_date_end'=>$this->effective_date_end->dayName.", ".$this->effective_date_end->day." ".$this->effective_date_end->monthName." ".$this->effective_date_end->year,
            'product'=>$this->product->name,
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
            'departure_time'=>$this->departure_time == null ? null:  $this->departure_time->dayName.", ".$this->departure_time->day." ".$this->departure_time->monthName." ".$this->departure_time->year,
            'arrival_time'=>$this->arrival_time == null ? null:  $this->arrival_time->dayName.", ".$this->arrival_time->day." ".$this->arrival_time->monthName." ".$this->arrival_time->year,
            'unloading_start_time'=>$this->unloading_start_time,
            'unloading_end_time'=>$this->unloading_end_time,
            'departure_time_depot'=>$this->departure_time_depot,
            'status'=>$status,
            'sales_order_id'=>$this->sales_order->id,
            'driver'=>new DriverResource($this->driver),
            'bast'=>url('/uploads/' . $this->bast),
            'piece'=>$this->piece,
            'depot'=>$this->depot,
            'quantity_text'=>$this->quantity_text,
            'do_date'=>$this->created_at->day." ".$this->created_at->monthName." ".$this->created_at->year,
            'detail_address'=>$this->detail_address,
            'transportir'=>$this->transportir,
            'distribution'=>$this->distribution,
            'admin_name'=>$this->admin_name,
            'knowing'=>$this->knowing,
        ];
    }
}
