<div class="modal fade" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-item" method="post" action="{{ url('/productsOut') }}" class="form-horizontal"
                data-toggle="validator" enctype="multipart/form-data">
                {{ csrf_field() }} {{ method_field('POST') }}

                <div class="modal-header">
                    <h3 class="modal-title"></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>


                <div class="modal-body">
                    <input type="hidden" id="id" name="id">


                    <div class="box-body flex">

                        <div class="form-group">
                            <label>Invoice No</label>
                            <input type="text" class="form-control" id="invoice_id" name="invoice" required>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label>Date</label>
                            <input data-date-format='yyyy-mm-dd' type="text" class="form-control" id="tanggal"
                                name="tanggal" required>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label>Customer</label>
                            <select class="" id="customer" name="customer_id"></select>
                            <span class="help-block with-errors"></span>
                        </div>

                        <a href="javascript:void(0)" class="btn btn-primary mb-2 btn-add"><i class="ion ion-plus"></i>
                            Add
                            Product</a>
                        <div class="form-group fieldInput">
                            <div class="row align-items-center ">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Products</label>
                                        {!! Form::select('product_id[]', $products, null, [
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
                                        <input type="number" class="form-control" id="qty" name="qty[]"
                                            required>
                                        <span class="help-block with-errors"></span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Exp Date</label>
                                        <input data-date-format='yyyy-mm-dd' type="date" class="form-control"
                                            id="expDate" name="expDate[]" required>
                                        <span class="help-block with-errors"></span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Batch No</label>
                                        <input type="number" class="form-control" id="batch" name="batch[]"
                                            required>
                                        <span class="help-block with-errors"></span>
                                    </div>
                                </div>
                                <div class="col">
                                    <a href="javascript:void(0)" class="btn btn-success btn-add"><i
                                            class="ion ion-plus"></i></a>
                                </div>
                            </div>
                        </div>

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
                            {{-- <select class="product" id="product1" name="product_id[]"></select> --}}
                            {!! Form::select('product_id[]', $products, null, [
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
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->




