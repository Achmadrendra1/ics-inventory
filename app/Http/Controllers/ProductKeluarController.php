<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Exports\ExportProdukKeluar;
use App\Models\invoice;
use App\Models\invoice_detail;
use App\Models\Product;
use App\Models\Product_Keluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;


class ProductKeluarController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('role:admin,staff');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('name','ASC')
            ->get()
            ->pluck('name','id');

        $customers = Customer::orderBy('name','ASC')
            ->get()
            ->pluck('name','id');

        $invoice_data = Product_Keluar::all();
        return view('product_out.index', compact('products','customers', 'invoice_data'));
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
        $invoice = new invoice();
        $invoice->no_invoice = 'ICS/O/'. $request->invoice;
        $invoice->date = $request->tanggal;
        $invoice->customer_id = $request->customer_id;
        $invoice->type = "OUT";
        $invoice->user_id = Auth::user()->id;
        $invoice->save();

        $getNoinv = invoice::where('no_invoice', 'ICS/O/'.$request->invoice)->first();

        $product = $request->product_id;
        $exp = $request->expDate;
        $batch = $request->batch;
        $qty = $request->qty;

        for ($i = 0; $i < count($product); $i++) {
            $stok = Product::find($product[$i]);
            if($stok->qty > $qty[$i]){
                $stok->qty -= $qty[$i];
                $stok->update();

                $detail = new invoice_detail();
                $detail->no_invoice = $getNoinv->no_invoice;
                $detail->product_id = $product[$i];
                $detail->exp_date = $exp[$i];
                $detail->batch_no = $batch[$i];
                $detail->qty = $qty[$i];
                $detail->save();
            } else {
                invoice::where('no_invoice', $getNoinv->no_invoice)->delete();
                Alert::error('Ooppss', 'Products Out Of Stock !');
                return \redirect('productsOut');
            }
            
        }

        Alert::success('Success', 'Products Out Saved');
        return \redirect('productsOut');

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
        $products = Product::orderBy('name', 'ASC')
            ->get()
            ->pluck('name', 'id');
        $product = Product::orderBy('name', 'ASC')
            ->get();

        $customers = Customer::orderBy('name', 'ASC')
            ->get();
        $invoice = invoice::find($id);
        $detail = invoice_detail::where('no_invoice', $invoice->no_invoice)->get();
        return \view('product_out.form_edit', [
            'product' => $product,
            'products' => $products,
            'customer' => $customers,
            'invoice' => $invoice,
            'detail' => $detail
        ]);
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
        $invoice = invoice::findOrFail($id);
        $invoice->no_invoice = $request->invoice;
        $invoice->date = $request->tanggal;
        $invoice->customer_id = $request->customer_id;
        $invoice->update();

        $getNoinv = invoice::where('no_invoice', $request->invoice)->first();

        $product = $request->product;
        $exp = $request->expDate;
        $batch = $request->batch;
        $qty = $request->qty;

        for ($i = 0; $i < count($product); $i++) {
            $cekQty = invoice_detail::where('no_invoice', $request->invoice)->where('product_id', $product[$i])->first();
            if ($cekQty->qty > $qty[$i]){
                if (empty($cekQty->qty)) {
                    $stok = Product::find($product[$i]);
                    $stok->qty -= $qty[$i];
                    $stok->update();
    
                    $detail = new invoice_detail();
                    $detail->no_invoice = $getNoinv->no_invoice;
                    $detail->product_id = $product[$i];
                    $detail->exp_date = $exp[$i];
                    $detail->batch_no = $batch[$i];
                    $detail->qty = $qty[$i];
                    $detail->save();
                }
                if ($cekQty->qty != $qty[$i]) {
                    $stok = Product::find($product[$i]);
                    $stok->qty = $stok->qty - $cekQty->qty - $qty[$i];
                    $stok->update();
    
                    invoice_detail::where('no_invoice', $request->invoice)->where('product_id', $product[$i])->update([
                        'no_invoice' => $getNoinv->no_invoice,
                        'product_id' => $product[$i],
                        'exp_date' => $exp[$i],
                        'batch_no' => $batch[$i],
                        'qty' => $qty[$i]
                    ]);
                }
            } else {
                Alert::error('Oopps !!!', 'Products Out Of Stock');
                return \redirect('productsOut');
            }
           
        }

        Alert::success('Success', 'Products Out Updated');
        return \redirect('productsOut');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product_Keluar::destroy($id);

        return response()->json([
            'success'    => true,
            'message'    => 'Products Delete Deleted'
        ]);
    }



    public function apiProductsOut(){
        $invoice = invoice::where('type', 'Out');

        return Datatables::of($invoice)
            ->addColumn('customer_name', function ($invoice) {
                return $invoice->customer->name;
            })
            ->addColumn('jumlah_product', function ($invoice) {
                $product = invoice_detail::where('no_invoice', $invoice->no_invoice)->get();
                $jumlah = count($product);
                return $jumlah;
            })
            ->addColumn('action', function ($invoice) {
                return
                    '<a href="productsOut/' . $invoice->id . '/print" class="btn btn-success btn-xs text-white"><i class="glyphicon glyphicon-edit"></i> Print</a> ' .
                    '<a href="productsOut/' . $invoice->id . '/edit" class="btn btn-primary btn-xs text-white"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                    '<a onclick="deleteData(' . $invoice->id . ')" class="btn btn-danger btn-xs text-white"><i class="glyphicon glyphicon-trash"></i> Delete</a> ';
            })
            ->rawColumns(['customer_name', 'jumlah_product', 'action'])->make(true);

    }

    public function exportProductKeluarAll()
    {
        $product_keluar = Product_Keluar::all();
        $pdf = PDF::loadView('product_keluar.productKeluarAllPDF',compact('product_keluar'));
        return $pdf->stream('product_keluar.pdf');
    }

    public function exportProductKeluar($id)
    {
        $product_keluar = Product_Keluar::findOrFail($id);
        $pdf = PDF::loadView('product_keluar.productKeluarPDF', compact('product_keluar'));
        return $pdf->stream($product_keluar->id.'_product_keluar.pdf');
    }

    public function exportExcel()
    {
        return (new ExportProdukKeluar)->download('product_keluar.xlsx');
    }

    public function selectSearch(Request $request)
    {
        $movies = [];

        if ($request->has('q')) {
            $search = $request->q;
            $movies = Movie::select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($movies);
    }
}
