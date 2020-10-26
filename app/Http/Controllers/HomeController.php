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

        $total = Agen::sum('transaction');

        $new_promo = Promo::orderBy('created_at','desc')->limit(6)->get();
        $new_do = DeliveryOrder::orderBy('created_at','desc')->limit(7)->get();

        $top10customer = Customer::orderBy('reward','desc')->limit(8)->get();

        return view('home',compact('promo','agen','news','event','delivery_orders','total','customer','sales_order','driver','new_promo','new_do','top10customer'));
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
                $totalMonth = $sales_order->delivery_orders()->where('status', 3)->whereMonth('created_at', $key+1)->whereYear('created_at', $date->year)->sum('quantity');
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
        foreach ($customer->sales_orders as $sales_order) {
            foreach ($months as $key => $month) {
                $totalMonth = $sales_order->delivery_orders()->where('status', 3)->whereMonth('created_at', $key+1)->whereYear('created_at', $date->year)->sum('quantity');
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

    public function dataChartMonthly()
    {
        $date = Carbon::now();
        $data['label']=['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $data['transaction']=[0,0,0,0,0,0,0,0,0,0,0,0];
        for ($i=0; $i < count($data['label']); $i++) {
            $totalMonth = DeliveryOrder::whereYear('created_at', $date->year)->whereMonth('created_at', $i+1)->count();
            $data['transaction'][$i] = $totalMonth;
        }

        $lasDate = DeliveryOrder::select('created_at')->orderBy('created_at','desc')->first();
        $fisrtDate= Carbon::create($lasDate->created_at->year, 1, 1);
        $data['datefrom'] = $fisrtDate->day." ".$fisrtDate->monthName." ".$fisrtDate->year." - ".$lasDate->created_at->day." ".$lasDate->created_at->monthName." ".$lasDate->created_at->year;
        return response()->json($data, 200);
    }

    public function dataChartRoute()
    {
        $data['transaction'][] = DeliveryOrder::where('shipped_via',0)->count();
        $data['transaction'][] = DeliveryOrder::where('shipped_via',1)->count();
        $data['transaction'][] = DeliveryOrder::where('shipped_via',2)->count();
        return response()->json($data, 200);
    }

    public function chart1()
    {
        $agens = Agen::all();

        $agensCount = count($agens);

        $divide2 = $agensCount/2;

        $data['label']=[];
        $data['transaction']=[];
        $data['revenue']=[];
        for ($i=0; $i < $divide2; $i++) {
            $data['label'][] = $agens[$i]->name;
            $data['transaction'][] = $agens[$i]->transaction;
        }

        return response()->json($data, 200);
    }
    public function chart2()
    {
        $agens = Agen::all();

        $agensCount = count($agens);

        $divide2 = $agensCount/2;

        $data['label']=[];
        $data['transaction']=[];
        $data['revenue']=[];
        for ($i=$divide2; $i < $agensCount; $i++) {
            $data['label'][] = $agens[$i]->name;
            $data['transaction'][] = $agens[$i]->transaction;
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
        $deliveries = DeliveryOrder::where([['status',3],['shipped_via',0]])->orderBy('updated_at','desc')->paginate(10);

        return view('notification.do_darat',compact('deliveries'));
    }

    public function do_laut()
    {
        $deliveries = DeliveryOrder::where([['status',3],['shipped_via',1]])->orderBy('updated_at','desc')->paginate(10);

        return view('notification.do_laut',compact('deliveries'));
    }
}
