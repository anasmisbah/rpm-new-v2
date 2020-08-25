<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Promo;
use App\Agen;
use App\News;
use App\Event;
use App\User;
use App\DeliveryOrder;
use App\Coupon;
use App\Voucher;
use App\Delivery;
use App\Customer;
use App\SalesOrder;
use App\Driver;

class HomeController extends Controller
{
    public function index()
    {
        $promo = Promo::count();
        $agen = Agen::count();
        $news = News::count();
        $event = Event::count();
        $delivery_orders = DeliveryOrder::count();
        $sales_order = SalesOrder::count();
        $customer = Customer::count();
        $driver = Driver::count();

        $total = DeliveryOrder::sum('quantity');

        return view('home',compact('promo','agen','news','event','delivery_orders','total','customer','sales_order','driver'));
    }

    public function chart()
    {
        $agens = Agen::all();

        $data['label']=[];
        $data['transaction']=[];
        $data['revenue']=[];
        foreach ($agens as  $agen) {
            $data['label'][] = $agen->name;
            foreach ($agen->sales_orders as $sales_order ) {
                $data['transaction'][] = $sales_order->delivery_orders()->sum('quantity');
            }

        }

        return response()->json($data, 200);
    }

    public function voucher()
    {
        $vouchers = Voucher::orderBy('created_at','desc')->get();

        return view('voucher',compact('vouchers'));
    }

    public function delivery()
    {
        $deliveries = Delivery::orderBy('created_at','desc')->get();

        return view('delivery',compact('deliveries'));
    }
}
