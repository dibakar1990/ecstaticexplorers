@extends('layouts.admin.app')

@section('title')
    City Edit
@endsection
@section('css')
<link href="{{ asset('admin/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
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
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-xl-12 mx-auto">
                
                <div class="card">
                    <div class="card-body p-4">
                        <form class="row g-3" id="editForm" method="post" action="{{ route('admin.cities.update',['city' => $item->id]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-md-6 required">
                                <label for="state_id" class="form-label">State</label>
                                <select class="form-select single-select" id="state_id" data-placeholder="Choose state" name="state_id">
									<option value="">Choose State</option>
                                    @foreach($states as $state)
									<option value="{{ $state->id }}" @if($item->state_id == $state->id){{'selected'}}@endif>{{ $state->name }}</option>
                                    @endforeach
								</select>
                                @error('state_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6 required">
                                <label for="title" class="form-label">Name</label>
                                <input type="text" class="form-control" id="title" name="name" value="{{ $item->name }}" placeholder="City name">
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
                                        <input class="form-check-input" type="radio" name="top_destination" value="1" id="flexRadioSuccess" @if($item->top_destination == 1) {{ 'checked'}}@endif onclick="topDestination()">
                                        <label class="form-check-label" for="flexRadioSuccess">
                                        Yes
                                        </label>
                                    </div>
                                    <div class="form-check form-check-danger">
                                        <input class="form-check-input" type="radio" name="top_destination" value="0" id="flexRadioDanger" @if($item->top_destination == 0) {{ 'checked'}}@endif onclick="topDestination()">
                                        <label class="form-check-label" for="flexRadioDanger">
                                        No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @php
                                if($item->top_destination == 1){
                                    $display = '';
                                }else{
                                    $display = 'display:none';
                                }
                            @endphp
                            <div id="top_image" class="col-md-6 required" style="{{$display}}">
                                <label for="img" class="form-label">Top Destination Image</label>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" name="top_file" id="top_img"
                                    onchange="document.getElementById('top_img_preview').src = window.URL.createObjectURL(this.files[0]);"
                                    accept="image/*">
                                </div>
                                @if($item->top_destination_file_path !='')
                                <img src="{{ $item->top_destination_file_path_url }}" id="top_img_preview" class="rounded float-start no-image-preview" alt="...">
                                @else
                                    <img src="{{ asset('admin/assets/images/no-image.jpg') }}" id="top_img_preview" class="rounded float-start no-image-preview" alt="...">
                                @endif
                               
                            </div>
                            <div id="top_title" class="col-md-6 required" style="{{$display}}">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{$item->title}}" placeholder="Title">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="img" class="form-label">Image</label>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" name="file" id="img"
                                    onchange="document.getElementById('img_preview').src = window.URL.createObjectURL(this.files[0]);"
                                    accept="image/*">
                                </div>
                                @if ($item->file_path !='')
                                    <img src="{{ $item->file_path_url }}" id="img_preview" class="rounded float-start no-image-preview" alt="...">
                                @else
                                    <img src="{{ asset('admin/assets/images/no-image.jpg') }}" id="img_preview" class="rounded float-start no-image-preview" alt="...">
                                @endif
                               
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
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(function() {
    "use strict";
        $( '.multiple-select-field' ).select2( {
            theme: "bootstrap4",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: 'Choose tags',
            closeOnSelect: false,
        } );

        $('.summernote').summernote({
            height: 250,
        });
    });
    $('#editForm').validate({
        ignore: [],
        debug: false,
        rules: {
            name: {
                required:true
            }
        },
        messages: {
            name: {
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
            document.getElementById('title').required = true;
        } else {  
            $('#top_image').hide();
            $('#top_title').hide();  
            document.getElementById('title').required = false; 
        } 
    } 
</script>
@endsection