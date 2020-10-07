<?php

namespace App\Http\Controllers;

use App\Category;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use File;
use DataTables;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view('news.index');
    }

    public function news_data()
    {
        $news = News::select(['id','title','image']);

        $dataTable = DataTables::of($news)
        ->addIndexColumn()
        ->editColumn('image', function ($data)
        {
            return url('/uploads/'.$data->image);
        })
        ->addColumn('url_detail', function ($data) {
            return route('news.show',$data->id);
        })
        ->addColumn('url_edit', function ($data) {
            return route('news.edit',$data->id);
        })
        ->addColumn('url_delete', function ($data) {
            return route('news.destroy',$data->id);
        });

        return $dataTable->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('news.create',compact('categories'));
    }

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
            'description'=>'required:min:10',
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
        $news = News::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'image'=>$image,
            'slug'=>Str::slug($request->title),
            'created_by'=>Auth::user()->id
        ]);

        $news->category()->attach($request->category);


        return redirect()->back()->with('status','Successfully Added News');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('news.detail',compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $news = News::findOrFail($id);
        $categories = Category::all();

        return view('news.edit',compact('news','categories'));
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
        $news = News::findOrFail($id);
        $request->validate([
            'title'=>'required|max:100',
            'description'=>'required:min:10',
            'category'=>'required|array'
        ]);
        if ($request->file('image')) {
            $request->validate([
                'image'=>'mimes:jpeg,bmp,png,jpg,ico',
            ]);
            if (!($news->image == "images/default.jpg") && file_exists('uploads/'.$news->image)) {
                File::delete('uploads/'.$news->image);
            }
            $image = 'images/'.time().$request->file('image')->getClientOriginalName();
            $request->file('image')->move('uploads/images', $image);
            $news->update([
                'image'=> $image
            ]);
        }

        $news->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'slug'=>Str::slug($request->title),
            'created_by'=>Auth::user()->id
        ]);

        $news->category()->sync($request->category);

        return redirect()->back()->with('status','Successfully Updated News');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);
        if (!($news->image == "images/default.jpg") && file_exists('uploads/'.$news->image)) {
            File::delete('uploads/'.$news->image);
        }
        $news->delete();

        return redirect()->back()->with('status','Successfully Deleted News');

    }

    public function read($slug)
    {
        $news = News::where('slug',$slug)->first();

        return view('news.read',compact('news'));
    }
}
