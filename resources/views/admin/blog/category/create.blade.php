@extends('layouts.admin.app')

@section('title')
    Blog Category Create
@endsection
@section('css')
<link href="{{ asset('admin/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
@endsection
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Blog Category</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-xl-12 mx-auto">
                
                <div class="card">
                    <div class="card-body p-4">
                        <form class="row g-3" id="createForm" method="post" action="{{ route('admin.category.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12 required">
                                <label for="title" class="form-label">Name</label>
                                <input type="text" class="form-control" id="title" name="name" placeholder="Category name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6 required">
                                <label for="img" class="form-label">Image</label>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" name="file" id="img"
                                    onchange="document.getElementById('img_preview').src = window.URL.createObjectURL(this.files[0]);"
                                    accept="image/*">
                                </div>
                                    <img src="{{ asset('admin/assets/images/no-image.jpg') }}" id="img_preview" class="rounded float-start no-image-preview" alt="...">
                               
                            </div>
                            
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('admin/assets/plugins/validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/select2/js/select2.min.js') }}"></script>
<script>
   $(function() {
    "use strict";
        $( '.multiple-select-field' ).select2( {
            theme: "bootstrap4",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: 'Choose tags',
            closeOnSelect: false,
        } );
    });

    $('#createForm').validate({
        ignore: [],
        debug: false,
        rules: {
            name: {
                required:true
            },
            file: {
                required: true,
                accept: "image/*",
            }
        },
        messages: {
            name: {
                required: "This field is required",
            },
            file: {
                required: "This field is required",
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.required').append(error);
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