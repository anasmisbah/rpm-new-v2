<?php

namespace App\Http\Controllers;

use App\Category;
use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use File;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();

        return view('event.index',compact('events'));    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('event.create',compact('categories'));    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|max:100',
            'description'=>'required|min:10',
            'startdate'=>'required',
            'enddate'=>'required',
            'category'=>'required|array'
        ]);

        $image='images/default.jpg';
        if ($request->file('image')) {
            $request->validate([
                'image'=>'mimes:jpeg,bmp,png,jpg,ico',
            ]);
            $image = 'images/'.time().$request->file('image')->getClientOriginalName();
            $request->file('image')->move('uploads/images', $image);
        }

        $event = Event::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'startdate'=>$request->startdate,
            'enddate'=>$request->enddate,
            'image'=>$image,
            'slug'=>Str::slug($request->title),
            'created_by'=>Auth::user()->id
        ]);

        $event->category()->attach($request->category);


        return redirect()->back()->with('status','Successfully Added Event');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('event.detail',compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $categories = Category::all();

        return view('event.edit',compact('event','categories'));
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
        $event = Event::findOrFail($id);
        $request->validate([
            'title'=>'required|max:100',
            'description'=>'required|min:10',
            'startdate'=>'required',
            'enddate'=>'required',
            'category'=>'required|array'
        ]);
        if ($request->file('image')) {
            $request->validate([
                'image'=>'mimes:jpeg,bmp,png,jpg,ico',
            ]);
            if (!($event->image == "images/default.jpg") && file_exists('uploads/'.$event->image)) {
                File::delete('uploads/'.$event->image);
            }
            $image = 'images/'.time().$request->file('image')->getClientOriginalName();
            $request->file('image')->move('uploads/images', $image);
            $event->update([
                'image'=> $image
            ]);
        }

        $event->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'startdate'=>$request->startdate,
            'enddate'=>$request->enddate,
            'slug'=>Str::slug($request->title),
            'created_by'=>Auth::user()->id
        ]);

        $event->category()->sync($request->category);

        return redirect()->back()->with('status','Successfully Updated Event');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        if (!($event->image == "images/default.jpg") && file_exists('uploads/'.$event->image)) {
            File::delete('uploads/'.$event->image);
        }
        $event->delete();

        return redirect()->back()->with('status','Successfully Deleted Event');
    }

    public function read($slug)
    {
        $event = Event::where('slug',$slug)->first();

        return view('event.read',compact('event'));
    }
}
