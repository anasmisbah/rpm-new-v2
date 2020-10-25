<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Card;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cards = Card::orderBy('id','desc')->get();

        return view('card.index',compact('cards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('card.create');
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
            'image'=>'required'
        ]);
        $image='cards/default.jpg';
        if ($request->file('image')) {
            $request->validate([
                'image'=>'mimes:jpeg,bmp,png,jpg,ico',
            ]);
            $image = 'cards/'.time().$request->file('image')->getClientOriginalName();
            $request->file('image')->move('uploads/cards', $image);
        }

        Card::create([
            'name'=>$request->name,
            'image'=>$image,
        ]);

        return redirect()->back()->with('status','Successfully Added Card');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $card = Card::findOrFail($id);

        return view('card.detail',compact('card'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $card = Card::findOrFail($id);

        return view('card.edit',compact('card'));
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
        $card = Card::findOrFail($id);

        $request->validate([
            'name'=>'required',
        ]);

        if ($request->file('image')) {
            $request->validate([
                'image'=>'mimes:jpeg,bmp,png,jpg,ico',
            ]);
            if (!($card->image == "images/default.jpg") && file_exists('uploads/'.$card->image)) {
                File::delete('uploads/'.$card->image);
            }
            $image = 'cards/'.time().$request->file('image')->getClientOriginalName();
            $request->file('image')->move('uploads/cards', $image);
            $card->update([
                'image'=> $image
            ]);
        }

        $card->update([
            'name'=>$request->name,
        ]);

        return redirect()->back()->with('status','Successfully Updated Card');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $card = Card::findOrFail($id);
        $card->delete();

        return redirect()->route('card.index')->with('status','Successfully Delete Card');
    }
}
