@extends('layouts.app')

@section('content')

<script type="text/javascript" src="{{ URL::asset('assets/js/verify.js') }}"></script>
<link rel="stylesheet" href="{{ URL::asset('assets/css/dropzone-table.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>

<div class="container-fluid" style="background: #162056 !important; padding-top: 15px;padding-bottom: 5px;">
    <div class="row">
        <div class="col-md-12">
            <div class="container">
                <div class="row">
                    <div class="col-md-12" style="margin-bottom: 65px; margin-top: 15px;">
                        <h3 style="color: white; float: left;">Information du dossier</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12" style="margin-top: -80px;">
            <table class="mt-4 table table-bordered data-table" style="background: white;">
                <thead>
                    <tr>
                        <th>Numéro de dossier</th>
                        <th>Collaborateur</th>
                        <th>Nom du dossier</th>
                        <th>Piece</th>
                        <th>Statut</th>
                        <th>Date arrivé</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $folder->numFolder }}</td>
                        <td>{{ $folder->user->name }}</td>
                        <td>{{ $folder->name }}</td>
                        <td>{{ $folder->piece }}</td>
                        <td>{{ $folder->status }}</td>
                        <td>{{ $folder->dateArrive }}</td>
                    </tr>
                </tbody>
            </table>

            <h3 class="pt-4">Saisi du nombre de document</h3>
            <form id="form-check" action="{{ route('folder_scanner_post', $folder->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <table class="mt-4 table table-bordered data-table">
                    <thead>
                        <tr>
                            <th class="align-middle text-center"> <b>Type</b> </th>
                            <th class="text-center"> <b>Achat</b> </th>
                            <th class="text-center"> <b>Vente</b> </th>
                            <th class="text-center"> <b>Facture</b> </th>
                            <th class="text-center"> <b>Banque</b> </th>
                            <th class="text-center"> <b>Divers</b> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="align-middle text-center">
                                <b>Rappel</b>
                            </td>
                            <td class="text-center">
                                <span id="achat">{{ $folder->achat }}</span>
                            </td>
                            <td class="text-center">
                                <span id="vente">{{ $folder->vente }}</span>
                            </td>
                            <td class="text-center">
                                <span id="facture">{{ $folder->facture }}</span>
                            </td>
                            <td class="text-center">
                                <span id="banque">{{ $folder->banque }}</span>
                            </td>
                            <td class="text-center">
                                <span id="divers">{{ $folder->divers }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle text-center">
                                <b>Saisi</b>
                            </td>
                            <td>
                                <input type="number" id="saisi-achat" name="saisi-achat" min="0" class="text-center form-control @error('achat') is-invalid @enderror" value="0">
                                <span style="color:red;" id="saisi-achat-error"></span>
                            </td>
                            <td>
                                <input type="number" id="saisi-vente" name="saisi-vente" min="0" class="text-center form-control @error('vente') is-invalid @enderror" value="0">
                                <span style="color:red;" id="saisi-vente-error"></span>
                            </td>
                            <td>
                                <input type="number" id="saisi-facture" name="saisi-facture" min="0" class="text-center form-control @error('facture') is-invalid @enderror" value="0">
                                <span style="color:red;" id="saisi-facture-error"></span>
                            </td>
                            <td>
                                <input type="number" id="saisi-banque" name="saisi-banque" min="0" class="text-center form-control @error('banque') is-invalid @enderror" value="0">
                                <span style="color:red;" id="saisi-banque-error"></span>
                            </td>
                            <td>
                                <input type="number" id="saisi-divers" name="saisi-divers" min="0" class="text-center form-control @error('divers') is-invalid @enderror" value="0">
                                <span style="color:red;" id="saisi-divers-error"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle text-center">
                                <b>Différence</b>
                            </td>
                            <td>
                                <input readonly type="text" id="difference-achat" name="difference-achat" min="0" class="text-center form-control @error('divers') is-invalid @enderror" value="0">
                                <span style="color:red;" id="difference-achat-error"></span>
                            </td>
                            <td>
                                <input readonly type="text" id="difference-vente" name="difference-vente" min="0" class="text-center form-control @error('divers') is-invalid @enderror" value="0">
                                <span style="color:red;" id="difference-vente-error"></span>
                            </td>
                            <td>
                                <input readonly type="text" id="difference-facture" name="difference-facture" min="0" class="text-center form-control @error('divers') is-invalid @enderror" value="0">
                                <span style="color:red;" id="difference-facture-error"></span>
                            </td>
                            <td>
                                <input readonly type="text" id="difference-banque" name="difference-banque" min="0" class="text-center form-control @error('divers') is-invalid @enderror" value="0">
                                <span style="color:red;" id="difference-banque-error"></span>
                            </td>
                            <td>
                                <input readonly type="text" id="difference-divers" name="difference-divers" class="text-center form-control @error('divers') is-invalid @enderror" value="0">
                                <span style="color:red;" id="difference-divers-error"></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>

            <div class="text-center ">
                <a id="form-verification-button-submit" class="btn btn-primary" style="margin: 0 auto;">
                    Valider la comptabilité
                </a>
            </div>
        </div>
    </div>
</div>

<form style="display:none;" id="validation-compta" action="{{ route('folder_validation_compta', ['id' => $folder->id]) }}" method="post">
    @csrf
</form>

<script type="text/javascript">

$(document).ready(function() {
    function change(name) {
        var idBase = $("#" + name).html();
        var saisi = $("#saisi-" + name).val();
        var result = idBase - saisi;

        if(result < 0) {
            result = result * - 1;
        }

        $("#difference-" + name).val(result);
    }

    change("achat");
    change("vente");
    change("facture");
    change("banque");
    change("divers");

    $("#saisi-achat").change(function() {
        change("achat");
    });

    $("#saisi-vente").change(function() {
        change("vente");
    });

    $("#saisi-facture").change(function() {
        change("facture");
    });

    $("#saisi-banque").change(function() {
        change("banque");
    });

    $("#saisi-divers").change(function() {
        change("divers");
    });


    $("#form-verification-button-submit").click(function(e) {
        function getValues() {
            var formData = new FormData();

            formData.append('_token', "{{ csrf_token() }}");
            formData.append('formData', $('#form-check').serialize());

            return formData;
        }

        $.post({
            url: "{{ route('folder_compta_post', $folder->id) }}",
            data: getValues(),
            processData: false, // required for FormData with jQuery
            contentType: false, // required for FormData with jQuery
            success: function(data) {

                if(data.errors !== null) {
                    if(data.errors['saisi-achat'] !== undefined) {
                        $("#saisi-achat-error").empty();
                        $("#saisi-achat-error").append(data.errors['saisi-achat']);
                    } else {
                        $("#saisi-achat-error").empty();
                    }

                    if(data.errors['saisi-vente'] !== undefined) {
                        $("#saisi-vente-error").empty();
                        $("#saisi-vente-error").append(data.errors['saisi-vente']);
                    } else {
                        $("#saisi-vente-error").empty();
                    }

                    if(data.errors['saisi-banque'] !== undefined) {
                        $("#saisi-banque-error").empty();
                        $("#saisi-banque-error").append(data.errors['saisi-banque']);
                    } else {
                        $("#saisi-banque-error").empty();
                    }

                    if(data.errors['saisi-facture'] !== undefined) {
                        $("#saisi-facture-error").empty();
                        $("#saisi-facture-error").append(data.errors['saisi-facture']);
                    } else {
                        $("#saisi-facture-error").empty();
                    }

                    if(data.errors['saisi-divers'] !== undefined) {
                        $("#saisi-divers-error").empty();
                        $("#saisi-divers-error").append(data.errors['saisi-divers']);
                    } else {
                        $("#saisi-divers-error").empty();
                    }

                    if(data.errors['difference-achat'] !== undefined) {
                        $("#difference-achat-error").empty();
                        $("#difference-achat-error").append(data.errors['difference-achat']);
                    } else {
                        $("#difference-achat-error").empty();
                    }

                    if(data.errors['difference-vente'] !== undefined) {
                        $("#difference-vente-error").empty();
                        $("#difference-vente-error").append(data.errors['difference-vente']);
                    } else {
                        $("#difference-vente-error").empty();
                    }

                    if(data.errors['difference-banque'] !== undefined) {
                        $("#difference-banque-error").empty();
                        $("#difference-banque-error").append(data.errors['difference-banque']);
                    } else {
                        $("#difference-banque-error").empty();
                    }

                    if(data.errors['difference-facture'] !== undefined) {
                        $("#difference-facture-error").empty();
                        $("#difference-facture-error").append(data.errors['difference-facture']);
                    } else {
                        $("#difference-facture-error").empty();
                    }

                    if(data.errors['difference-divers'] !== undefined) {
                        $("#difference-divers-error").empty();
                        $("#difference-divers-error").append(data.errors['difference-divers']);
                    } else {
                        $("#difference-divers-error").empty();
                    }

                } else {
                    if(data.step === true) {
                        $("#validation-compta").submit();
                    }
                }
            }
        });
    });
});

</script>

@endsection
