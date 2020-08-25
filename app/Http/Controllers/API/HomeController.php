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

            $user->customer->delivery_order= $user->customer->delivery_order()->sum('quantity');
            $user->customer->delivery_order;
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
            $user->role;
            $user->driver->delivery_order;
            // foreach ($user->driver->delivery as $key => $del) {
            //     $user->driver->delivery[$key]->delivery_date = $del->delivery_at->format('l, d F Y H:i:s');
            //     $user->driver->delivery[$key]->distributor->logo= url('/uploads/' . $del->distributor->logo);
            // }
            $data['user']=$user;
            return response()->json($data, 200);

        }

    }
}
