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

    <div class="box">

        <div class="box-header">
            <h3 class="box-title">Data Products In</h3>


        </div>

        <div class="box-header">
            <a onclick="addForm()" class="btn btn-primary text-white">Add Products In</a>
            <a href="{{ route('exportPDF.productMasukAll') }}" class="btn btn-danger">Export PDF</a>
            <a href="{{ route('exportExcel.productMasukAll') }}" class="btn btn-success">Export Excel</a>
        </div>




        <!-- /.box-header -->
        <div class="box-body">
            <table id="products-in-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>No Invoice</th>
                        <th>Supplier</th>
                        <th>Jumlah Product</th>
                        <th>Tanggal Masuk</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>


    @include('product_masuk.form')
@endsection

@section('bot')
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
        $(function() {

            //Date picker
            $('#tanggal').datepicker({
                autoclose: true,
                // dateFormat: 'yyyy-mm-dd'
            })


            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            //Timepicker
            $('.timepicker').timepicker({
                showInputs: false
            })
        });

        $(document).ready(function() {
            $(".btn-add").click(function() {
                var html = $(".fieldInputCopy").html();
                $(".fieldInput").append(html);
            });

            $(".fieldInput").on("click", ".remove", function() {
                $(this).parent().parent().remove();
            });
        });
    </script>

    <script type="text/javascript">
        var table = $('#products-in-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/test",
            columns: [
                // {
                //     data: 'id',
                //     name: 'id'
                // },
                {
                    data: 'no_invoice',
                    name: 'no_invoice'
                },
                {
                    data: 'supplier_name',
                    name: 'supplier_name'
                },
                {
                    data: 'jumlah_product',
                    name: 'jumlah_product'
                },
                {
                    data: 'tanggal_invoice',
                    name: 'tanggal_invoice'
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
            $('.modal-title').text('Add Products In');
        }

        // function editForm(id) {
        //     save_method = 'edit';
        //     $('input[name=_method]').val('PATCH');
        //     $('#modal-form form')[0].reset();
        //     $.ajax({
        //         url: "{{ url('productsIn') }}" + '/' + id + "/edit",
        //         type: "GET",
        //         dataType: "JSON",
        //         success: function(data) {
        //             $('#modal-form-edit').modal('show');
        //             $('.modal-title').text('Edit Products In');
        //             $('#invoice-edit').val(data[0].no_invoice);
        //             $('#tanggal-edit').val(data[0].tanggal_invoice);
        //             $('#supplier-edit').val(data[0].supplier_id);
        //             var html = $(".fieldInputCopy").html();
        //             $(".fieldInput").append(html);
        //             for (var i = 0; i < data[1].length; ++i) {
        //                 var prod_id = data[1][i].batch_no;
        //                 console.log(prod_id);



        //                 // $('#product-edit').val(data[0][i].product_id);

        //             };
        //             // $('#product-edit').val(data[1][1].product_id);
        //             // $.each(data[1][], function(k, v){
        //             //     console.log('key' + k);
        //             //     console.log('value' + v);
        //             // });
        //             // console.log(data[1].length);
        //         },
        //         error: function() {
        //             alert("Nothing Data");
        //         }
        //     });
        // }

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
                    url: "{{ url('productsIn') }}" + '/' + id,
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

        // $(function() {
        //     $('#modal-form form').validator().on('submit', function(e) {
        //         if (!e.isDefaultPrevented()) {
        //             var id = $('#id').val();
        //             if (save_method == 'add') url = "{{ url('productsIn') }}";
        //             else url = "{{ url('productsIn') . '/' }}" + id;
        //             console.log( $('#modal-form form').serializeArray())


        //             $.ajax({
        //                 url: url,
        //                 type: "POST",
        //                 //hanya untuk input data tanpa dokumen
        //                 data : $('#modal-form form').serializeArray(),
        //                 // data: new FormData($("#modal-form form")[0]),
        //                 contentType: false,
        //                 processData: false,
        //                 success: function(data) {
        //                     $('#modal-form').modal('hide');
        //                     table.ajax.reload();
        //                     swal({
        //                         title: 'Success!',
        //                         text: data.message,
        //                         type: 'success',
        //                         timer: '1500'
        //                     })
        //                 },
        //                 error: function(data) {
        //                     swal({
        //                         title: 'Oops...',
        //                         text: data.message,
        //                         type: 'error',
        //                         timer: '1500'
        //                     })
        //                 }
        //             });
        //             return false;
        //         }
        //     });
        // });




        $('#supplier').select2({
            placeholder: '--Select Supplier--',
            dropdownParent: $('#modal-form form'),
            theme: "bootstrap",

            ajax: {
                url: '/ajax-select-supplier',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.nama,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
    </script>
@endsection
