<div class="modal fade" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="form-item" method="post" action="{{ url('/cars') }}" class="form-horizontal"
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
                            <label>Brand</label>
                            <input type="text" class="form-control" id="brand" name="brand" required>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label>License Plate</label>
                            <input data-date-format='yyyy-mm-dd' type="text" class="form-control" id="plate"
                                name="license_plate" required>
                            <span class="help-block with-errors"></span>
                        </div>

                    </div>
                    <!-- /.box-body -->

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>
           
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->




