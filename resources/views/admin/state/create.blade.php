@extends('layouts.admin.app')

@section('title')
    State Create
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
            <div class="breadcrumb-title pe-3">State</div>
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
                        <form class="row g-3" id="createForm" method="post" action="{{ route('admin.states.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                <label for="sl_no" class="form-label">Sl. No.</label>
                                <input type="text" class="form-control" id="sl_no" name="sl_no" placeholder="Sl. No."> 
                            </div>  
                            <div class="col-md-12 required">
                                <label for="title" class="form-label">Name</label>
                                <input type="text" class="form-control" id="title" name="name" placeholder="State name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12 required">
                                <label for="starting_price" class="form-label">Starting Price(Per Person)</label>
                                <input type="text" class="form-control" id="starting_price" name="starting_price" placeholder="Starting price">
                                @error('starting_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-3 required">
                                <label for="destination" class="form-label">Destinations</label>
                                <input type="number" class="form-control" id="destination" name="destination" placeholder="Destination">
                                @error('destination')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-3 required">
                                <label for="hotels" class="form-label">Hotels</label>
                                <input type="number" class="form-control" id="hotels" name="hotels" placeholder="Hotels">
                                @error('hotels')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-3 required">
                                <label for="tourist" class="form-label">Tourists</label>
                                <input type="number" class="form-control" id="tourist" name="tourist" placeholder="Tourists">
                                @error('tourist')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-3 required">
                                <label for="tour" class="form-label">Tours</label>
                                <input type="number" class="form-control" id="tour" name="tour" placeholder="Tours">
                                @error('tour')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="top_destination" class="form-label">Home Stay</label>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="form-check form-check-success">
                                        <input class="form-check-input" type="radio" name="is_home_stay" value="1" id="flexRadioSuccess">
                                        <label class="form-check-label" for="flexRadioSuccess">
                                        Yes
                                        </label>
                                    </div>
                                    <div class="form-check form-check-danger">
                                        <input class="form-check-input" type="radio" name="is_home_stay" value="0" id="flexRadioDanger">
                                        <label class="form-check-label" for="flexRadioDanger">
                                        No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="trending" id="trending" value="1" onclick="onTrending()">
                                            <label class="form-check-label" for="trending">Trending</label>
                                        </div>     
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="explore_state" id="explore_state" value="1">
                                            <label class="form-check-label" for="explore_state">Explore by States</label>
                                        </div>    
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="explore_unexplore" id="explore_unexplore" value="1">
                                            <label class="form-check-label" for="explore_unexplore">Explore the Unexplored</label>
                                        </div>      
                                    </div>  
                                </div>  
                            </div> 
                            <div class="col-md-6" id="trending_image" style="display: none;">    
                                <label class="form-label">Trending Image</label>   
                                <div class="input-group mb-3"> 
                                    <input type="file" class="form-control" name="trending_image" id="tnd_img" 
                                        onchange="document.getElementById('img_prev').src = window.URL.createObjectURL(this.files[0]);" accept="image/*">
                                </div>  
                                <img src="{{ asset('admin/assets/images/no-image.jpg') }}" id="img_prev" class="rounded float-start no-image-preview" alt="..."> 
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

    $('#createForm').validate({
        ignore: [],
        debug: false,
        rules: {
            name: {
                required:true
            },
            starting_price: {
                required:true 
            },
            destination: {
                required:true,
                digits:true
            },
            hotels: {
                required:true,
                digits:true
            },
            tourist: {
                required:true,
                digits:true
            },
            tour: {
                required:true,
                digits:true
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
            starting_price: {
                required: "This field is required",
            },
            destination: {
                required: "This field is required",
            },
            hotels: {
                required: "This field is required",
            },
            tourist: {
                required: "This field is required",
            },
            tour: {
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
    
    function onTrending() {
        if(document.querySelector('#trending').checked) {
            $('#trending_image').show(); 
            document.getElementById('tnd_img').required = true;
        } else {  
            $('#trending_image').hide();  
            document.getElementById('tnd_img').required = false; 
        } 
    } 
</script>
@endsection