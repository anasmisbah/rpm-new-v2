<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\News;
use App\Event;
use App\Http\Resources\NewsResource;
class NewsController extends Controller
{
    public function allnews()
    {
        $news = News::orderBy('created_at','desc')->get();
        $data = [];
        foreach ($news as $key => $new) {
            $data[]= new NewsResource($new);
        }
        return response()->json($data,200);
    }

    public function detail($id)
    {
        $news = News::where('id',$id)->first();
        if (!$news) {
                return response()->json([
                    'status'=>false,
                    'message'=>'news not found'
                ],404);
        }
        $view = $news->view;
        $news->update([
            'view'=>$view+1
        ]);
        $data= new NewsResource($news);;
        return response()->json($data,200);
    }
}
