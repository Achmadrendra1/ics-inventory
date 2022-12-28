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
use Illuminate\Support\Facades\Auth;
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
        $products = Product::orderBy('name', 'ASC')
            ->get()
            ->pluck('name', 'id');

        $product = Product::orderBy('name', 'ASC')
            ->get();

        $suppliers = Supplier::orderBy('name', 'ASC')
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
        $invoice->no_invoice = 'ICS/I/'.$request->invoice;
        $invoice->date = $request->tanggal;
        $invoice->supplier_id = $request->supplier_id;
        $invoice->type = "IN";
        $invoice->user_id = auth::user()->id;
        $invoice->save();

        $getNoinv = invoice::where('no_invoice', 'ICS/I/'.$request->invoice)->first();

        $product = $request->product_id;
        $exp = $request->expDate;
        $batch = $request->batch;
        $qty = $request->qty;

        for ($i = 0; $i < count($product); $i++) {
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
        $products = Product::orderBy('name', 'ASC')
            ->get()
            ->pluck('name', 'id');
        $product = Product::orderBy('name', 'ASC')
            ->get();

        $suppliers = Supplier::orderBy('name', 'ASC')
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
        $invoice->no_invoice = 'ICS/I/'.$request->invoice;
        $invoice->tanggal_invoice = $request->tanggal;
        $invoice->supplier_id = $request->supplier_id;
        $invoice->update();

        $getNoinv = invoice::where('no_invoice', 'ICS/I/'.$request->invoice)->first();

        $product = $request->product;
        $exp = $request->expDate;
        $batch = $request->batch;
        $qty = $request->qty;

        for ($i = 0; $i < count($product); $i++) {
            $cekQty = invoice_detail::where('no_invoice', $request->invoice)->where('product_id', $product[$i])->first();
            if (empty($cekQty->qty)) {
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
            if ($cekQty->qty != $qty[$i]) {
                $stok = Product::find($product[$i]);
                $stok->qty = $stok->qty - $cekQty->qty + $qty[$i];
                $stok->update();

                invoice_detail::where('no_invoice', $request->invoice)->where('product_id', $product[$i])->update([
                    'no_invoice' => $getNoinv->no_invoice,
                    'product_id' => $product[$i],
                    'exp_date' => $exp[$i],
                    'batch_no' => $batch[$i],
                    'qty' => $qty[$i]
                ]);
            }
        }

        Alert::success('Success', 'Products In Updated');
        return \redirect('productsIn');

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

    public function apiProductsIn()
    {
        $invoice = invoice::where('type', 'In');

        return Datatables::of($invoice)
            ->addColumn('supplier_name', function ($invoice) {
                return $invoice->supplier->name;
            })
            ->addColumn('jumlah_product', function ($invoice) {
                $product = invoice_detail::where('no_invoice', $invoice->no_invoice)->get();
                $jumlah = count($product);
                return $jumlah;
            })
            ->addColumn('action', function ($invoice) {
                return
                    '<a href="productsIn/' . $invoice->id . '/print" class="btn btn-success btn-xs text-white"><i class="glyphicon glyphicon-edit"></i> Print</a> ' .
                    '<a href="productsIn/' . $invoice->id . '/edit" class="btn btn-primary btn-xs text-white"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                    '<a onclick="deleteData(' . $invoice->id . ')" class="btn btn-danger btn-xs text-white"><i class="glyphicon glyphicon-trash"></i> Delete</a> ';
            })
            ->rawColumns(['supplier_name', 'jumlah_product', 'action'])->make(true);
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

    public function print($id){
        $invoice = invoice::findOrFail($id);
        $detail = invoice_detail::where('no_invoice', $invoice->no_invoice)->get();
        return \view('report.reportInvoiceIn', [
            'invoice' => $invoice,
            'detail' => $detail
        ]);
    }
}
