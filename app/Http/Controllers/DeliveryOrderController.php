<?php

namespace App\Http\Controllers;

use App\Models\delivery;
use App\Models\invoice;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DeliveryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoice =  invoice::orderBy('no_invoice', 'DESC')
        ->get()
        ->pluck('no_invoice', 'id');
        return view('delivery.index', compact('invoice'));
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

    public function apiDelivery()
    {
        $delivery = delivery::all();

        return DataTables::of($delivery)->addIndexColumn()
        ->addColumn('invoice', function ($delivery) {
            return $delivery->no_invoice->no_invoice;
        })
        ->addColumn('admin', function ($delivery) {
            return $delivery->user->name;
        })
        ->addColumn('driver', function ($delivery) {
            return $delivery->driver->name;
        })
        ->addColumn('plate', function ($delivery) {
            return $delivery->car->license_plate;
        })
            ->addColumn('action', function ($delivery) {
                return
                    '<a onclick="editForm(' . $delivery->id . ')" class="btn btn-primary btn-xs text-white mr-2"><i class="glyphicon glyphicon-edit"></i> Edit</> ' .
                    '<a onclick="deleteData(' . $delivery->id . ')" class="btn btn-danger btn-xs text-white"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            })
            ->rawColumns(['action'])->make(true);
    }
}
