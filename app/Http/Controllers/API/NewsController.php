<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\News;
use App\Event;
class NewsController extends Controller
{
    public function allnews()
    {
        $news = News::all();
        $data = [];
        foreach ($news as $key => $new) {
            $data[]=[
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
        $data=[
            'id'=> $news->id,
            'title'=> $news->title,
            'image'=> url('/uploads/' . $news->image),
            'url'=> url('/news/read/'.$news->slug),
            'view'=>$news->view,
            'created_at'=>$news->created_at->format('d F Y'),
            'created_by'=>$news->createdby->admin->name,
            'category'=>$news->category->makeHidden(['created_at','updated_at','pivot','slug'])
        ];
        return response()->json($data,200);
    }
}
