@extends('layouts.admin.app')

@section('title')
    Profile
@endsection
@section('css')

@endsection
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">User Profile</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <div class="card border-top border-0 border-4 border-primary">
                       
                        <div class="card-body p-5">
                            <form id="changePasswordForm" class="row g-3" method="post" action="{{ route('admin.update.password',['id' => $id]) }}">
                                @csrf
                                <div class="col-md-6 form-group">
                                    <label for="currentPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="currentPassword" id="currentPassword">
                                    @error('currentPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="newPassword" class="form-label">New Password</label>
                                    <input type="password" class="form-control" name="newPassword" id="newPassword">
                                    @error('newPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" name="confirmPassword" id="confirmPassword">
                                    @error('confirmPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-sm btn-primary px-4 radius-30">Change Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('admin/assets/plugins/validation/jquery.validate.min.js') }}"></script>
    <x-admin.toast-alert></x-admin.toast-alert>
   <script>
    $('#changePasswordForm').validate({
        ignore: [],
        debug: false,
        rules: {
            currentPassword: {
                required: true,
            },
            newPassword: {
                required: true,
                minlength: 5,
            },
            confirmPassword: {
                required: true,
                equalTo: '#newPassword'
            }
        },
        messages: {
            password: {
                required: "This field is required",
            },
            new_password: {
                required: "This field is required",
            },
            confirm_password: {
                required: "This field is required",
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        }
    });
   </script>
@endsection