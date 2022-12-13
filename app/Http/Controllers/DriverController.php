<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $request->validate([
            'photo' => 'required',
            'driving_license' => 'required'

        ]);

        $driver = new Driver();
        $driver->name = $request->name;
        $driver->address = $request->address;
        $driver->email = $request->breed;
        $driver->phone = $request->phone;
        if ($request->hasFile('photo')) {
            $request->validate(['image' => 'mimes:jpeg,bmp,png']);
            $request->photo->store('driver', 'public');
            $driver->photo = $request->photo->hashName();
        }
        if ($request->hasFile('driving_license')) {
            $request->validate(['image' => 'mimes:jpeg,bmp,png']);
            $request->driving_license->store('driver', 'public');
            $driver->driving_licens = $request->driving_licens->hashName();
        }
        $driver->save();
        return response()->json([
            'success'    => true,
            'message'    => 'Customer Updated'
        ]);
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
        //
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
        //
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

    public function apiDriver()
    {
        $driver = Driver::all();

        return Datatables::of($driver)
            ->addColumn('action', function ($driver) {
                return
                    '<a onclick="editForm(' . $driver->id . ')" class="btn btn-primary btn-xs text-white"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                    '<a onclick="deleteData(' . $driver->id . ')" class="btn btn-danger btn-xs text-white"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            })
            ->rawColumns(['action'])->make(true);
    }
}
