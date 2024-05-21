@extends('layouts.master')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Liste de demande à valider</h3>
                    </div>
                </div>
            </div>

            <div class="row">
            <form action="{{ route('send.estimate') }}" method="POST">
                @csrf
                <input type="hidden" name="estimate_id" value="{{ $item->id }}">
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>

            <div class="row ">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0">
                            <thead>
                                <tr>
                                    <th>Numero de demande</th>
                                    <th>Type de demande</th>  <!-- Updated Column Header -->
                                    <th>Date de création</th>
                                    <th>Date du besoin</th>
                                    <th>Status</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($estimates as $item)
                                <tr>
                                    <td hidden class="ids">{{ $item->id }}</td>
                                    <td hidden class="estimate_number">{{ $item->estimate_number }}</td>
                                    <td><a href="{{ url('estimate/view/'.$item->estimate_number) }}">{{ $item->estimate_number }}</a></td>
                                    <td>{{ $item->type_demande }}</td>  <!-- Display Type de Demande -->
                                    <td>{{date('d F, Y', strtotime($item->estimate_date)) }}</td>
                                    <td>{{date('d F, Y', strtotime($item->expiry_date)) }}</td>
                                    <td><span class="badge bg-inverse-success">Acceptée</span></td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="{{ url('edit/estimate/'.$item->estimate_number) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item delete_estimate" href="#" data-toggle="modal" data-target="#delete_estimate"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                <form action="{{ route('send.estimate') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="estimate_id" value="{{ $item->id }}">
                                                    <button type="submit" class="dropdown-item"><i class="fa fa-send m-r-5"></i> Envoyer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>
@endsection
