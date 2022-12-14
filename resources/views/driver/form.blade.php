<div class="modal fade" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-item" method="post" action="{{ url('/drivers') }}" class="form-horizontal"
                data-toggle="validator" enctype="multipart/form-data">
                {{ csrf_field() }} {{ method_field('POST') }}

                <div class="modal-header">
                    <h3 class="modal-title"></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>


                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
    
    
                    <div class="box-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" id="nama" name="name" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
    
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" id="alamat" name="address" required>
                            <span class="help-block with-errors"></span>
                        </div>
    
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <span class="help-block with-errors"></span>
                        </div>
    
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" id="telepon" name="phone" required>
                            <span class="help-block with-errors"></span>
                        </div>
    
                        <div class="form-group">
                            <label for="formFile" class="form-label">Upload Photo Driving License</label>
                         
                            <input class="form-control" type="file" id="sim" name="driving_license"
                                onchange="loadSim(event)">
                            </br>
                            <div class="text-center">
                                <img id="out_sim" width="200px" />
                            </div>
                        </div>
    
                        <div class="form-group">
                            <label for="formFile" class="form-label">Upload Photo</label>
                           
                            <input class="form-control" type="file" id="photo" name="photo"
                                onchange="loadPhoto(event)">
                            </br>
                            <div class="text-center">
                                <img id="out_photo" width="200px" />
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
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
    var loadSim = function (event) {
        var output = document.getElementById('out_sim');
        var old = document.getElementById('old_sim');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function () {
            URL.revokeObjectURL(output.src) // free memory
            old.parentNode.removeChild(old);
        }
    };

    var loadPhoto = function (event) {
        var output = document.getElementById('out_photo');
        var old = document.getElementById('old_photo');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function () {
            URL.revokeObjectURL(output.src) // free memory
            old.parentNode.removeChild(old);
        }
    };
</script>



