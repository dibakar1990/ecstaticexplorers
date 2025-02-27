@extends('layouts.admin.app')

@section('title')
    City Create
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
            <div class="breadcrumb-title pe-3">City</div>
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
        <div id="alertHide"><x-admin.alert></x-admin.alert></div>
        <div class="row">
            <div class="col-xl-12 mx-auto">
                
                <div class="card">
                    <div class="card-body p-4">
                        <form class="row g-3" id="createForm" method="post" action="{{ route('admin.cities.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6 required">
                                <label for="state_id" class="form-label">State</label>
                                <select class="form-select single-select" id="state_id" data-placeholder="Choose state" name="state_id">
									<option value="">Choose State</option>
                                    @foreach($states as $state)
									<option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
								</select>
                                @error('state_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6 required">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="City name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="top_destination" class="form-label">Top Destination</label>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="form-check form-check-success">
                                        <input class="form-check-input" type="radio" name="top_destination" value="1" id="flexRadioSuccess" onclick="topDestination()">
                                        <label class="form-check-label" for="flexRadioSuccess">
                                        Yes
                                        </label>
                                    </div>
                                    <div class="form-check form-check-danger">
                                        <input class="form-check-input" type="radio" name="top_destination" value="0" id="flexRadioDanger" onclick="topDestination()">
                                        <label class="form-check-label" for="flexRadioDanger">
                                        No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="top_image" class="col-md-6 required" style="display: none">
                                <label for="img" class="form-label">Top Destination Image</label>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" name="top_file" id="top_img"
                                    onchange="document.getElementById('top_img_preview').src = window.URL.createObjectURL(this.files[0]);"
                                    accept="image/*">
                                </div>
                                    <img src="{{ asset('admin/assets/images/no-image.jpg') }}" id="top_img_preview" class="rounded float-start no-image-preview" alt="...">
                               
                            </div>
                            <div id="top_title" class="col-md-6 required" style="display: none">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                                @error('title')
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
        $('.single-select').select2({
			theme: 'bootstrap4',
			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
			allowClear: Boolean($(this).data('allow-clear')),
		});
    });

    $('#createForm').validate({
        ignore: [],
        debug: false,
        rules: {
            state_id: {
                required:true
            },
            name: {
                required:true
            },
            file: {
                required: true,
                accept: "image/*",
            }
        },
        messages: {
            state_id: {
                required: "This field is required",
            },
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
    function topDestination() {
        var value = $('input:radio[name=top_destination]:checked').val();
        if(value == 1) {
            $('#top_image').show(); 
            $('#top_title').show(); 
            document.getElementById('top_img').required = true;
            document.getElementById('title').required = true;
        } else {  
            $('#top_image').hide();
            $('#top_title').hide();  
            document.getElementById('top_img').required = false;
            document.getElementById('title').required = false; 
        } 
    } 
</script>
@endsection