@extends('layouts.admin.app')

@section('title')
    Application Setting
@endsection

@section('css')

@endsection

@section('content')

    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Setting</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-12 mx-auto">
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-2">
                            <div class="form-body mt-2">
                                <div class="border border-3 p-2 rounded">
                                    <div class="row">
                                        <div class="col-xxl-12 col-lg-12 col-md-12">
                                            <div class="item-top mb-30">
                                                <h6 class="mb-0 text-uppercase">@yield('title')</h6><br>
                                                <form id="appCreateForm" class="row g-3" method="post" action="{{ route('admin.application.setting.update',['id' => $setting->id]) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="col-md-6 form-group required">
                                                        <label for="name" class="form-label">Application Name</label>
                                                        
                                                        <input type="text" class="form-control" name="name" id="name" value="{{ $setting->app_title }}" placeholder="Enter application name">
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 form-group required">
                                                        <label for="email" class="form-label">Email</label>
                                                        
                                                        <input type="text" class="form-control" name="email" id="email" value="{{ $setting->email }}" placeholder="Enter email address">
                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 form-group required">
                                                        <label for="mobile" class="form-label">Mobile</label>
                                                        
                                                        <input type="text" class="form-control" name="mobile" id="mobile" value="{{ $setting->mobile }}" placeholder="Enter mobile number">
                                                        @error('mobile')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 form-group required">
                                                        <label for="whatsapp_number" class="form-label">Whatsapp Number</label>
                                                        
                                                        <input type="text" class="form-control" name="whatsapp_number" id="whatsapp_number" value="{{ $setting->whatsapp_number }}" placeholder="Enter whatsapp number">
                                                        @error('whatsapp_number')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-12 form-group required">
                                                        <label for="location" class="form-label">Location</label>
                                                        
                                                        <input type="text" class="form-control" name="location" id="location" value="{{ $setting->location }}" placeholder="Enter location">
                                                        @error('location')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    
                                                    <div class="col-md-6 form-group">
                                                        <label for="img" class="form-label">Logo</label>
                                                        <div class="input-group mb-3">
                                                            <input type="file" class="form-control" name="file" id="img"
                                                            onchange="document.getElementById('img_preview').src = window.URL.createObjectURL(this.files[0]);"
                                                            accept="image/png, image/jpeg, image/jpg">
                                                        </div>
                                                        @if($setting->file_path !='')
                                                            <img src="{{ $setting->file_path_url }}" id="img_preview" class="rounded float-start no-image-preview" alt="...">
                                                        @else
                                                            <img src="{{ asset('admin/assets/images/no-image.jpg') }}" id="img_preview" class="rounded float-start no-image-preview" alt="...">
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label for="img" class="form-label">Fav Icon</label>
                                                        <div class="input-group mb-3">
                                                            <input type="file" class="form-control" name="fav_file" id="fav_img"
                                                            onchange="document.getElementById('fav_img_preview').src = window.URL.createObjectURL(this.files[0]);"
                                                            accept="image/png, image/jpeg, image/jpg">
                                                        </div>
                                                        @if($setting->file_path_fav_icon !='')
                                                            <img src="{{ $setting->file_path_fav_url }}" id="fav_img_preview" class="rounded float-start no-image-preview" alt="...">
                                                        @else
                                                            <img src="{{ asset('admin/assets/images/no-image.jpg') }}" id="fav_img_preview" class="rounded float-start no-image-preview" alt="...">
                                                        @endif
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-sm btn-primary px-4 radius-30">Save</button>
                                                    </div>
                                                </form>
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
    </div>
@endsection

@section('js')
<script src="{{ asset('admin/assets/plugins/validation/jquery.validate.min.js') }}"></script>
<x-admin.toast-alert></x-admin.toast-alert>
<script>
    $(function(){
        
        $('#appCreateForm').validate({
            ignore: [],
            debug: false,
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                    email:true
                },
                mobile: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                whatsapp_number: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                location: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "This field is required",
                },
                email: {
                    required: "This field is required",
                },
                mobile: {
                    required: "This field is required",
                },
                whatsapp_number: {
                    required: "This field is required",
                },
                location: {
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
    });
</script>

@endsection