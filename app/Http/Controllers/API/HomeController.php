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
                    "created_at"=>$sales_order->created_at->format('d F Y') ,
                    "updated_at"=>$sales_order->updated_at->format('d F Y'),
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
                "created_at"=> $user->created_at->format('d F Y'),
                "updated_at"=> $user->updated_at->format('d F Y'),
                'agen'=>[
                    "id"=> $agen->id,
                    "name"=> $agen->name ,
                    "address"=> $agen->address,
                    "npwp"=> $agen->npwp ,
                    "phone"=> $agen->phone ,
                    "website"=> $agen->website ,
                    "logo"=> url('/uploads/' . $agen->logo) ,
                    "user_id"=> $agen->user_id ,
                    "created_at"=> $agen->created_at->format('d F Y') ,
                    "updated_at"=> $agen->updated_at->format('d F Y') ,
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
            $sum_delivery_order= 0;
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
                    "created_at"=>$sales_order->created_at->format('d F Y') ,
                    "updated_at"=>$sales_order->updated_at->format('d F Y'),
                    "delivery_orders"=>[]
                ];
                foreach ($sales_order->delivery_orders->sortByDesc('id') as $delivery_order) {
                    $item['delivery_orders'][] = new DeliveryOrderResource($delivery_order);
                    if ($delivery_order->status == 3) {
                        $sum_delivery_order+=$delivery_order->quantity;
                    }
                }
                $sales_orders[] = $item;
            }

            $vouchers =$user->customer->vouchers()->orderBy('created_at','desc')->get();
            $data_vouchers = [];
            foreach ($vouchers as $key => $voucher) {
                $data_vouchers[] = [
                    'id'=>$voucher->id,
                    'promo_id'=>$voucher->promo_id,
                    'customer_id'=>$voucher->customer_id,
                    'created_at'=>$voucher->created_at->format('d F Y'),
                    'promo'=> new  PromoResource($voucher->promo)
                ];
            }
            $data['user'] = [
                "id"=> $user->id,
                "email"=> $user->email,
                "role_id"=> $user->role_id,
                "fcm_token"=> $user->fcm_token,
                "created_at"=> $user->created_at->format('d F Y'),
                "updated_at"=> $user->updated_at->format('d F Y'),
                'customer'=>[
                    "id"=> $customer->id,
                    "name"=> $customer->name ,
                    "address"=> $customer->address,
                    "npwp"=> $customer->npwp ,
                    "phone"=> $customer->phone ,
                    "website"=> $customer->website ,
                    "reward"=> $customer->reward ,
                    "logo"=> url('/uploads/' . $customer->logo) ,
                    "user_id"=> $customer->user_id ,
                    "created_at"=> $customer->created_at->format('d F Y') ,
                    "updated_at"=> $customer->updated_at->format('d F Y') ,
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
            $sales_orders = $agen->sales_orders;

            $dos = $user->driver->delivery_order()->orderBy('created_at','desc')->get();
            $delivery_orders = [];
            foreach ($dos as $key => $delivery_order) {
                $delivery_orders[] = new DeliveryOrderResource($delivery_order);
            }
            $delivery_orders_ready = [];
            foreach ($sales_orders->sortByDesc('id') as $sales_order) {
                foreach ($sales_order->delivery_orders()->orderBy('created_at','desc')->get() as $delivery_order) {
                    if (($route == $delivery_order->shipped_via || $delivery_order->shipped_via == 2) && $delivery_order->status == 0) {
                        $delivery_orders_ready[] = new DeliveryOrderResource($delivery_order);
                    }
                }
            }

            $data['user'] = [
                "id"=> $user->id,
                "email"=> $user->email,
                "role_id"=> $user->role_id,
                "fcm_token"=> $user->fcm_token,
                "created_at"=> $user->created_at->format('d F Y'),
                "updated_at"=> $user->updated_at->format('d F Y'),
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
                    "created_at"=> $agen->created_at->format('d F Y') ,
                    "updated_at"=> $agen->updated_at->format('d F Y') ,
                ],
                'ready_delivery_order'=>$delivery_orders_ready,
                'delivery_orders'=>$delivery_orders

            ];

            return response()->json($data, 200);
        }
    }
}
