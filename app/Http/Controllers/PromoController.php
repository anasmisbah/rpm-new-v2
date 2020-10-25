<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Promo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use File;
use DataTables;
class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('promo.index');
    }

    public function promo_data()
    {
        $promos = Promo::select(['id','name','point','total','status'])->orderBy('id','desc');

        $dataTable = DataTables::of($promos)
        ->addIndexColumn()
        ->addColumn('url_detail', function ($data) {
            return route('promo.show',$data->id);
        })
        ->addColumn('url_edit', function ($data) {
            return route('promo.edit',$data->id);
        })
        ->addColumn('url_delete', function ($data) {
            return route('promo.destroy',$data->id);
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
        return view('promo.create');
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
            'name'=>'required',
            'description'=>'required',
            'point'=>'required',
            'status'=>'required',
            'total'=>'required',
            'terms'=>'required'
        ]);

        $image='images/default.jpg';
        if ($request->file('image')) {
            $request->validate([
                'image'=>'mimes:jpeg,bmp,png,jpg,ico',
            ]);
            $image = 'images/'.time().$request->file('image')->getClientOriginalName();
            $request->file('image')->move('uploads/images', $image);
        }

        $promo = Promo::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'image'=>$image,
            'slug'=>Str::slug($request->title),
            'point'=>$request->point,
            'status'=>$request->status,
            'total'=>$request->total,
            'terms'=>$request->terms,
            'created_by'=>Auth::user()->id
        ]);


        return redirect()->back()->with('status', 'Successfully Added Promo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $promo = Promo::findOrFail($id);
        return view('promo.detail', compact('promo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $promo = Promo::findOrFail($id);

        return view('promo.edit', compact('promo'));
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
        $promo = Promo::findOrFail($id);
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'point'=>'required',
            'status'=>'required',
            'total'=>'required',
            'terms'=>'required'
        ]);
        if ($request->file('image')) {
            $request->validate([
                'image'=>'mimes:jpeg,bmp,png,jpg,ico',
            ]);
            if (!($promo->image == "images/default.jpg") && file_exists('uploads/'.$promo->image)) {
                File::delete('uploads/'.$promo->image);
            }
            $image = 'images/'.time().$request->file('image')->getClientOriginalName();
            $request->file('image')->move('uploads/images', $image);
            $promo->update([
                'image'=> $image
            ]);
        }

        $promo->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'slug'=>Str::slug($request->title),
            'point'=>$request->point,
            'status'=>$request->status,
            'total'=>$request->total,
            'terms'=>$request->terms,
            'created_by'=>Auth::user()->id
        ]);

        return redirect()->back()->with('status', 'Successfully Updated Promo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        if (!($promo->image == "images/default.jpg") && file_exists('uploads/'.$promo->image)) {
            File::delete('uploads/'.$promo->image);
        }
        $promo->delete();

        return redirect()->route('promo.index');
    }
}
