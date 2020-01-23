@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-5">

                <table class="mt-4 table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>Numéro de dossier</th>
                            <th>Date arrivé</th>
                            <th>Piece</th>
                            <th>Statut</th>
                            <th>Collaborateur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($client->folders as $folder)
                            <tr>
                                <td>{{ $folder->numFolder }}</td>
                                <td>{{ $folder->dateArrive }}</td>
                                <td>{{ $folder->piece }}</td>
                                <td>
                                    @if ($folder->status == 'to_scan')
                                        <span>à scanner</span>
                                    @elseif ($folder->status == 'to_compta')
                                        <span>à comptabiliser</span>
                                    @elseif ($folder->status == 'to_integrer')
                                        <span>à intégrer</span>
                                    @elseif ($folder->status == 'complete')
                                        <span>Complet</span>
                                    @endif
                                </td>
                                <th>
                                    {{ $folder->user->name }}
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
