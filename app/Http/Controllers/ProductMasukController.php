<?php

namespace App\Http\Controllers;


use App\Exports\ExportProdukMasuk;
use App\Models\invoice;
use App\Models\invoice_detail;
use App\Models\Product;
use App\Models\Product_Masuk;
use App\Models\Supplier;
use PDF;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class ProductMasukController extends Controller
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
        $products = Product::orderBy('nama', 'ASC')
            ->get()
            ->pluck('nama', 'id');

        $product = Product::orderBy('nama', 'ASC')
            ->get();

        $suppliers = Supplier::orderBy('nama', 'ASC')
            ->get();

        $invoice_data = Product_Masuk::all();
        return view('product_masuk.index', compact('products', 'product', 'suppliers', 'invoice_data'));
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
        $invoice->no_invoice = $request->invoice;
        $invoice->tanggal_invoice = $request->tanggal;
        $invoice->supplier_id = $request->supplier_id;
        $invoice->status = "IN";
        $invoice->save();

        $getNoinv = invoice::where('no_invoice', $request->invoice)->first();

        $product = $request->product_id;
        $exp = $request->expDate;
        $batch = $request->batch;
        $qty = $request->qty;

        for ($i = 0; $i < count($product); $i++)
        {
            $stok = Product::find($product[$i]);
            $stok->qty += $qty[$i];
            $stok->update();

            $detail = new invoice_detail();
            $detail->no_invoice = $getNoinv->no_invoice;
            $detail->product_id = $product[$i];
            $detail->exp_date = $exp[$i];
            $detail->batch_no = $batch[$i];
            $detail->qty = $qty[$i];
            $detail->save();
        }

        Alert::success('Success', 'Products In Saved');
        return \redirect('productsIn');

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
        $products = Product::orderBy('nama', 'ASC')
            ->get()
            ->pluck('nama', 'id');
        $product = Product::orderBy('nama', 'ASC')
            ->get();

        $suppliers = Supplier::orderBy('nama', 'ASC')
            ->get();
        $invoice = invoice::find($id);
        $detail = invoice_detail::where('no_invoice', $invoice->no_invoice)->get();
        return \view('product_masuk.form_edit', [
            'product' => $product,
            'products' => $products,
            'suppliers' => $suppliers,
            'invoice' => $invoice,
            'detail' => $detail
        ]);
        // return \dd($detail);
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
        $invoice->tanggal_invoice = $request->tanggal;
        $invoice->supplier_id = $request->supplier_id;
        $invoice->update();

        $getNoinv = invoice::where('no_invoice', $request->invoice)->first();

        $product = $request->product;
        $exp = $request->expDate;
        $batch = $request->batch;
        $qty = $request->qty;

        for ($i = 0; $i < count($product); $i++)
        {
            // $stok = Product::find($product[$i]);
            // $stok->qty += $qty[$i];
            // $stok->update();

            $detail = new invoice_detail();
            $detail->no_invoice = $getNoinv->no_invoice;
            $detail->product_id = $product[$i];
            $detail->exp_date = $exp[$i];
            $detail->batch_no = $batch[$i];
            $detail->qty = $qty[$i];
            $detail->update();
            
        }

        Alert::success('Success', 'Products In Updated');
        return \redirect('productsIn');

        // Alert::success('Success', 'Products In Saved');
        // return \redirect('productsIn');
        // $this->validate($request, [
        //     'product_id'     => 'required',
        //     'supplier_id'    => 'required',
        //     'qty'            => 'required',
        //     'tanggal'        => 'required'
        // ]);

        // $product_masuk = Product_Masuk::findOrFail($id);
        // $product_masuk->update($request->all());

        // $product = Product::findOrFail($request->product_id);
        // $product->qty += $request->qty;
        // $product->update();

        // return response()->json([
        //     'success'    => true,
        //     'message'    => 'Product In Updated'
        // ]);
        // return dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = invoice::findOrfail($id);
        
        $detail = invoice_detail::where('no_invoice', $invoice->no_invoice);

        $detail->delete();
        $invoice->delete();

        return response()->json([
            'success'    => true,
            'message'    => 'Products In Deleted'
        ]);
    }

    public function dataTablesTest()
    {
        $invoice = invoice::all();


        // return \dd($invoice->supplier->nama);
        return Datatables::of($invoice)
            ->addColumn('supplier_name', function ($invoice) {
                return $invoice->supplier->nama;
            })
            ->addColumn('jumlah_product', function ($invoice) {
                $product = invoice_detail::where('no_invoice', $invoice->no_invoice)->get();
                $jumlah = count($product);
                return $jumlah;
            })
            ->addColumn('action', function ($invoice) {
                return
                    '<a href="productsIn/' . $invoice->id . '/edit" class="btn btn-primary btn-xs text-white"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                    '<a onclick="deleteData(' . $invoice->id . ')" class="btn btn-danger btn-xs text-white"><i class="glyphicon glyphicon-trash"></i> Delete</a> ';
            })
            ->rawColumns(['supplier_name', 'jumlah_product', 'action'])->make(true);
    }



    public function apiProductsIn()
    {
        $product = Product_Masuk::all();

        return Datatables::of($product)
            ->addColumn('products_name', function ($product) {
                return $product->product->nama;
            })
            ->addColumn('supplier_name', function ($product) {
                return $product->supplier->nama;
            })
            ->addColumn('action', function ($product) {
                return
                    '<a href="{{ url("productsIn") }}" + "/" ' . $product->id . ' "/edit" class="btn btn-primary btn-xs text-white"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                    '<a onclick="deleteData(' . $product->id . ')" class="btn btn-danger btn-xs text-white"><i class="glyphicon glyphicon-trash"></i> Delete</a> ';
            })
            ->rawColumns(['products_name', 'supplier_name', 'action'])->make(true);
    }

    public function exportProductMasukAll()
    {
        $product_masuk = Product_Masuk::all();
        $pdf = PDF::loadView('product_masuk.productMasukAllPDF', compact('product_masuk'));
        return $pdf->download('product_masuk.pdf');
    }

    public function exportProductMasuk($id)
    {
        $product_masuk = Product_Masuk::findOrFail($id);
        $pdf = PDF::loadView('product_masuk.productMasukPDF', compact('product_masuk'));
        return $pdf->download($product_masuk->id . '_product_masuk.pdf');
    }

    public function exportExcel()
    {
        return (new ExportProdukMasuk)->download('product_masuk.xlsx');
    }
}
