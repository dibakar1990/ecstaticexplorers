@extends('layouts.admin.app')

@section('title')
    Profile
@endsection
@section('css')

@endsection
@section('content')

    <div class="page-wrapper">
        
        <div class="page-content">
            
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">User Profile</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="container">
                <div class="main-body">
                    <div class="row">
                        
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        @if ($user->file_path != '')
                                            <img src="{{ $user->file_path_url }}" id="profile_img_preview" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
                                        @else
                                            <img src="{{ asset('admin/assets/images/no-image.jpg') }}" id="profile_img_preview" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
                                        @endif
                                        <div class="mt-3">
                                            <h4>{{ $user->full_name ?? '' }}</h4>
                                            
                                            <p class="text-muted font-size-sm">{{ $user->mobile ?? '' }}</p>
                                        </div>
                                    </div>
                                    <hr class="my-4" />
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            
                            <div class="card border-top border-0 border-4 border-primary">
                               
                                <form id="profileForm" method="post" action="{{ route('admin.profile.update',['profile' => $user->id]) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">First Name</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="text" class="form-control" name="first_name" value="{{ $user->first_name ?? '' }}" />
                                                @error('first_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Last Name</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="text" class="form-control" name="last_name" value="{{ $user->last_name ?? '' }}" />
                                                @error('last_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Email</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary form-group">
                                                <input type="email" class="form-control" name="email" value="{{ $user->email ?? '' }}" />
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>                                                
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Mobile</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary form-group">
                                                <input type="text" class="form-control" name="mobile" value="{{ $user->mobile }}" />
                                                @error('mobile')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Image</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <div class="input-group mb-3">
                                                    <input type="file" class="form-control" name="file" id="profile_img"
                                                    onchange="document.getElementById('profile_img_preview').src = window.URL.createObjectURL(this.files[0]);"
                                                    accept="image/png, image/jpeg, image/jpg">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-9 text-secondary">
                                                <button type="submit" class="btn btn-sm btn-primary px-4 radius-30">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('admin/assets/plugins/validation/jquery.validate.min.js') }}"></script>
    <x-admin.toast-alert></x-admin.toast-alert>
    <script>
        $(function(){
        
        $('#profileForm').validate({
        ignore: [],
        debug: false,
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true,
            },
            email: {
                required: true,
                email:true,
            },
            mobile: {
                required: true,
                digits:true,
                maxlength: 11,
                minlength: 10,
            }
        },
        messages: {
            first_name: {
                required: "This field is required",
            },
            last_name: {
                required: "This field is required",
            },
            email: {
                required: "This field is required",
            },
            mobile: {
                required: "This field is required",
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.text-secondary').append(error);
        },
        highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        }
    });
       
    });
    </script>
   
@endsection