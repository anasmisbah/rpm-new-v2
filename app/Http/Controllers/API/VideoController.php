<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Video;
class VideoController extends Controller
{
    public function allvideos()
    {
        $videos = Video::limit(8)->get();
        $data=[];
        foreach ($videos as $key => $video) {
            $data[]=[
                'id'=> $video->id,
                'title'=> $video->title,
                'url'=> $video->url,
                'image'=> url('/uploads/' . $video->image),
                'created_at'=>$video->created_at->format('d F Y'),
            ];
        }
        return response()->json($data,200);
    }
    public function detail($id)
    {
        $video = Video::where('id',$id)->first();
        if (!$video) {
                return response()->json([
                    'status'=>false,
                    'message'=>'video not found'
                ],404);
        }
        $data=[
            'id'=> $video->id,
            'title'=> $video->title,
            'image'=> url('/uploads/' . $video->image),
            'url'=> $video->url,
            'created_at'=>$video->created_at->format('d F Y'),
        ];
        return response()->json($data,200);
    }
}
