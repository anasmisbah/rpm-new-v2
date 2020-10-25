<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agen;
use App\SalesOrder;
use App\Customer;
use App\DeliveryOrder;
use GuzzleHttp\Client;
use DataTables;
class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $agen = Agen::findOrFail($id);

        return view('sales_order.index',compact('agen'));
    }

    public function  salesorder_data($id)
    {
        $so = SalesOrder::select(['sales_orders.id','sales_orders.sales_order_number','sales_orders.created_at','customers.name'])
                    ->join('customers','customers.id','=','sales_orders.customer_id')
                    ->where('sales_orders.agen_id',$id)->orderBy('id','desc');

        $dataTable = DataTables::of($so)
        ->addIndexColumn()
        ->editColumn('created_at', function ($data) {
            return $data->created_at->dayName.", ".$data->created_at->day." ".$data->created_at->monthName." ".$data->created_at->year.' | '.$data->created_at->format('H:i').' WITA';
        })
        ->addColumn('url_notif', function ($data) {
            return route('salesorder.agen.notif',$data->id);
        })
        ->addColumn('url_detail', function ($data) {
            return route('salesorder.agen.show',$data->id);
        })
        ->addColumn('url_edit', function ($data) {
            return route('salesorder.agen.edit',$data->id);
        })
        ->addColumn('url_delete', function ($data) {
            return route('salesorder.agen.destroy',$data->id);
        })
        ->addColumn('url_do', function ($data) {
            return route('deliveryorder.agen.index',$data->id);
        })
        ->addColumn('status', function ($data) {
            $result = DeliveryOrder::where('sales_order_id',$data->id)->first();
            if ($result) {
                return true;
            }else{
                return false;
            }
        });

        return $dataTable->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $agen = Agen::findOrFail($id);
        return view('sales_order.create',compact('agen'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $agen = Agen::findOrFail($id);
        $request->validate([
            'sales_order_number'=>'required',
            'customer_id'=>'required'
        ]);

        $sales_order = SalesOrder::create([
            'sales_order_number'=>$request->sales_order_number,
            'agen_id'=>$agen->id,
            'customer_id'=>$request->customer_id
        ]);

        $customer = $sales_order->customer;
        $customer->update([
            'coupon'=>($customer->coupon + 1)
        ]);

        $title = 'Sales Order';
        $message = "Dari Patra Niaga - Agent. SO No $sales_order->sales_order_number telah terbit";
        $fcm_token = [
            $sales_order->agen->user->fcm_token,
        ];
        $this->sendNotif($message,$title,$fcm_token);

        $message = "SO No $sales_order->sales_order_number telah terbit";
        $fcm_token = [
            $sales_order->customer->user->fcm_token,
        ];
        $this->sendNotif($message,$title,$fcm_token);

        return redirect()->back()->with('status','successfully created Sales Order');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sales_order = SalesOrder::findOrFail($id);
        $agen = $sales_order->agen;
        return view('sales_order.detail',compact('sales_order','agen'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sales_order = SalesOrder::findOrFail($id);
        $agen = $sales_order->agen;
        $status = false;
        $result = DeliveryOrder::where('sales_order_id',$id)->first();
        if ($result) {
            $status = true;
        }
        return view('sales_order.edit',compact('sales_order','agen','status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sales_order = SalesOrder::findOrFail($id);
        $new_customer = Customer::findOrFail($request->customer_id);
        $old_customer = Customer::findOrFail($sales_order->customer_id);
        $request->validate([
            'sales_order_number'=>'required',
            'customer_id'=>'required'
        ]);

        $sales_order->update([
            'sales_order_number'=>$request->sales_order_number,
            'customer_id'=>$request->customer_id
        ]);

        if ($new_customer->id != $old_customer->id) {
            $old_customer->update([
                'coupon'=>($old_customer->coupon - 1)
            ]);
            $new_customer->update([
                'coupon'=>($new_customer->coupon + 1)
            ]);
        }

        return redirect()->back()->with('status','successfully Updated Sales Order');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sales_order = SalesOrder::findOrFail($id);
        $customer = $sales_order->customer;
        $customer->update([
            'coupon'=>($customer->coupon - 1)
        ]);
        $sales_order->delete();

        return redirect()->back()->with('status','successfully Deleted Sales Order');
    }

    private function sendNotif($message, $title, $fcm_token)
    {
        $client = new Client();

        // headers
        $headers  = [
            'Authorization'   =>  'key=AAAAI51BmkM:APA91bHi553h03fliFvw5fN-AWhW1evqqnFzhc3YmnrqI4FBcZh1DhJsMQHQc2hW8GcblxdYyvqR2GzJBEK1vW3V3brsGlriDryBc3A6HArZDbnk4C506AaqjrbTEr7NO72mKKZ-TPkU',
            'Content-Type'    =>  'application/json'
        ];

        // body
        $body = [
            'registration_ids'  =>  $fcm_token,
            'notification'      =>  [
            'body'  =>  $message,
            'title' =>  $title
            ]
      ];
      $response   = $client->post('https://fcm.googleapis.com/fcm/send', ['headers' => $headers, 'json' => $body]);

      return response()->json($response->getBody()->getContents());

    }

    public function push_notif($id)
    {
        $sales_order = SalesOrder::findOrFail($id);
        $title = 'Sales Order';
        $message = "Dari Patra Niaga - Agent. SO No $sales_order->sales_order_number telah terbit";
        $fcm_token = [
            $sales_order->agen->user->fcm_token,
        ];
        $this->sendNotif($message,$title,$fcm_token);

        $message = "SO No $sales_order->sales_order_number telah terbit";
        $fcm_token = [
            $sales_order->customer->user->fcm_token,
        ];
        $this->sendNotif($message,$title,$fcm_token);

        return redirect()->back()->with('status','Successfully send notif sales order '.$sales_order->sales_order_number);
    }
}
