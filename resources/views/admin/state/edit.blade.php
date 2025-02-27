@extends('layouts.admin.app')

@section('title')
    State Edit
@endsection
@section('css')

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
                        <form class="row g-3" id="editForm" method="post" action="{{ route('admin.states.update',['state' => $item->id]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <label for="sl_no" class="form-label">Sl. No.</label>
                                <input type="text" class="form-control" id="sl_no" name="sl_no" value="{{ $item->sl_no }}" placeholder="Sl. No."> 
                            </div>  
                            <div class="col-md-12 required">
                                <label for="title" class="form-label">Name</label>
                                <input type="text" class="form-control" id="title" name="name" value="{{ $item->name }}" placeholder="State name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12 required">
                                <label for="starting_price" class="form-label">Starting Price(Per Person)</label>
                                <input type="text" class="form-control" id="starting_price" name="starting_price" value="{{ $item->starting_price }}" placeholder="Starting price">
                                @error('starting_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                            <div class="col-md-3 required">
                                <label for="destination" class="form-label">Destinations</label>
                                <input type="number" class="form-control" id="destination" name="destination" value="{{ $item->destination }}" placeholder="Destination">
                                @error('destination')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-3 required">
                                <label for="hotels" class="form-label">Hotels</label>
                                <input type="number" class="form-control" id="hotels" name="hotels" value="{{ $item->hotels }}" placeholder="Hotels">
                                @error('hotels')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-3 required">
                                <label for="tourist" class="form-label">Tourists</label>
                                <input type="number" class="form-control" id="tourist" name="tourist" value="{{ $item->tourist }}" placeholder="Tourists">
                                @error('tourist')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-3 required">
                                <label for="tour" class="form-label">Tours</label>
                                <input type="number" class="form-control" id="tour" name="tour" value="{{ $item->tour }}" placeholder="Tours">
                                @error('tour')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="top_destination" class="form-label">Top Destination</label>
                                <div class="d-flex align-items-center gap-3">
                                  
                                    <div class="form-check form-check-success">
                                        <input class="form-check-input" type="radio" name="is_home_stay" value="1" id="flexRadioSuccess" @if($item->is_home_stay == 1) {{ 'checked'}}@endif>
                                        <label class="form-check-label" for="flexRadioSuccess">
                                        Yes
                                        </label>
                                    </div>
                                    <div class="form-check form-check-danger">
                                        <input class="form-check-input" type="radio" name="is_home_stay" value="0" id="flexRadioDanger" @if($item->is_home_stay == 0) {{ 'checked'}}@endif>
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
                                            <input type="checkbox" class="form-check-input" name="trending" id="trending" value="1" onclick="onTrending()" @if($item->trending == 1) checked @endif>  
                                            <label class="form-check-label" for="trending">Trending</label>
                                        </div>    
                                    </div> 
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="explore_state" id="explore_state" value="1" @if($item->explore_state == 1) checked @endif>
                                            <label class="form-check-label" for="explore_state">Explore by States</label>
                                        </div>    
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="explore_unexplore" id="explore_unexplore" value="1" @if($item->explore_unexplore == 1) checked @endif>
                                            <label class="form-check-label" for="explore_unexplore">Explore the Unexplored</label>
                                        </div>       
                                    </div>  
                                </div>  
                            </div>   
                            <div class="col-md-6" id="trending_image">     
                                <label class="form-label">Trending Image</label>   
                                <div class="input-group mb-3"> 
                                    <input type="file" class="form-control" name="trending_image" id="tnd_img" 
                                        onchange="document.getElementById('img_prev').src = window.URL.createObjectURL(this.files[0]);" accept="image/*">
                                </div>  
                                @if($item->trending_image != '')
                                    <img src="{{ asset('storage/'.$item->trending_image) }}" id="img_prev" class="rounded float-start no-image-preview" alt="...">
                                @else  
                                    <img src="{{ asset('admin/assets/images/no-image.jpg') }}" id="img_prev" class="rounded float-start no-image-preview" alt="...">
                                @endif   
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

<script>
    
    $('#editForm').validate({
        ignore: [],
        debug: false,
        rules: {
            name: {
                required:true
            },
            starting_price: {
                required:true 
            }
        },
        messages: {
            name: {
                required: "This field is required",
            },
            starting_price: {
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
    
    var trending = "{{ $item->trending }}"; 
    if(trending == 1) {
        $('#trending_image').show(); 
        document.getElementById('tnd_img').required = true; 
    } else {
        $('#trending_image').hide();  
        document.getElementById('tnd_img').required = false;  
    }
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