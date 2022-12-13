<?php

namespace App\Http\Controllers;

use App\Models\car;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('car.index');
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
        $this->validate($request, [
            'brand'   => 'required|string|min:2',
            'license_plate'   => 'required|string|min:2'
        ]);

        car::create($request->all());

        return response()->json([
            'success'    => true,
            'message'    => 'Car Saved'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car = car::find($id);
        return $car;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'brand'   => 'required|string|min:2',
            'license_plate'   => 'required|string|min:2'
        ]);

        $car = car::findOrFail($id);

        $car->update($request->all());

        return response()->json([
            'success'    => true,
            'message'    => 'Car Updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Car::destroy($id);

        return response()->json([
            'success'    => true,
            'message'    => 'Car Deleted'
        ]);
    }

    public function apiCar()
    {
        $car = car::all();

        return DataTables::of($car)->addIndexColumn()
            ->addColumn('action', function ($car) {
                return
                    '<a onclick="editForm(' . $car->id . ')" class="btn btn-primary btn-xs text-white"><i class="glyphicon glyphicon-edit"></i> Edit</> ' .
                    '<a onclick="deleteData(' . $car->id . ')" class="btn btn-danger btn-xs text-white"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            })
            ->rawColumns(['action'])->make(true);
    }
}
