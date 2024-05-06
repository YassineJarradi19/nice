
@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Welcome {{ Session::get('name') }}!</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
                
            </div>
            <!-- /Page Header -->
            
            <!-- /Statistics Widget -->
            <div class="cardBox">
                <div class="card">
                    <div class="all-card">
                    <div class="cardsandnumbers">
                        <div class="cardName1">
                        <span class="span-total">Total Des Demande d'Achat</span>
                        </div>
                        <div class="numbers">20</div>
                    </div>
                    <div class="cardsandnumbers">
                        <div class="cardName">
                        <span class="span-valide">Demande Validé</span>
                        </div>
                        <div class="numbers">3</div>
                    </div>
                    <div class="cardsandnumbers">
                        <div class="cardName">
                        <span class="span-refuse">Demande Refusé</span>
                        </div>
                        <div class="numbers">7</div>
                    </div>
                    <div class="cardsandnumbers">
                        <div class="cardName">
                        <span class="span-attente">Demande En Attente</span>
                        </div>
                        <div class="numbers">9</div>
                    </div>
                    </div>

                    
                </div>

                <div class="card">
                    <div class="all-card">
                    <div class="cardsandnumbers">
                        <div class="cardName1">
                        <span class="span-total"
                            >Total Des Demande de Fourniture</span
                        >
                        </div>
                        <div class="numbers">20</div>
                    </div>
                    <div class="cardsandnumbers">
                        <div class="cardName">
                        <span class="span-valide">Demande Validé</span>
                        </div>
                        <div class="numbers">3</div>
                    </div>
                    <div class="cardsandnumbers">
                        <div class="cardName">
                        <span class="span-refuse">Demande Refusé</span>
                        </div>
                        <div class="numbers">7</div>
                    </div>
                    <div class="cardsandnumbers">
                        <div class="cardName">
                        <span class="span-attente">Demande En Attente</span>
                        </div>
                        <div class="numbers">9</div>
                    </div>
                    </div>

                    
                </div>
                </div>
        <!-- /Page Content -->
    </div>
@endsection