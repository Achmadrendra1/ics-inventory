@extends('report.report')

@section('title', 'Invoice Barang Masuk')


@section('content')
<center>
<h4 class="mb-4">No Invoice : {{ $invoice->no_invoice }}</h4>
</center>
<h5>Supplier : {{ $invoice->supplier->nama }}</h5>
<h5 class="mb-4">Tanggal : {{ $invoice->tanggal_invoice }}</h5>

<table class="table" class="display nowrap" style="width:100%" id="table">
    
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Product</th>
            <th>Jumlah</th>
            <th>Tanggal Exp</th>
            <th>Batch No.</th>
          
        </tr>
    </thead>

    <tbody>
        @foreach ($detail as $d)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->product->nama }}</td>
                <td>{{ $d->qty }}</td>
                <td>{{ $d->exp_date }}</td>
                <td>{{ $d->batch_no }}</td>
               
            </tr>
        @endforeach
    </tbody>
</table> 

<h6 style="text-align: end">User</h6>
@stop