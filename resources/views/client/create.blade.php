@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <form id="formFolder" action="{{ route('client_post') }}" method="post">
                @csrf

                <div class="card-header">Création du client</div>
                <div class="card-body pt-5">

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">Nom</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="text-center pb-5">
                    <button type="submit" class="btn btn-primary" style="margin: 0 auto;">
                        Création du client
                    </button>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
