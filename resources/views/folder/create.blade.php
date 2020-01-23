@extends('layouts.app')

@section('content')

<div class="container-fluid" style="background: #162056 !important; padding-top: 15px;padding-bottom: 5px;">
    <div class="row">
        <div class="col-md-12">
            <div class="container">
                <div class="row">
                    <div class="col-md-12" style="margin-bottom: 65px; margin-top: 15px;">
                        <h3 style="color: white; float: left;">Ouverture du dossier</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row" style="margin-top: -64px;background:white;padding: 40px;">
        <div class="col-md-12">
                <form id="formFolder" action="{{ route('folder_post') }}" method="post">
                @csrf

                    <div class="form-group row">
                        <label for="numFolder" class="col-md-4 col-form-label text-md-right">N ° dossier</label>

                        <div class="col-md-6">
                            <input id="numFolder" type="number" min="0" class="form-control @error('numFolder') is-invalid @enderror" name="numFolder" value="{{ old('numFolder') }}" autocomplete="numFolder">

                            @error('numFolder')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">Nom</label>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-11">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-1" style="display:flex;">
                                    <input id="searchNameInfo" class="align-top" type="checkbox" disabled name="" value="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="piece" class="col-md-4 col-form-label text-md-right">Nombre de pièce</label>

                        <div class="col-md-6">
                            <input id="piece" min="0" type="number" class="form-control @error('piece') is-invalid @enderror" name="piece" value="{{ old('piece') }}">

                            @error('piece')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <h3 class="pt-4">Saisi du nombre de document</h3>
                    <table class="table table-bordered data-table mb-5 mt-4">
                        <thead>
                            <tr>
                                <th>Achat</th>
                                <th>Vente</th>
                                <th>Facture</th>
                                <th>Banque</th>
                                <th>Divers</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="number" name="achat" min="0" class="form-control @error('achat') is-invalid @enderror" value="{{ old('achat') ? old('achat') : 0 }}">
                                    @error('achat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" name="vente" min="0" class="form-control @error('vente') is-invalid @enderror" value="{{ old('vente') ? old('vente') : 0 }}">
                                    @error('vente')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" name="facture" min="0" class="form-control @error('facture') is-invalid @enderror" value="{{ old('facture') ? old('facture') : 0 }}">
                                    @error('facture')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" name="banque" min="0" class="form-control @error('banque') is-invalid @enderror" value="{{ old('banque') ? old('banque') : 0 }}">
                                    @error('banque')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" name="divers" min="0" class="form-control @error('divers') is-invalid @enderror" value="{{ old('divers') ? old('divers') : 0 }}">
                                    @error('divers')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-center">
                            @error('comparaisonSum')
                            <div class="pb-3" style="color:red;">
                                <span>* {{ $message }}</span>
                            </div>
                            @enderror
                        <button type="submit" class="btn btn-primary" style="margin: 0 auto;">
                            Création du dossier
                        </button>
                    </div>

                </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $("#name").keyup(function() {
            var name = $(this).val();
            $.post({
                url: "{{ route('client_post_search') }}",
                data: {
                    'name': name,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(data) {
                    if(data.length !== 0) {
                        $("#searchNameInfo").prop("checked", true);
                    } else {
                        $("#searchNameInfo").prop("checked", false);
                    }
                }
            })
        });
    });
</script>

@endsection
