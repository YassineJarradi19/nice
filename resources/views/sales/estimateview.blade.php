
@extends('layouts.master')
@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">  
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Demande d'achat</h3>
                        
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-white">ENVOYER</button>
                            <button class="btn btn-white">ANNULER</button>
                            <button class="btn btn-white"><i class="fa fa-print fa-lg"></i> Print</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 m-b-20">
                                    <img src="{{ URL::to('assets/img/logo2.png') }}" class="inv-logo" alt="">
                                    <ul class="list-unstyled">
                                        <li>Name:{{ auth()->user()->name }}</li>
                                        <li> Departement: {{auth()->user()->department }}</li>
                                         
                                    </ul>
                                </div>
                                <div class="col-sm-6 m-b-20">
                                    <div class="invoice-details">
                                        <h3 class="text-uppercase">ACHAT #{{$estimatesJoin[0]->estimate_number }}</h3>
                                        <ul class="list-unstyled">
                                            <li>Create Date: <span>{{date('d F, Y',strtotime($estimatesJoin[0]->estimate_date)) }}</span></li>
                                            <li>date souhaité: <span>{{date('d F, Y',strtotime($estimatesJoin[0]->expiry_date)) }}</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-12 m-b-20">
                                   
                                </div>
                            </div>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Article</th>
                                        <th class="d-none d-sm-table-cell">DESCRIPTION</th>
                                        <!-- <th>UNIT COST</th> -->
                                        <th>QUANTITY</th>
                                        <th>MOTIF DE DEMANDE</th>
                                        <!-- <th class="text-right">AMOUNT</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($estimatesJoin as $key=>$item )
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $item->item }}</td>
                                        <td><textarea class="form-control" rows="3" readonly>{{ $item->description }}</textarea></td>
                                        <td>{{ $item->qty }}</td>
                                        <td><textarea class="form-control" rows="3" readonly>{{ $item->motif }}</textarea></td>
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
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
    <!-- /Page Wrapper -->
 
    @section('script')
   
    @endsection
@endsection
