<?php

namespace App\Http\Controllers;

use App\Models\car;
use App\Models\Categories;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class Select2search extends Controller
{
    public function selectProduct(Request $request)
    {
        $product = [];

        if ($request->has('q')) {
            $search = $request->q;
            $product = Product::select("id", "nama")
            ->where('nama', 'LIKE', "%$search%")
            ->get();
        } else {
            $product = Product::all();
        }
        return response()->json($product);
    }

    public function selectSupplier(Request $request)
    {
        $supplier = [];

        if ($request->has('q')) {
            $search = $request->q;
            $supplier = Supplier::select("id", "nama")
            ->where('nama', 'LIKE', "%$search%")
            ->get();
        } else {
            $supplier = Supplier::all();
        }
        return response()->json($supplier);
    }
    
    public function selectCustomer(Request $request)
    {
        $customer = [];

        if ($request->has('q')) {
            $search = $request->q;
            $customer = Customer::select("id", "nama")
            ->where('nama', 'LIKE', "%$search%")
            ->get();
        } else {
            $customer = Customer::all();
        }
        return response()->json($customer);
    }
    
    public function selectCategory(Request $request)
    {
        $category = [];

        if ($request->has('q')) {
            $search = $request->q;
            $category = Categories::select("id", "nama")
            ->where('nama', 'LIKE', "%$search%")
            ->get();
        } else {
            $category = Categories::all();
        }
        return response()->json($category);
    }

    public function selectDriver(Request $request)
    {
        $driver = [];

        if ($request->has('q')) {
            $search = $request->q;
            $driver = Driver::select("id", "name")
            ->where('name', 'LIKE', "%$search%")
            ->get();
        } else {
            $driver = Driver::all();
        }
        return response()->json($driver);
    }
  
    public function selectCar(Request $request)
    {
        $car = [];

        if ($request->has('q')) {
            $search = $request->q;
            $car = car::select("id", "brand", "plate")
            ->where('brand', 'plate', 'LIKE', "%$search%")
            ->get();
        } else {
            $car = car::all();
        }
        return response()->json($car);
    }
}
