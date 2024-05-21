@extends('layouts.master')

@section('content')
<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Créer un utilisateurs</h3>
                        </div>
                        
                    </div>
                </div>

                <div class="card-body">
                    <div class="alert alert-success" style="display:none;"></div>
                    <form method="POST" action="{{ route('user.store') }}" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    <div class="invalid-feedback">Please provide a name.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="prenom" class="form-label">Prenom</label>
                                    <input type="text" class="form-control" id="prenom" name="prenom">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div class="invalid-feedback">Please provide a valid email.</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="col-form-label">Role Name</label>
                                    <select class="select form-control" name="role_name" id="role_name">
                                        <option selected disabled>-- Select Role Name --</option>
                                        @foreach ($role as $name)
                                            <option value="{{ $name->role_type }}">{{ $name->role_type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="position" class="form-label">Position</label>
                                    <input type="text" class="form-control" id="position" name="position">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3 pt-4">
                                    <label class="form-label">Admin</label>
                                    <div class="d-flex">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="admin" id="adminYes" value="yes">
                                            <label class="form-check-label" for="adminYes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="admin" id="adminNo" value="no" checked>
                                            <label class="form-check-label" for="adminNo">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="department" class="form-label">Department</label>
                                    <input type="text" class="form-control" id="department" name="department">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <div class="invalid-feedback">Please provide a password.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                    <div class="invalid-feedback">Please confirm the password.</div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn bg-custom-blue text-white">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // Setup AJAX with CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('form').submit(function(event) {
        event.preventDefault(); // Prevent the form from submitting via the browser.

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    $('.alert-success').text(response.message).show();
                    $('form').trigger('reset'); // Optionally reset the form
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').hide();
                } else {
                    alert('Error: ' + (response.message || 'An error occurred without a message.'));
                }
            },
            error: function(xhr) {
                $('.is-invalid').removeClass('is-invalid');  // Remove existing invalid input highlights
                $('.invalid-feedback').hide();              // Hide existing error messages

                if (xhr.status === 422) {  // Laravel validation errors
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#' + key).addClass('is-invalid').next('.invalid-feedback').text(value[0]).show();
                    });
                } else {  // Other types of errors (500, 503, etc.)
                    alert('Error: ' + (xhr.responseJSON.message || xhr.statusText));
                }
            }
        });
    });
});
</script>
@endsection
@endsection
