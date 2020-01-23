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
                    <div class="col-md-12" style="margin-bottom: 265px; margin-top: 15px;">
                        <h3 style="color: white; float: left;">Liste des dossiers</h3>
                        <a style="float:right; font-size: 10px;" class="btn btn-sm btn-primary" href="{{ route('folder_create') }}">Créer un dossier</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style media="screen">
    .card-data:hover {
        background: #d9d9d9 !important;
    }
</style>

<div class="container" style="background: white; margin-top: -265px;padding-bottom: 15px;">
    <div class="row">
        <div class="col-md-12" style="border-bottom: 10px solid #162056;">
            <div class="row">
                    <div id="encours" class="col-md-3 card-data" style="background: #f0f0f0; padding:25px; cursor: pointer;">
                        <span style="color: #0000008f;">Dossier en cours</span><br>
                        <span style="font-size: 20px;">{{ $totalPieceFolderToDo }} / {{ $totalFolderToDo }}</span>
                    </div>
                    <div id="a_scanner" class="col-md-3 card-data" style="background: #e6e6e6; padding:25px; cursor: pointer;">
                        <span style="color: #0000008f;">Dossier à scanner</span><br>
                        <span style="font-size: 20px;">{{ $countFilesFolderToScan }} / {{ $countFolderToScan }}</span>
                    </div>
                    <div id="a_comptabiliser" class="col-md-3 card-data" style="background: #f0f0f0; padding:25px; cursor: pointer;">
                        <span style="color: #0000008f;">Dossier à comptabiliser</span><br>
                        <span style="font-size: 20px;">{{ $countFilesFolderToCompta }} / {{ $countFolderToCompta }}</span>
                    </div>
                    <div id="a_integrer" class="col-md-3 card-data" style="background: #e6e6e6; padding:25px; cursor: pointer;">
                        <span style="color: #0000008f;">Dossier à intégrer</span><br>
                        <span style="font-size: 20px;">{{ $countFilesFolderToIntegrer }} / {{ $countFolderToIntegrer }}</span>
                    </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="md-form mt-0">
                        <input type="number" class="form-control" id="numFolder" name="name" placeholder="Numéro de dossier">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form mt-0">
                        <input placeholder="Choisir une date" type="text" name="daterange" class="form-control datepicker">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="mt-4">
                <table class="table table-bordered data-table" id="datatable">
                    <thead>
                        <tr>
                            <th>Nom du dossier</th>
                            <th>Date arrivé</th>
                            <th>Collaborateur</th>
                            <th>Nom</th>
                            <th>Piece</th>
                            <th>Statut</th>
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
            "lengthMenu": [2,3,25,50,100],
            "ajax":{
                     "url": "{{ route('folder_datatable_list') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                {data: 'numFolder', name: 'numFolder'},
                {data: 'dateArrive', name: 'dateArrive'},
                {data: 'collaborator', name: 'collaborator', 'orderable': false},
                {data: 'name', name: 'name'},
                {data: 'piece', name: 'piece'},
                {data: 'status', name: 'status'},
                {
                    'render': function(data, type, row) {
                        return '<a class="btn btn-sm btn-primary" href="'+ row.datalink.url +'">'+ row.datalink.label +'</a>';
                    },
                    "orderable": false
                }
            ]
        });

        $("#encours").click(function() {
            table.column(5).search('').draw();
        });

        $("#a_scanner").click(function() {
            table.column(5).search('to_scan').draw();
        });

        $("#a_comptabiliser").click(function() {
            table.column(5).search('to_compta').draw();
        });

        $("#a_integrer").click(function() {
            table.column(5).search('to_integrer').draw();
        });

        $("#numFolder").keyup(function() {
            var val = $(this).val();
            table.column(0).search(val).draw();
        });

        $('input[name="daterange"]').daterangepicker({
              autoUpdateInput: false,
              locale: {
                  format: 'DD/MM/YYYY',
                  applyLabel : 'Appliquer',
                  cancelLabel : 'Effacer',
                  daysOfWeek : ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Vev', 'Sam'],
                  monthNames : [
                      'Janvier',
                      'Février',
                      'Mars',
                      'Avril',
                      'Mai',
                      'Juin',
                      'Juillet',
                      'Aout',
                      'Septembre',
                      'Octobre',
                      'Novembre',
                      'Décembre'
                  ]
              }
          });

          $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
              if(picker.startDate.format('DD/MM/YYYY') !== picker.endDate.format('DD/MM/YYYY')) {
                  var str = picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY');
              } else {
                  var str = picker.startDate.format('DD/MM/YYYY');
              }
              $(this).val(str);
              table.column(1).search(str).draw();
          });

          $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
              $(this).val('');
              table.column(1).search('').draw();
          });
  });

</script>

@endsection
