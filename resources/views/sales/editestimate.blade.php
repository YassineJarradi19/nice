
@extends('layouts.master')
@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
                
        <!-- Page Content -->
        <div class="content container-fluid">
        
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">modification de demande d'achat</h3>
                    
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('create/estimate/update') }}" method="POST">
                        @csrf
                        <input class="form-control" type="hidden" id="id" name="id" value="{{$estimates->id }}">
                        <input class="form-control" type="hidden" id="estimate_number" name="estimate_number" value="{{$estimates->estimate_number }}">
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                
                                <div class="form-group">
                                    <label>Client</label>
                                    <input class="form-control" type="text" id="client" name="client" value="{{$estimatesJoin[0]->client }}">
                                </div>
                            </div>
                           
                            
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" type="email" id="email" name="email" value="{{$estimatesJoin[0]->email }}">
                                </div>
                            </div>
                            

                            <div class="col-sm-6 col-md-3">
                             <div class="form-group">
                                <label>Date de création <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                <input class="form-control datetimepicker" type="text" id="estimate_date" name="estimate_date" value="{{$estimatesJoin[0]->estimate_date }}" readonly>
                                </div>
                            </div>
                            </div>

                            
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label>Date de besoin <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input class="form-control datetimepicker" type="text" id="expiry_date" name="expiry_date" value="{{$estimatesJoin[0]->expiry_date }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Motif de demande</label>
                                            <textarea class="form-control" rows="2" id="other_information" name="other_information">{{$estimatesJoin[0]->other_information }}</textarea>
                                        </div>
                                    </div>
                                </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-white" id="tableEstimate">
                                        <thead>
                                        <tr>
                                                <th style="width: 20px">#</th>
                                                <th class="col-sm-2">Article</th> <!-- Hia item f db estimate_adds-->
                                                <th class="col-md-6">Description</th> <!-- Hia description f db estimate_adds-->
                                                
                                                <th style="width:80px;">Quantité</th>  <!-- Hia qty f db estimate_adds-->
                                                
                                                <th> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($estimatesJoin as $key=>$item )
                                        <tr>
                                            <input type="hidden" name="estimates_adds[]" value="{{$item->id }}">
                                            <td hidden class="ids">{{ $item->id }}</td>
                                            <td>{{ ++$key }}</td>
                                            <td>
                                                <input class="form-control" type="text" id="item" name="item[]" value="{{ $item->item }}" style="min-width:150px">
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" id="description" name="description[]" value="{{ $item->description }}" style="min-width:150px">
                                            </td>
                                            

                                            <td>
                                                <input class="form-control qty" style="width:80px" type="text" id="qty" name="qty[]" value="{{ $item->qty }}">
                                            </td>
                                            
                                            @if($key =='1')
                                            <td><a href="javascript:void(0)" class="text-success font-18" title="Add" id="addBtn"><i class="fa fa-plus"></i></a></td>
                                            @endif
                                            @if($item->id ==!null)
                                                <td><a class="text-danger font-18 delete_estimate" href="#" data-toggle="modal" data-target="#delete_estimate" title="Remove"><i class="fa fa-trash-o"></i></a></td> 
                                            @else
                                            <td><a class="text-danger font-18 remove" href="#" title="Remove"><i class="fa fa-trash-o"></i></a></td> 
                                            @endif
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                               
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn m-r-10">Enregistrer et envoyer</button>
                            <button type="submit" class="btn btn-primary submit-btn">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Delete Estimate Modal -->
        <div class="modal custom-modal fade" id="delete_estimate" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Supression de l'article</h3>
                            <p>Voulez vous vraiment supprimer l'article ?</p>
                        </div>
                        <form action="{{ route('estimate_add/delete') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" class="e_id" value="">
                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary continue-btn submit-btn">Supprimer</button>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Annuler</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Estimate Modal -->
        
    </div>
    <!-- /Page Wrapper -->

    @section('script')
        {{-- delete model --}}
        <script>
            $(document).on('click','.delete_estimate',function()
            {
                var _this = $(this).parents('tr');
                $('.e_id').val(_this.find('.ids').text());
            });
        </script>

        <script>
            var rowIdx = 1;
            $("#addBtn").on("click", function ()
            {
                // Adding a row inside the tbody.
                $("#tableEstimate tbody").append(`
                <tr id="R${++rowIdx}">
                    <td class="row-index text-center"><p> ${rowIdx}</p></td>
                    <td><input class="form-control" type="text" style="min-width:150px" id="item" name="item[]"></td>
                    <td><input class="form-control" type="text" style="min-width:150px" id="description" name="description[]"></td>
                
                    <td><input class="form-control qty" style="width:80px" type="text" id="qty" name="qty[]"></td>
                
                    <td><a href="javascript:void(0)" class="text-danger font-18 remove" title="Remove"><i class="fa fa-trash-o"></i></a></td>
                </tr>`);
            });
            $("#tableEstimate tbody").on("click", ".remove", function ()
            {
                // Getting all the rows next to the row
                // containing the clicked button
                var child = $(this).closest("tr").nextAll();
                // Iterating across all the rows
                // obtained to change the index
                child.each(function () {
                // Getting <tr> id.
                var id = $(this).attr("id");

                // Getting the <p> inside the .row-index class.
                var idx = $(this).children(".row-index").children("p");

                // Gets the row number from <tr> id.
                var dig = parseInt(id.substring(1));

                // Modifying row index.
                idx.html(`${dig - 1}`);

                // Modifying row id.
                $(this).attr("id", `R${dig - 1}`);
            });
        
                // Removing the current row.
                $(this).closest("tr").remove();
        
                // Decreasing total number of rows by 1.
                rowIdx--;
            });

            
        </script>
    @endsection
@endsection
