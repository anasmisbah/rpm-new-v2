<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agen;
use App\SalesOrder;
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
        $so = SalesOrder::select(['id','sales_order_number','created_at'])
                    ->where('agen_id',$id);

        $dataTable = DataTables::of($so)
        ->addIndexColumn()
        ->editColumn('created_at', function ($data) {
            return $data->created_at->dayName.", ".$data->created_at->day." ".$data->created_at->monthName." ".$data->created_at->year.' | '.$data->created_at->format('H:i').' WITA';
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
        ]);

        $sales_order = SalesOrder::create([
            'sales_order_number'=>$request->sales_order_number,
            'agen_id'=>$agen->id
        ]);


        $title = 'Sales Order';
        $message = "Dari Patra Niaga - Agent. SO No $sales_order->sales_order_number telah terbit";
        $fcm_token[] = $agen->user->fcm_token;
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
        return view('sales_order.edit',compact('sales_order','agen'));
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
        $request->validate([
            'sales_order_number'=>'required',
        ]);

        $sales_order->update([
            'sales_order_number'=>$request->sales_order_number,
        ]);

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
}
