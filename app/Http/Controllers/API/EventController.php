<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
use App\Http\Resources\EventResource;
class EventController extends Controller
{
    public function allevents()
    {
        $events = Event::orderBy('created_at','desc')->get();
        $data =[];
        foreach ($events as $key => $event) {
            $data[]=new EventResource($event);
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
        $data=new EventResource($event);;
        return response()->json($data,200);
    }
}
