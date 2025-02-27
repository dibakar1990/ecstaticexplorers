@extends('layouts.admin.app')

@section('title')
    Blog Create
@endsection
@section('css')
<link href="{{ asset('admin/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

@endsection
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Blogs</div>
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
                        <form class="row g-3" id="createForm" method="post" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12 required">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Blog title">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12 required">
                                <label for="text" class="form-label">Text</label>
                                <input type="text" class="form-control" id="text" name="text" placeholder="Blog text">
                                @error('text')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div> 
                            <div class="col-md-12 required">
                                <label for="blog_category_id" class="form-label">Category</label>
                                <select class="form-select single-select" id="blog_category_id" placeholder="Choose category" name="blog_category_id">
									<option value="">Choose category</option>
                                    @foreach($categories as $category)
									<option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
								</select>
                                @error('blog_category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12 required">
                                <label for="tag_id" class="form-label">Tags</label>
                                <select class="form-select multiple-select-field" id="tag_id" placeholder="Choose tags" name="tag_id[]" multiple>
									<option value="">Choose tag</option>
                                    @foreach($tags as $tag)
									<option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
								</select>
                                @error('tag_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12 required">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control summernote" rows="5" name="description" id="description" placeholder="Blog description"></textarea>
                                @error('description')
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

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
   $(function() {
    "use strict";
        $('.single-select').select2({
			theme: 'bootstrap4',
			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: 'Choose category',
			allowClear: Boolean($(this).data('allow-clear')),
		});

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

    $('#createForm').validate({
        ignore: [],
        debug: false,
        rules: {
            title: {
                required:true
            },
            blog_category_id: {
                required:true
            },
            "tag_id[]": {
                required:true
            },
            description: {
                required:true
            },
            file: {
                required: true,
                accept: "image/*",
            }
        },
        messages: {
            title: {
                required: "This field is required",
            },
            blog_category_id: {
                required: "This field is required",
            },
            "tag_id[]": {
                required:"This field is required"
            },
            description: {
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