@extends('layouts.admin.app')

@section('title')
Gallery Create
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
            <div class="breadcrumb-title pe-3">Galleries</div>
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
                        <form class="row g-3" id="createForm" method="post" action="{{ route('admin.galleries.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12 required">
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
                            <div class="col-md-12 required">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Gallery title">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                           
                            <div class="col-md-12 required">
                                <label for="img" class="form-label">Image</label>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" name="file[]" id="img" accept="image/*" multiple>
                                </div>
                                <div class="row preview-images-zone">
                                </div>
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
     $(document).ready(function() {
        function readURL(input) {
            if (input.files && input.files[0]) {
                var filesAmount = input.files.length;
                let i;
                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var html = '<div class="col-md-2"><img src="' + e.target.result + '" class="rounded float-start no-image-preview"></div>';
                        $('.preview-images-zone').append(html);
                    }

                    reader.readAsDataURL(input.files[i]);
                }
            }
        }

        // Trigger image preview when file input changes
        $("input[name='file[]']").change(function() {
            readURL(this);
        });
    });
    $(function() {
        "use strict";
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
            title: {
                required:true 
            },
            "file[]": {
                required:true,
                accept: "image/*",
            }
        },
        messages: {
            state_id: {
                required: "This field is required",
            },
            title: {
                required: "This field is required",
            },
            "file[]": {
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