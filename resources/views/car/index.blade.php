@extends('layouts.master')


@section('top')
    <!-- DataTables -->
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}"> --}}
@endsection

@section('content')
    <div class="box">

        <div class="box-header">
            <h3 class="box-title">Data Cars</h3>
        </div>

        <div class="box-header">
            <a onclick="addForm()" class="btn btn-primary text-white">Add Car</a>
            <a href="{{ route('exportPDF.categoriesAll') }}" class="btn btn-danger">Export PDF</a>
            <a href="{{ route('exportExcel.categoriesAll') }}" class="btn btn-success">Export Excel</a>
        </div>


        <!-- /.box-header -->
        <div class="box-body">
            <table id="car-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Brand</th>
                        <th>License Plate</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>

    @include('car.form')
@endsection

@section('bot')
    <!-- DataTables -->
    {{-- <script src=" {{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }} "></script>
    <script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }} "></script> --}}
     <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    {{-- Validator --}}
    <script src="{{ asset('assets/validator/validator.min.js') }}"></script>

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

    <script type="text/javascript">
        var table = $('#car-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('api.car') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'brand',
                    name: 'brand'
                },
                {
                    data: 'license_plate',
                    name: 'plate'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        function addForm() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Add Car');
        }

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
            $.ajax({
                url: "{{ url('cars') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Edit Car');

                    $('#id').val(data.id);
                    $('#brand').val(data.brand);
                    $('#plate').val(data.license_plate);
                },
                error: function() {
                    alert("Nothing Data");
                }
            });
        }

        function deleteData(id) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then(function() {
                $.ajax({
                    url: "{{ url('cars') }}" + '/' + id,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '_token': csrf_token
                    },
                    success: function(data) {
                        table.ajax.reload();
                        swal({
                            title: 'Success!',
                            text: data.message,
                            type: 'success',
                            timer: '1500'
                        })
                    },
                    error: function() {
                        swal({
                            title: 'Oops...',
                            text: data.message,
                            type: 'error',
                            timer: '1500'
                        })
                    }
                });
            });
        }

        $(function() {
            $('#modal-form form').validator().on('submit', function(e) {
                if (!e.isDefaultPrevented()) {
                    var id = $('#id').val();
                    if (save_method == 'add') url = "{{ url('cars') }}";
                    else url = "{{ url('cars') . '/' }}" + id;
                    console.log($('#modal-form form').serialize());

                    $.ajax({
                        url: url,
                        type: "POST",
                        //hanya untuk input data tanpa dokumen
                        //data : $('#modal-form form').serialize(),
                        data: new FormData($("#modal-form form")[0]),
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            swal({
                                title: 'Success!',
                                text: data.message,
                                type: 'success',
                                timer: '1500'
                            })
                        },
                        error: function(data) {
                            swal({
                                title: 'Oops...',
                                text: data.message,
                                type: 'error',
                                timer: '1500'
                            })
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endsection
