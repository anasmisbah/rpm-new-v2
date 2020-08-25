<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;
class VideoController extends Controller
{
            /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::all();

        return view('video.index',compact('videos'));    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('video.create');    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|max:255',
            'url'=>'required|url',
            'image'=>'required|mimes:jpeg,bmp,png,jpg,ico',
        ]);

        $image='';
        if ($request->file('image')) {
            $image = 'images/'.time().$request->file('image')->getClientOriginalName();
            $request->file('image')->move('uploads/images', $image);
        }

        $video = Video::create([
            'title'=>$request->title,
            'url'=>$request->url,
            'image'=>$image,
        ]);


        return redirect()->back()->with('status','Successfully Added video');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $video = Video::findOrFail($id);
        return view('video.detail',compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $video = Video::findOrFail($id);

        return view('video.edit',compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        $request->validate([
            'title'=>'required|max:255',
            'url'=>'required|url',
        ]);
        if ($request->file('image')) {
            $request->validate([
                'image'=>'mimes:jpeg,bmp,png,jpg,ico',
            ]);
            if (!($video->image == "images/default.jpg") && file_exists('uploads/'.$video->image)) {
                File::delete('uploads/'.$video->image);
            }
            $image = 'images/'.time().$request->file('image')->getClientOriginalName();
            $request->file('image')->move('uploads/images', $image);
            $video->update([
                'image'=> $image
            ]);
        }

        $video->update([
            'title'=>$request->title,
            'url'=>$request->url,
        ]);

        return redirect()->back()->with('status','Successfully Updated video');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        if (!($video->image == "images/default.jpg") && file_exists('uploads/'.$video->image)) {
            File::delete('uploads/'.$video->image);
        }
        $video->delete();

        return redirect()->route('video.index');
    }
}
