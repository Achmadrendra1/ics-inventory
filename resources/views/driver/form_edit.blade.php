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
        <form id="form-item" action="/drivers/{{ $driver->id }}/edit" method="POST" class="form-horizontal"
            data-toggle="validator" enctype="multipart/form-data">
            @csrf

            <div class="modal-header">
                <h3 class="modal-title">Edit Data Driver</h3>

            </div>


            <div class="modal-body">
                <input type="hidden" id="id" name="id">


                <div class="box-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="nama" name="name" value={{$driver->name}} autofocus required>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" id="alamat" name="address" value={{$driver->address}} required>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" id="email" name="email" value={{$driver->email}} required>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" id="telepon" name="phone" value={{$driver->phone}} required>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label for="formFile" class="form-label">Upload Photo Driving License</label>
                        <center>
                            <img src="{{ asset('storage/driver/' . $driver->driving_license) }}" height="200px" alt=""
                                id="old_sim">
                        </center>
                        <input class="form-control" type="file" id="sim" name="driving_license"
                            onchange="loadSim(event)">
                        </br>
                        <div class="text-center">
                            <img id="out_sim" width="200px" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="formFile" class="form-label">Upload Photo</label>
                        <center>
                            <img src="{{ asset('storage/driver/' . $driver->photo) }}" height="200px" alt=""
                                id="old_photo">
                        </center>
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
                <a href="{{URL::to('drivers')}}" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>
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
