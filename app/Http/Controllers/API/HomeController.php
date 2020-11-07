<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\News;
use App\Event;
use App\Promo;
use App\Company;
use App\Video;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DeliveryOrder as DeliveryOrderResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\NewsResource;
use App\Http\Resources\PromoResource;
use App\Http\Resources\VideoResource;
use App\Http\Resources\DriverResource;

class HomeController extends Controller
{
    public function home()
    {
        $news = News::orderBy('created_at', 'desc')->limit(8)->get();
        $data = [];
        $data['news']=[];
        foreach ($news as $key => $new) {
            $data['news'][]=new NewsResource($new);
        }

        $events = Event::orderBy('created_at', 'desc')->limit(8)->get();
        $data['event']=[];
        foreach ($events as $key => $event) {
            $data['event'][]=new EventResource($event);
        }

        $promos = Promo::orderBy('created_at', 'desc')->where('status', 'hot')->limit(8)->get();
        $data['hot']=[];
        foreach ($promos as $key => $promo) {
            $data['hot'][]=new PromoResource($promo);
        }

        $promos = Promo::where('status', 'normal')->orderBy('created_at', 'desc')->limit(8)->get();
        $data['normal']=[];
        foreach ($promos as $key => $promo) {
            $data['normal'][]= new PromoResource($promo);
        }
        $videos = Video::orderBy('created_at', 'desc')->limit(8)->get();
        $data['videos']=[];
        foreach ($videos as $key => $video) {
            $data['videos'][]=new VideoResource($video);
        }
        $company = Company::first();
        $company->profile =  url('/uploads/' . $company->profile);
        $company->profiledownload = url('/company/profile/download');
        $data['company'] = $company;
        $data['contact'] = $company;
        return response()->json($data, 200);
    }

    public function homelogin()
    {
        $data = [];
        $user = Auth::user();
        if ($user->role_id ==3) {
            $agen = $user->agen;
            $sales_orders = [];

            $total_notif_do = 0;
            foreach ($user->agen->sales_orders->sortByDesc('id') as $key => $sales_order) {
                $delivery_orders = [];
                $item = [
                    "id"=>$sales_order->id,
                    "sales_order_number"=>$sales_order->sales_order_number,
                    "customer"=>$sales_order->customer->name,
                    "customer_id"=>$sales_order->customer_id,
                    "agen_id"=>$sales_order->agen_id,
                    "agen"=>$sales_order->agen->name,
                    'created_at'=>$sales_order->created_at->dayName.", ".$sales_order->created_at->day." ".$sales_order->created_at->monthName." ".$sales_order->created_at->year,
                    "updated_at"=> $sales_order->updated_at->dayName.", ".$sales_order->updated_at->day." ".$sales_order->updated_at->monthName." ".$sales_order->updated_at->year,
                    "delivery_orders"=>[]
                ];
                foreach ($sales_order->delivery_orders->sortByDesc('id') as $delivery_order) {
                    $item['delivery_orders'][] = new DeliveryOrderResource($delivery_order);
                    if ($delivery_order->status == 0) {
                        $total_notif_do++;
                    }
                }
                $sales_orders[] = $item;
            }

            $data['user'] = [
                "id"=> $user->id,
                "email"=> $user->email,
                "role_id"=> $user->role_id,
                "fcm_token"=> $user->fcm_token,
                'created_at'=>$user->created_at->dayName.", ".$user->created_at->day." ".$user->created_at->monthName." ".$user->created_at->year,
                "updated_at"=> $user->updated_at->dayName.", ".$user->updated_at->day." ".$user->updated_at->monthName." ".$user->updated_at->year,
                'agen'=>[
                    "id"=> $agen->id,
                    "name"=> $agen->name ,
                    "address"=> $agen->address,
                    "npwp"=> $agen->npwp ,
                    "phone"=> $agen->phone ,
                    "website"=> $agen->website ,
                    "transaction"=>$agen->transaction,
                    "member"=>$agen->card->name,
                    "card_image"=>url('/uploads/' . $agen->card->image),
                    "logo"=> url('/uploads/' . $agen->logo) ,
                    "user_id"=> $agen->user_id ,
                    'created_at'=>$agen->created_at->dayName.", ".$agen->created_at->day." ".$agen->created_at->monthName." ".$agen->created_at->year,
                    "updated_at"=> $agen->updated_at->dayName.", ".$agen->updated_at->day." ".$agen->updated_at->monthName." ".$agen->updated_at->year,
                    "sales_order"=>$sales_orders
                ]
            ];

            // $data['user']=$user;
            $news = News::orderBy('created_at', 'desc')->limit(8)->get();
            $data['news']=[];
            foreach ($news as $key => $new) {
                $data['news'][]=new NewsResource($new);
            }
            $events = Event::orderBy('created_at', 'desc')->limit(8)->get();
            $data['event']=[];
            foreach ($events as $key => $event) {
                $data['event'][]=new EventResource($event);
            }
            $promos = Promo::orderBy('created_at', 'desc')->where('status', 'hot')->limit(8)->get();
            $data['hot']=[];
            foreach ($promos as $key => $promo) {
                $data['hot'][]=new PromoResource($promo);
            }
            $promos = Promo::where('status', 'normal')->orderBy('created_at', 'desc')->limit(8)->get();
            $data['normal']=[];
            foreach ($promos as $key => $promo) {
                $data['normal'][]=new PromoResource($promo);
            }
            $videos = Video::orderBy('created_at', 'desc')->limit(8)->get();
            $data['videos']=[];
            foreach ($videos as $key => $video) {
                $data['videos'][]=new VideoResource($video);
            }
            $company = Company::first();
            $company->profile =  url('/uploads/' . $company->profile);
            $company->profiledownload = url('/company/profile/download');
            $data['company'] = $company;
            $data['contact'] = $company;
            $data['total_notif_do'] = $total_notif_do;
            return response()->json($data, 200);
        } elseif ($user->role_id ==4) {
            $customer = $user->customer;
            $user->role;
            $sum_delivery_order= $customer->transaction;
            // $coupons = $user->customer->coupons()->orderBy('created_at','desc')->get();
            // $data_coupons = [];
            // foreach ($coupons as $key => $coupon) {
            //     $data_coupons[] = [
            //         "id"=> $coupon->id,
            //         "code_coupon"=> $coupon->code_coupon,
            //         "customer_id"=> $coupon->customer_id,
            //         'created_at'=>$coupon->created_at->format('d F Y'),
            //         "updated_at"=> $coupon->updated_at->format('d F Y'),
            //     ];
            // }

            $sales_orders = [];
            foreach ($user->customer->sales_orders->sortByDesc('id') as $key => $sales_order) {
                $delivery_orders = [];
                $item = [
                    "id"=>$sales_order->id,
                    "sales_order_number"=>$sales_order->sales_order_number,
                    "customer"=>$sales_order->customer->name,
                    "customer_id"=>$sales_order->customer_id,
                    "agen_id"=>$sales_order->agen_id,
                    "agen"=>$sales_order->agen->name,
                    'created_at'=>$sales_order->created_at->dayName.", ".$sales_order->created_at->day." ".$sales_order->created_at->monthName." ".$sales_order->created_at->year,
                    "updated_at"=> $sales_order->updated_at->dayName.", ".$sales_order->updated_at->day." ".$sales_order->updated_at->monthName." ".$sales_order->updated_at->year,
                    "delivery_orders"=>[]
                ];
                foreach ($sales_order->delivery_orders->sortByDesc('id') as $delivery_order) {
                    $item['delivery_orders'][] = new DeliveryOrderResource($delivery_order);
                }
                $sales_orders[] = $item;
            }

            $vouchers =$user->customer->vouchers()->orderBy('created_at', 'desc')->get();
            $data_vouchers = [];
            foreach ($vouchers as $key => $voucher) {
                $data_vouchers[] = [
                    'id'=>$voucher->id,
                    'promo_id'=>$voucher->promo_id,
                    'customer_id'=>$voucher->customer_id,
                    'created_at'=>$voucher->created_at->dayName.", ".$voucher->created_at->day." ".$voucher->created_at->monthName." ".$voucher->created_at->year,
                    'promo'=> new  PromoResource($voucher->promo)
                ];
            }
            $data['user'] = [
                "id"=> $user->id,
                "email"=> $user->email,
                "role_id"=> $user->role_id,
                "fcm_token"=> $user->fcm_token,
                'created_at'=>$user->created_at->dayName.", ".$user->created_at->day." ".$user->created_at->monthName." ".$user->created_at->year,
                "updated_at"=> $user->updated_at->dayName.", ".$user->updated_at->day." ".$user->updated_at->monthName." ".$user->updated_at->year,
            'customer'=>[
                    "id"=> $customer->id,
                    "name"=> $customer->name ,
                    "address"=> $customer->address,
                    "npwp"=> $customer->npwp ,
                    "phone"=> $customer->phone ,
                    "website"=> $customer->website ,
                    "reward"=> $customer->reward ,
                    "member"=>$customer->card->name,
                    "card_image"=>url('/uploads/' . $customer->card->image),
                    "logo"=> url('/uploads/' . $customer->logo) ,
                    "user_id"=> $customer->user_id ,
                    'created_at'=>$customer->created_at->dayName.", ".$customer->created_at->day." ".$customer->created_at->monthName." ".$customer->created_at->year,
                    "updated_at"=> $customer->updated_at->dayName.", ".$customer->updated_at->day." ".$customer->updated_at->monthName." ".$customer->updated_at->year,
                    "coupon"=>$customer->coupon,
                    "sum_delivery_order"=>$sum_delivery_order,
                    "sales_orders"=>$sales_orders,
                    'vouchers'=>$data_vouchers
                ]
            ];

            $news = News::limit(8)->get();
            $news = News::orderBy('created_at', 'desc')->limit(8)->get();
            $data['news']=[];
            foreach ($news as $key => $new) {
                $data['news'][]=new NewsResource($new);
            }
            $events = Event::orderBy('created_at', 'desc')->limit(8)->get();
            $data['event']=[];
            foreach ($events as $key => $event) {
                $data['event'][]=new EventResource($event);
            }
            $promos = Promo::orderBy('created_at', 'desc')->where('status', 'hot')->limit(8)->get();
            $data['hot']=[];
            foreach ($promos as $key => $promo) {
                $data['hot'][]=new PromoResource($promo);
            }
            $promos = Promo::where('status', 'normal')->orderBy('created_at', 'desc')->limit(8)->get();
            $data['normal']=[];
            foreach ($promos as $key => $promo) {
                $data['normal'][]=new PromoResource($promo);
            }
            $videos = Video::orderBy('created_at', 'desc')->limit(8)->get();
            $data['videos']=[];
            foreach ($videos as $key => $video) {
                $data['videos'][]=new VideoResource($video);
            }
            $company = Company::first();
            $company->profile =  url('/uploads/' . $company->profile);
            $company->profiledownload = url('/company/profile/download');
            $data['company'] = $company;
            $data['contact'] = $company;
            return response()->json($data, 200);
        } else {
            $agen = $user->driver->agen;
            $route = $user->driver->route;

            $dos = $user->driver->delivery_order()->orderBy('created_at', 'desc')->get();
            $delivery_orders = [];
            $delivery_orders_ready = [];
            foreach ($dos as $key => $delivery_order) {
                $delivery_orders[] = new DeliveryOrderResource($delivery_order);
                if ($delivery_order->status == 1) {
                    $delivery_orders_ready[] = new DeliveryOrderResource($delivery_order);
                }
            }
            $data['user'] = [
                "id"=> $user->id,
                "email"=> $user->email,
                "role_id"=> $user->role_id,
                "fcm_token"=> $user->fcm_token,
                'created_at'=>$user->created_at->dayName.", ".$user->created_at->day." ".$user->created_at->monthName." ".$user->created_at->year,
                "updated_at"=> $user->updated_at->dayName.", ".$user->updated_at->day." ".$user->updated_at->monthName." ".$user->updated_at->year,
                'driver'=> new DriverResource($user->driver),
                'agen'=>[
                    "id"=> $agen->id,
                    "name"=> $agen->name ,
                    "address"=> $agen->address,
                    "npwp"=> $agen->npwp ,
                    "phone"=> $agen->phone ,
                    "website"=> $agen->website ,
                    "logo"=> url('/uploads/' . $agen->logo) ,
                    "user_id"=> $agen->user_id ,
                    'created_at'=>$agen->created_at->dayName.", ".$agen->created_at->day." ".$agen->created_at->monthName." ".$agen->created_at->year,
                    "updated_at"=> $agen->updated_at->dayName.", ".$agen->updated_at->day." ".$agen->updated_at->monthName." ".$agen->updated_at->year,
                ],
                'ready_delivery_order'=>$delivery_orders_ready,
                'delivery_orders'=>$delivery_orders

            ];

            return response()->json($data, 200);
        }
    }
}
