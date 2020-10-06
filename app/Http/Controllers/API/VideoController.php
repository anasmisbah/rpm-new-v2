<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Video;
use App\Http\Resources\VideoResource;
class VideoController extends Controller
{
    public function allvideos()
    {
        $videos = Video::orderBy('created_at','desc')->get();
        $data=[];
        foreach ($videos as $key => $video) {
            $data[]=new VideoResource($video);
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
        $data=new VideoResource($video);;
        return response()->json($data,200);
    }
}
