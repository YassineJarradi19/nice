@extends('layouts.master')
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Les Demandes Reçues</title>
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Demandes Reçues</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Demandes Reçues</li>
                        </ul>
                        <a href="{{ route('estimates.showCreateForUser') }}" class="btn btn-primary">Créer une demande pour un utilisateur</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Filter Panel -->
            <div class="row pb-3">
                <a href="#" class="btn add-btn-filter" data-toggle="collapse" data-target="#filter-panel"><i class="fa fa-filter"></i> Filter</a>
            </div>
            
            <div id="filter-panel" class="collapse filter-panel">
                <div class="panel panel-default">
                    <div class="panel-body pb-3">
                        <form action="{{ route('received.estimates.index') }}" method="GET">
                            <div class="row">
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label>Type de demande</label>
                                        <select class="form-control" name="type_demande">
                                            <option value="">Toutes les demandes</option>
                                            <option value="fourniture" {{ request('type_demande') == 'fourniture' ? 'selected' : '' }}>Fourniture</option>
                                            <option value="achat" {{ request('type_demande') == 'achat' ? 'selected' : '' }}>Achat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label>Date de</label>
                                        <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label>Date à</label>
                                        <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" name="status">
                                            <option value="">Tous les statuts</option>
                                            <option value="Validée" {{ request('status') == 'Validée' ? 'selected' : '' }}>Validée</option>
                                            <option value="Livré" {{ request('status') == 'Livré' ? 'selected' : '' }}>Livré</option>
                                            <option value="Refusée" {{ request('status') == 'Refusée' ? 'selected' : '' }}>Refusée</option>
                                            <option value="En cours de traitement" {{ request('status') == 'En cours de traitement' ? 'selected' : '' }}>En cours de traitement</option>
                                            <option value="Commandé" {{ request('status') == 'Commandé' ? 'selected' : '' }}>Commandé</option>
                                            <option value="Reçu" {{ request('status') == 'Reçu' ? 'selected' : '' }}>Reçu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-secondary">Filtrer</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="row">
                <div class="col-md-12">
                    @if($estimates->isEmpty())
                        <p>Aucune demande validée reçue.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Numero de demande</th>
                                        <th>Type de demande</th>
                                        <th>Date de création</th>
                                        <th>Date du besoin</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($estimates as $estimate)
                                        <tr>
                                            <td><a href="{{ url('estimate/view/'.$estimate->estimate_number) }}">{{ $estimate->estimate_number }}</a></td>
                                            <td>{{ $estimate->type_demande }}</td>
                                            <td>{{ \Carbon\Carbon::parse($estimate->estimate_date)->translatedFormat('d F, Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($estimate->expiry_date)->translatedFormat('d F, Y') }}</td>
                                            <td><span class="badge bg-inverse-success">{{ $estimate->status }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                          
                        </div>
                    @endif
                </div>
            </div>
            <!-- /Content -->
        </div>
        <!-- /Page Content -->
    </div>
@endsection
