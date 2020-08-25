<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use Illuminate\Support\Facades\Storage;
use File;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Company::first();

        return view('company.index',compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $company = Company::first();

        return view('company.edit',compact('company'));
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
        $company = Company::findOrFail($id);

        $request->validate([
            'name'=>'required',
            'email'=>'required'
        ]);

        if ($request->file('profile')) {
            $request->validate([
                'profile'=>'mimes:pdf',
            ]);
            if ($company->profile && file_exists('uploads/'.$company->profile)) {
                File::delete('uploads/'.$company->logo);
            }
            $profile = 'profile/'.time().$request->file('profile')->getClientOriginalName();
            $request->file('profile')->move('uploads/profile', $profile);
            $company->update([
                'profile'=> $profile
            ]);
        }


        $company->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'website'=>$request->website
        ]);

        return redirect()->route('company.index')->with('status','successfully updated company');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function download()
    {
        $company = Company::first();
        // $url = Storage::url("$company->profile");
        $url =public_path().'/uploads/'.$company->profile;

        // dd(asset($company->profile));
        // response()->download($file, 'filename.pdf', $headers);
        $headers = [
            'Content-Type' => 'application/pdf',
         ];
        return response()->download($url, 'companyprofile.pdf', $headers);
        // return response()->file($url, $headers);

    }
}
