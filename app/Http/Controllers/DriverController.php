<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $driver = Driver::all();
        return view('driver.index');
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
        // dd($request->all());
        $request->validate([
            'photo' => 'required',
            'driving_license' => 'required'

        ]);

        $driver = new Driver();
        $driver->name = $request->name;
        $driver->address = $request->address;
        $driver->email = $request->email;
        $driver->phone = $request->phone;
        if ($request->hasFile('photo')) {
            $request->validate(['image' => 'mimes:jpeg,bmp,png']);
            $request->photo->store('driver', 'public');
            $driver->photo = $request->photo->hashName();
        }
        if ($request->hasFile('driving_license')) {
            $request->validate(['image' => 'mimes:jpeg,bmp,png']);
            $request->driving_license->store('driver', 'public');
            $driver->driving_license = $request->driving_license->hashName();
        }
        $driver->save();
        Alert::success('Success', 'New Drivers Saved');
        return \redirect('drivers');
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
    public function edit($id)
    {
        $driver = Driver::find($id);
        return view('driver.form_edit', ['driver' => $driver]);
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
        $driver = Driver::find($id);
        $driver->name = $request->name;
        $driver->address = $request->address;
        $driver->email = $request->email;
        $driver->phone = $request->phone;
        if ($request->hasFile('photo')) {
            if($request->photo){
                Storage::delete('public/driver/'.$driver->photo);
                //Storage::disk('public')->delete('my_pet/' . $request->oldImage);
            }
            $request->validate(['image' => 'mimes:jpeg,bmp,png']);
            $request->photo->store('driver', 'public');
            $driver->photo = $request->photo->hashName();
        }
        if ($request->hasFile('driving_license')) {
            if($request->driving_license){
                Storage::delete('public/driver/'.$driver->driving_license);
                //Storage::disk('public')->delete('my_pet/' . $request->oldImage);
            }
            $request->validate(['image' => 'mimes:jpeg,bmp,png']);
            $request->driving_license->store('driver', 'public');
            $driver->driving_license = $request->driving_license->hashName();
        }
        $driver->update();
        Alert::success('Success', 'Drivers Updated');
        return \redirect('drivers');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Driver::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Drivers Deleted'
        ]);
    }

    public function apiDriver()
    {
        $driver = Driver::all();

        return Datatables::of($driver)
            ->addColumn('driving_license', function ($driver) {
                $url = asset("storage/driver/". $driver->driving_license);
                return
                   '<img src='.$url.' border="0" width="40" class="img-rounded" align="center"/>';
            })
            ->addColumn('photo', function ($driver) {
                $url = asset("storage/driver/". $driver->photo);
                return
                   '<img src='.$url.' border="0" width="40" class="img-rounded" align="center"/>';
            })
            ->addColumn('action', function ($driver) {
                return
                '<a href="drivers/' . $driver->id . '/edit" class="btn btn-primary btn-xs text-white"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                '<a onclick="deleteData(' . $driver->id . ')" class="btn btn-danger btn-xs text-white"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            })
            ->rawColumns(['action', 'driving_license', 'photo'])->make(true);
    }
}
