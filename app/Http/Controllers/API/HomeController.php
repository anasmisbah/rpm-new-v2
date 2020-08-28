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
class HomeController extends Controller
{
    public function home()
    {
        $news = News::limit(8)->get();
        $data = [];
        $data['news']=[];
        foreach ($news as $key => $new) {
            $data['news'][]=[
                'id'=> $new->id,
                'title'=> $new->title,
                'image'=> url('/uploads/' . $new->image),
                'url'=> url('/news/read/'.$new->slug),
                'view'=>$new->view,
                'created_at'=>$new->created_at->format('d F Y'),
                'created_by'=>$new->createdby->admin->name,
                'category'=>$new->category->makeHidden(['created_at','updated_at','pivot','slug'])

            ];
        }

        $events = Event::limit(8)->get();
        $data['event']=[];
        foreach ($events as $key => $event) {
            $data['event'][]=[
                'id'=> $event->id,
                'title'=> $event->title,
                'start'=>$event->startdate->format('l, d F Y'),
                'end'=>$event->enddate->format('l, d F Y'),
                'image'=> url('/uploads/' . $event->image),
                'url'=> url('/event/read/'.$event->slug),
                'view'=>$event->view,
                'created_at'=>$event->created_at->format('d F Y'),
                'created_by'=>$event->createdby->admin->name,
                'category'=>$event->category->makeHidden(['created_at','updated_at','pivot','slug'])
            ];
        }

        $promos = Promo::where('status','hot')->limit(8)->get();
        $data['hot']=[];
        foreach ($promos as $key => $promo) {
            $data['hot'][]=[
                'id'=> $promo->id,
                'title'=> $promo->name,
                'image'=> url('/uploads/' . $promo->image),
                'description'=> $promo->description,
                'terms'=> $promo->terms,
                'point'=>$promo->point,
                'total'=>$promo->total,
                'view'=>$promo->view,
                'status'=>$promo->status,
                'created_at'=>$promo->created_at->format('d F Y'),
                'created_by'=>$promo->createdby->admin->name,
            ];
        }

        $promos = Promo::where('status','normal')->limit(8)->get();
        $data['normal']=[];
        foreach ($promos as $key => $promo) {
            $data['normal'][]=[
                'id'=> $promo->id,
                'title'=> $promo->name,
                'image'=> url('/uploads/' . $promo->image),
                'description'=> $promo->description,
                'terms'=> $promo->terms,
                'point'=>$promo->point,
                'total'=>$promo->total,
                'view'=>$promo->view,
                'status'=>$promo->status,
                'created_at'=>$promo->created_at->format('d F Y'),
                'created_by'=>$promo->createdby->admin->name,
            ];
        }
        $videos = Video::limit(8)->get();
        $data['videos']=[];
        foreach ($videos as $key => $video) {
            $data['videos'][]=[
                'id'=> $video->id,
                'title'=> $video->title,
                'url'=> $video->url,
                'image'=> url('/uploads/' . $video->image),
                'created_at'=>$video->created_at->format('d F Y'),
            ];
        }
        $company = Company::first();
        $company->profile =  url('/uploads/' . $company->profile );
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

            $user->agen->logo = url('/uploads/' . $user->agen->logo);
            $user->role;
            $user->agen->sales_orders;
            foreach ($user->agen->sales_orders as $key => $sales_order) {
                $delivery_orders = [];
                foreach ($sales_order->delivery_orders as $delivery_order) {
                        $delivery_orders[] = new DeliveryOrderResource($delivery_order);
                }
                $user->agen->sales_orders[$key]['delivery_order'] =$delivery_orders;
            }

            $user->agen->logo= url('/uploads/' . $user->agen->logo);
            $news = News::limit(8)->get();
            $data['user']=$user;
            $data['news']=[];
            foreach ($news as $key => $new) {
                $data['news'][]=[
                    'id'=> $new->id,
                    'title'=> $new->title,
                    'image'=> url('/uploads/' . $new->image),
                    'url'=> url('/news/read/'.$new->slug),
                    'view'=>$new->view,
                    'created_at'=>$new->created_at->format('d F Y'),
                    'created_by'=>$new->createdby->admin->name,
                    'category'=>$new->category->makeHidden(['created_at','updated_at','pivot','slug'])

                ];
            }

            $events = Event::limit(8)->get();
            $data['event']=[];
            foreach ($events as $key => $event) {
                $data['event'][]=[
                    'id'=> $event->id,
                    'title'=> $event->title,
                    'image'=> url('/uploads/' . $event->image),
                    'url'=> url('/event/read/'.$event->slug),
                    'view'=>$event->view,
                    'start'=>$event->startdate->format('l, d F Y'),
                    'end'=>$event->enddate->format('l, d F Y'),
                    'created_at'=>$event->created_at->format('d F Y'),
                    'created_by'=>$event->createdby->admin->name,
                    'category'=>$event->category->makeHidden(['created_at','updated_at','pivot','slug'])
                ];
            }

            $promos = Promo::where('status','hot')->limit(8)->get();
            $data['hot']=[];
            foreach ($promos as $key => $promo) {
                $data['hot'][]=[
                    'id'=> $promo->id,
                    'title'=> $promo->name,
                    'image'=> url('/uploads/' . $promo->image),
                    'description'=> $promo->description,
                    'terms'=> $promo->terms,
                    'point'=>$promo->point,
                    'total'=>$promo->total,
                    'view'=>$promo->view,
                    'status'=>$promo->status,
                    'created_at'=>$promo->created_at->format('d F Y'),
                    'created_by'=>$promo->createdby->admin->name,
                ];
            }

            $promos = Promo::where('status','normal')->limit(8)->get();
            $data['normal']=[];
            foreach ($promos as $key => $promo) {
                $data['normal'][]=[
                    'id'=> $promo->id,
                    'title'=> $promo->name,
                    'image'=> url('/uploads/' . $promo->image),
                    'description'=> $promo->description,
                    'terms'=> $promo->terms,
                    'point'=>$promo->point,
                    'total'=>$promo->total,
                    'view'=>$promo->view,
                    'status'=>$promo->status,
                    'created_at'=>$promo->created_at->format('d F Y'),
                    'created_by'=>$promo->createdby->admin->name,
                ];
            }
            $videos = Video::limit(8)->get();
            $data['videos']=[];
            foreach ($videos as $key => $video) {
                $data['videos'][]=[
                    'id'=> $video->id,
                    'title'=> $video->title,
                    'url'=> $video->url,
                    'image'=> url('/uploads/' . $video->image),
                    'created_at'=>$video->created_at->format('d F Y'),
                ];
            }
            $company = Company::first();
            $company->profile =  url('/uploads/' . $company->profile );
            $company->profiledownload = url('/company/profile/download');
            $data['company'] = $company;
            $data['contact'] = $company;
            return response()->json($data, 200);

        }elseif ($user->role_id ==4) {

            $user->customer->logo = url('/uploads/' . $user->customer->logo);
            $user->role;
            $user->customer->coupon = $user->customer->coupons()->count();

            $user->customer->sum_delivery_order= $user->customer->delivery_order()->sum('quantity');
            foreach ($user->customer->delivery_order as $key => $delivery_order) {
                $user->customer->delivery_order[$key] = new DeliveryOrderResource($delivery_order);
            }
            $user->customer->coupons;
            $user->customer->vouchers;
            $news = News::limit(8)->get();
            $data['user']=$user;
            $data['news']=[];
            foreach ($news as $key => $new) {
                $data['news'][]=[
                    'id'=> $new->id,
                    'title'=> $new->title,
                    'image'=> url('/uploads/' . $new->image),
                    'url'=> url('/news/read/'.$new->slug),
                    'view'=>$new->view,
                    'created_at'=>$new->created_at->format('d F Y'),
                    'created_by'=>$new->createdby->admin->name,
                    'category'=>$new->category->makeHidden(['created_at','updated_at','pivot','slug'])

                ];
            }

            $events = Event::limit(8)->get();
            $data['event']=[];
            foreach ($events as $key => $event) {
                $data['event'][]=[
                    'id'=> $event->id,
                    'title'=> $event->title,
                    'image'=> url('/uploads/' . $event->image),
                    'url'=> url('/event/read/'.$event->slug),
                    'view'=>$event->view,
                    'start'=>$event->startdate->format('l, d F Y'),
                    'end'=>$event->enddate->format('l, d F Y'),
                    'created_at'=>$event->created_at->format('d F Y'),
                    'created_by'=>$event->createdby->admin->name,
                    'category'=>$event->category->makeHidden(['created_at','updated_at','pivot','slug'])
                ];
            }

            $promos = Promo::where('status','hot')->limit(8)->get();
            $data['hot']=[];
            foreach ($promos as $key => $promo) {
                $data['hot'][]=[
                    'id'=> $promo->id,
                    'title'=> $promo->name,
                    'image'=> url('/uploads/' . $promo->image),
                    'description'=> $promo->description,
                    'terms'=> $promo->terms,
                    'point'=>$promo->point,
                    'total'=>$promo->total,
                    'view'=>$promo->view,
                    'status'=>$promo->status,
                    'created_at'=>$promo->created_at->format('d F Y'),
                    'created_by'=>$promo->createdby->admin->name,
                ];
            }

            $promos = Promo::where('status','normal')->limit(8)->get();
            $data['normal']=[];
            foreach ($promos as $key => $promo) {
                $data['normal'][]=[
                    'id'=> $promo->id,
                    'title'=> $promo->name,
                    'image'=> url('/uploads/' . $promo->image),
                    'description'=> $promo->description,
                    'terms'=> $promo->terms,
                    'point'=>$promo->point,
                    'total'=>$promo->total,
                    'view'=>$promo->view,
                    'status'=>$promo->status,
                    'created_at'=>$promo->created_at->format('d F Y'),
                    'created_by'=>$promo->createdby->admin->name,
                ];
            }
            $videos = Video::limit(8)->get();
            $data['videos']=[];
            foreach ($videos as $key => $video) {
                $data['videos'][]=[
                    'id'=> $video->id,
                    'title'=> $video->title,
                    'url'=> $video->url,
                    'image'=> url('/uploads/' . $video->image),
                    'created_at'=>$video->created_at->format('d F Y'),
                ];
            }
            $company = Company::first();
            $company->profile =  url('/uploads/' . $company->profile );
            $company->profiledownload = url('/company/profile/download');
            $data['company'] = $company;
            $data['contact'] = $company;
            return response()->json($data, 200);

        }

        else{

            $user->driver->avatar = url('/uploads/' . $user->driver->avatar);
            $user->driver->agen->logo = url('/uploads/' . $user->driver->agen->logo);
            $user->role;
            $user->driver->delivery_order;
            foreach ($user->driver->delivery_order as $key => $delivery_order) {
                $user->driver->delivery_order[$key] = new DeliveryOrderResource($delivery_order);
            }
            $data['user']=$user;

            $agen = $user->driver->agen;
            $route = $user->driver->route;
            $sales_orders = $agen->sales_orders;

            $delivery_orders = [];
            foreach ($sales_orders as $sales_order) {
                foreach ($sales_order->delivery_orders as $delivery_order) {
                    if (($route == $delivery_order->shipped_via || $delivery_order->shipped_via == 2) && $delivery_order->status == 0) {
                        $delivery_orders[] = new DeliveryOrderResource($delivery_order);
                    }
                }
            }
            $data['ready_delivery_order']=$delivery_orders;
            return response()->json($data, 200);

        }

    }
}
