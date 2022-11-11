<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Customer;
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
}
