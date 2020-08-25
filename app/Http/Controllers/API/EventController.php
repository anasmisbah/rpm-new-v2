<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;

class EventController extends Controller
{
    public function allevents()
    {
        $events = Event::all();
        $data =[];
        foreach ($events as $key => $event) {
            $data[]=[
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

        return response()->json($data,200);
    }

    public function detail($id)
    {
        $event = Event::where('id',$id)->first();
        if (!$event) {
                return response()->json([
                    'status'=>false,
                    'message'=>'Event not found'
                ],404);
        }
        $view = $event->view;
        $event->update([
            'view'=>$view+1
        ]);
        $data=[
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
        return response()->json($data,200);
    }
}
