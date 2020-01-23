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

</div>
</div>
</div>

<div class="container-fluid" style="background: #162056 !important; padding-top: 15px;padding-bottom: 5px;">
    <div class="row">
        <div class="col-md-12">
            <div class="container">
                <div class="row">
                    <div class="col-md-12" style="margin-bottom: 65px; margin-top: 15px;">
                        <h3 style="color: white; float: left;">Ajout d'un document</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            <div class="container" style="margin-top: -50px;background:white;">
                @csrf

                <div class="row">
                    <div class="col-md-12 pt-3">
                        <p>
                            Seuls les fichiers contenant les extensions .png, .jpg, .gif, .bmp, .jpeg, .pdf sont acceptés
                        </p>
                        <p>
                            Le nombre de documents ne peut être supérieur à {{ $folder->piece }}
                        </p>
                        <p style="color: red;">
                            Dans le cas ou les règles ci-dessus ne sont pas respectées, les documents seront automatiquement exclus de la sélection
                        </p>
                    </div>
                </div>

                <div id="actions" class="row">
                    <div class="col-md-12 text-center mt-3 mb-3">
                         <a class="text-primary fileinput-button dz-clickable" style="text-decoration: underline;">
                             <span style="margin-left:10px">ajouter un ou plusieurs documents</span>
                         </a>
                    </div>
                </div>

                <div class="table data-table" id="previews">
                    <div id="template" class="file-row">
                        <div>
                            <p class="align-middle name" data-dz-name></p>
                            <strong class="error text-danger" data-dz-errormessage></strong>
                        </div>
                        <div>
                            <select class="dataTypeFile browser-default custom-select required">
                              <option value="" selected>Type de document</option>
                              <option value="Achat">Achat</option>
                              <option value="Vente">Vente</option>
                              <option value="Facture">Facture</option>
                              <option value="Banque">Banque</option>
                              <option value="Divers">Divers</option>
                            </select>
                        </div>
                        <div>
                            <button data-dz-remove class="btn btn-warning cancel">
                                <span>Retirer</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center ">
                <div class="">
                    <p>
                        <span style="color:red;" id="error-piece-upload"></span>
                    </p>
                    <p>
                        <span style="color:red;" id="error-type-upload"></span>
                    </p>
                </div>
                <a id="form-verification-button-submit" class="btn btn-primary" style="margin: 0 auto;">
                    Valider le scan
                </a>
            </div>
        </div>
    </div>
</div>

<form style="display:none;" id="validation-scanner" action="{{ route('folder_validation_scanner', ['id' => $folder->id]) }}" method="post">
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


    var previewNode = document.querySelector("#template");
    previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);

    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    var myDropzone = new Dropzone(".container", {
        url: "{{ route('upload', ['id' => $folder->id]) }}",
        maxFiles: {{ $folder->piece }},
        uploadMultiple: true,
        autoProcessQueue : false,
        previewTemplate: previewTemplate,
        previewsContainer: "#previews",
        clickable: ".fileinput-button",
        acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg,.pdf",
        init: function() {
            this.on("error", function(file) {
                this.removeFile(file);
            });
        }
    });

    $("#form-verification-button-submit").click(function(e) {
        function getValues() {
            var formData = new FormData();
            var fileRow = $(".dataTypeFile");
            var length = fileRow.length;
            var arrayType = [];

            var xfileAchat = 0;
            var xfileVente = 0;
            var xfileBanque = 0;
            var xfileFacture = 0;
            var xfileDivers = 0;

            for(var i = 0; i < length; i++) {
                var value = fileRow.get(i).value;
                arrayType.push(value);

                if (value === 'Achat') {
                    xfileAchat++;
                }

                if (value === 'Vente') {
                    xfileVente++;
                }

                if (value === 'Banque') {
                    xfileBanque++;
                }

                if (value === 'Facture') {
                    xfileFacture++;
                }

                if (value === 'Divers') {
                    xfileDivers++;
                }
            }

            var monArrayType = {
                'numberFileAchat' : xfileAchat,
                'numberFileVente' : xfileVente,
                'numberFileBanque' : xfileBanque,
                'numberFileFacture' : xfileFacture,
                'numberFileDivers' : xfileDivers,
            };

            for(let i = 0; i < myDropzone.getAcceptedFiles().length; i++){
                formData.append('file_' + i , myDropzone.getAcceptedFiles()[i]);
            }

            formData.append('_token', "{{ csrf_token() }}");
            formData.append('formData', $('#form-check').serialize());
            formData.append('filesTypeUpload', JSON.stringify(monArrayType));
            formData.append('arrayType', JSON.stringify(arrayType));

            return formData;
        }

        $.post({
            url: "{{ route('folder_scanner_post', $folder->id) }}",
            data: getValues(),
            processData: false, // required for FormData with jQuery
            contentType: false, // required for FormData with jQuery
            success: function(data) {

                var fileRow = $(".dataTypeFile");
                var length = fileRow.length;
                var errorType = false;

                var fileAchat = 0;
                var fileVente = 0;
                var fileBanque = 0;
                var fileFacture = 0;
                var fileDivers = 0;

                var realValueAchat = $("#achat").html();
                var realValueVente = $("#vente").html();
                var realValueBanque = $("#banque").html();
                var realValueFacture = $("#facture").html();
                var realValueDivers = $("#divers").html();

                for(var i = 0; i < length; i++) {
                    var value = fileRow.get(i).value;

                    if (value === 'Achat') {
                        fileAchat++;
                    }

                    if (value === 'Vente') {
                        fileVente++;
                    }

                    if (value === 'Banque') {
                        fileBanque++;
                    }

                    if (value === 'Facture') {
                        fileFacture++;
                    }

                    if (value === 'Divers') {
                        fileDivers++;
                    }
                }

                if (realValueAchat != fileAchat) {
                    errorType = true;
                }

                if (realValueVente != fileVente) {
                    errorType = true;
                }

                if (realValueBanque != fileBanque) {
                    errorType = true;
                }

                if (realValueFacture != fileFacture) {
                    errorType = true;
                }

                if (realValueDivers != fileDivers) {
                    errorType = true;
                }

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

                    if(data.errors['error-piece-upload'] !== undefined) {
                        $("#error-piece-upload").empty();
                        $("#error-piece-upload").append(data.errors['error-piece-upload']);
                    } else {
                        $("#error-piece-upload").empty();
                    }

                    if(data.errors['content-type-file'] !== undefined) {
                        $("#error-type-upload").empty();
                        $("#error-type-upload").append(data.errors['content-type-file']);
                    } else {
                        $("#error-type-upload").empty();
                    }
                } else {
                    if(data.step === true && errorType === false) {
                        $("#validation-scanner").submit();
                    }
                }
            }
        });
    });
});

</script>

@endsection
