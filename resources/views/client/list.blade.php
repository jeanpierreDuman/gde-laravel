@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<div class="container-fluid" style="background: #162056 !important; padding-top: 15px;padding-bottom: 5px;">
    <div class="row">
        <div class="col-md-12">
            <div class="container">
                <div class="row">
                    <div class="col-md-12" style="margin-bottom: 150px; margin-top: 15px;">
                        <h3 style="color: white; float: left;">Liste des clients</h3>
                        <a style="float:right; font-size: 10px;" class="btn btn-sm btn-primary" href="{{ route('client_create') }}">Créer un client</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" style="background: white; margin-top: -150px; padding-top: 10px;padding-bottom: 15px;">
    <div class="row">
        <div class="col-md-12" style="border-bottom: 10px solid #162056;">
            <div class="md-form mt-0">
                <input type="text" class="form-control" id="name" name="name" placeholder="Nom">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="mt-4">
                <table class="table table-bordered data-table" id="datatable">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Nombre dossier</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(function () {
        var table = $('#datatable').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
            },
            "dom": "ltip",
            "processing": true,
            "serverSide": true,
            "pageLength": 25,
            "lengthMenu": [5,25,50,100],
            paging: true,
            "ajax":{
                     "url": "{{ route('client_datatable_list') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                {data: 'name', name: 'name'},
                {data: 'nbFolder', name: 'nbFolder', 'orderable': false},
                {
                    'render': function(data, type, row) {
                        return '<a class="btn btn-sm btn-primary" href="'+ row.datalink.url +'">'+ row.datalink.label +'</a>';
                    },
                    "orderable": false
                }
            ]
        });

        $("#name").keyup(function() {
            var name = $(this).val();

            if(name.length > 0) {
                table.column(0).search(name).draw();
            } else {
                table.column(0).search('').draw();
            }
        });
  });

</script>

@endsection
