<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Promo;
use App\Agen;
use App\News;
use App\Event;
use App\User;
use App\DeliveryOrder;
use App\Voucher;
use App\Customer;
use App\SalesOrder;
use App\Driver;
use Carbon\Carbon;


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

        $new_promo = Promo::orderBy('created_at','desc')->limit(6)->get();
        $new_do = DeliveryOrder::orderBy('created_at','desc')->limit(7)->get();

        return view('home',compact('promo','agen','news','event','delivery_orders','total','customer','sales_order','driver','new_promo','new_do'));
    }
    public function chartagen($id)
    {
        return view('agen.chartagen',compact('id'));
    }

    public function datachartagen($id)
    {
        $date = Carbon::now();
        $agen = Agen::where('id',$id)->first();
        $data['label']=[];
        $data['transaction']=[];
        $months=['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $tempTotalPerMonth=[];
        foreach ($months as $key => $month) {
            $tempTotalPerMonth[$key] = 0;
        }
        $totalMonth = 0;

        foreach ($agen->sales_orders as $sales_order ) {
            foreach ($months as $key => $month) {
                $totalMonth = $sales_order->delivery_orders()->where('status', 2)->whereMonth('created_at', $key+1)->whereYear('created_at', $date->year)->sum('quantity');
                $tempTotalPerMonth[$key] += $totalMonth;
            }
        }

        foreach ($months as $key => $month) {
            if ($tempTotalPerMonth[$key] > 0) {
                $data['label'][] = $month;
                $data['transaction'][] = $tempTotalPerMonth[$key];
            }
        }


        return response()->json($data, 200);
    }

    public function chartcustomer($id)
    {
        return view('customer.chartcus',compact('id'));
    }

    public function datachartcustomer($id)
    {
        $date = Carbon::now();
        $customer = Customer::where('id',$id)->first();
        $data['label']=[];
        $data['transaction']=[];
        $months=['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $tempTotalPerMonth=[];
        foreach ($months as $key => $month) {
            $tempTotalPerMonth[$key] = 0;
        }
        $totalMonth = 0;
        foreach ($months as $key => $month) {
            $totalMonth = $customer->delivery_order()->where('status', 2)->whereMonth('created_at', $key+1)->whereYear('created_at', $date->year)->sum('quantity');
            $tempTotalPerMonth[$key] += $totalMonth;
        }

        foreach ($months as $key => $month) {
            if ($tempTotalPerMonth[$key] > 0) {
                $data['label'][] = $month;
                $data['transaction'][] = $tempTotalPerMonth[$key];
            }
        }


        return response()->json($data, 200);
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
                $data['transaction'][] = $sales_order->delivery_orders()->where('status',2)->sum('quantity');
            }

        }

        return response()->json($data, 200);
    }

    public function voucher()
    {
        $vouchers = Voucher::orderBy('created_at','desc')->paginate(10);

        return view('notification.voucher',compact('vouchers'));
    }

    public function do_darat()
    {
        $deliveries = DeliveryOrder::where([['status',2],['shipped_via',0]])->orderBy('updated_at','desc')->paginate(10);

        return view('notification.do_darat',compact('deliveries'));
    }

    public function do_laut()
    {
        $deliveries = DeliveryOrder::where([['status',2],['shipped_via',1]])->orderBy('updated_at','desc')->paginate(10);

        return view('notification.do_laut',compact('deliveries'));
    }
}
