<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agen;
use App\SalesOrder;
use GuzzleHttp\Client;
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
        $message = "Agen {$agen->name}" . 'Sales Order '.$sales_order.' Telah dibuat';
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
