@extends('layouts.master')


@section('top')
    <!-- DataTables -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">

    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet"
        href="{{ asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"
        integrity="sha512-kq3FES+RuuGoBW3a9R2ELYKRywUEQv0wvPTItv3DSGqjpbNtGWVdvT8qwdKkqvPzT93jp8tSF4+oN4IeTEIlQA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css"
        integrity="sha512-CbQfNVBSMAYmnzP3IC+mZZmYMP2HUnVkV4+PwuhpiMUmITtSpS7Prr3fNncV1RBOnWxzz4pYQ5EAGG4ck46Oig=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    {{-- Modal Form Edit --}}
    <div class="box">
        <form id="form-item" action="/productsOut/{{ $invoice->id }}/edit" method="POST" class="form-horizontal"
            data-toggle="validator" enctype="multipart/form-data">
            @csrf

            <div class="modal-header">
                <h3 class="modal-title">Edit Product Masuk</h3>

            </div>


            <div class="modal-body">
                <input type="hidden" id="id" name="id">


                <div class="box-body flex">



                    <div class="form-group">
                        <label>Invoice No</label>
                        <input type="text" class="form-control" id="invoice-edit" name="invoice" required
                            value="{{ $invoice->no_invoice }}">
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label>Date</label>
                        <input data-date-format='yyyy-mm-dd' type="text" class="form-control" id="tanggal"
                            name="tanggal" value={{ $invoice->date }} required>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label>Customer</label>
                        <select class="form-control select" id="customer" name="customer_id">
                            <option>--Choose Supplier--</option>
                            @foreach ($customer as $s)
                                <option value={{ $s->id }} {{ $s->id == $invoice->customer_id ? 'selected' : '' }}>
                                    {{ $s->name }}</option>
                            @endforeach
                        </select>
                        <span class="help-block with-errors"></span>
                    </div>


                    <a href="javascript:void(0)" class="btn btn-primary mb-2 btn-add"><i class="ion ion-plus"></i> Add
                        Product</a>

                    @foreach ($detail as $d)
                        {{-- {{  }} --}}
                        <div class="form-group fieldInput{{ $loop->index }}">
                            {{-- {{ $loop->index }} --}}
                            <div class="row align-items-center ">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Products</label>
                                        <select class="form-control select" id="product" name="product[]">
                                            <option>--Choose Product--</option>
                                            @foreach ($product as $p)
                                                <option value={{ $p->id }}
                                                    {{ $p->id == $d->product_id ? 'selected' : '' }}>{{ $p->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="help-block with-errors"></span>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label>Quantity</label>
                                        <input type="number" class="form-control" id="qty" name="qty[]"
                                            value={{ $d->qty }} required>
                                        <span class="help-block with-errors"></span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Exp Date</label>
                                        <input data-date-format='yyyy-mm-dd' type="date" class="form-control"
                                            id="expDate" name="expDate[]" value={{ $d->exp_date }} required>
                                        <span class="help-block with-errors"></span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Batch No</label>
                                        <input type="number" class="form-control" id="batch" name="batch[]"
                                            value={{ $d->batch_no }} required>
                                        <span class="help-block with-errors"></span>
                                    </div>
                                </div>
                                <div class="col">
                                    <a href="javascript:void(0)" class="btn btn-danger remove"><i
                                            class="ion ion-close"></i></a>
                                </div>
                            </div>
                        </div>
                  
                    @endforeach

                </div>
                <!-- /.box-body -->

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>
        <div class="form-group fieldInputCopy invisible">
            <div class="row align-items-center">
                <div class="col">
                    <div class="form-group">
                        <label>Products</label>
                        {!! Form::select('product[]', $products, null, [
                            'class' => 'form-control select',
                            'placeholder' => '-- Choose Product --',
                            'id' => 'product_id',
                            'required',
                        ]) !!}
                        <span class="help-block with-errors"></span>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" class="form-control" id="qty" name="qty[]" required>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Exp Date</label>
                        <input data-date-format='yyyy-mm-dd' type="date" class="form-control" id="expDate"
                            name="expDate[]" required>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Batch No</label>
                        <input type="number" class="form-control" id="batch" name="batch[]" required>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="col">
                    <a href="javascript:void(0)" class="btn btn-danger remove"><i class="ion ion-close"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
@endsection
@section('bot')
    <script src="{{ URL::to('assets/bower_components/jquery/dist/jquery.min.js') }} "></script>
    <!-- DataTables -->
    {{-- <script src=" {{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }} "></script> --}}
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    {{-- <script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }} "></script> --}}


    <!-- InputMask -->
    <script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('assets/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ asset('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ asset('assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}">
    </script>
    <!-- bootstrap time picker -->
    <script src="{{ asset('assets/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
    {{-- Validator --}}
    <script src="{{ asset('assets/validator/validator.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    {{-- <script> --}}
    {{-- $(function () { --}}
    {{-- $('#items-table').DataTable() --}}
    {{-- $('#example2').DataTable({ --}}
    {{-- 'paging'      : true, --}}
    {{-- 'lengthChange': false, --}}
    {{-- 'searching'   : false, --}}
    {{-- 'ordering'    : true, --}}
    {{-- 'info'        : true, --}}
    {{-- 'autoWidth'   : false --}}
    {{-- }) --}}
    {{-- }) --}}
    {{-- </script> --}}

    <script>
        $(document).ready(function() {
            $(".btn-add").click(function() {
                var html = $(".fieldInputCopy").html();
                var array = {!! json_encode($detail) !!};
                var lastIndex = array.length - 1;
                $(".fieldInput" + lastIndex).append(html);
            });

            @foreach ($detail as $d)
                $(".fieldInput{{ $loop->index }}").on("click", ".remove", function() {
                    $(this).parent().parent().remove();
                });
            @endforeach

        });
    </script>
