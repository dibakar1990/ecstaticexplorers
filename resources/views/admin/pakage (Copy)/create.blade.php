@extends('layouts.admin.app')

@section('title')
Package Create
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
            <div class="breadcrumb-title pe-3">Packages</div>
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
                        <form class="row g-3" id="createForm" method="post" action="{{ route('admin.pakages.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12 required">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Package title">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4 required">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-select single-select" id="category_id" data-placeholder="Choose category" name="category_id">
									<option value="">Choose category</option>
                                    @foreach($categories as $category)
									<option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
								</select>
                                @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4 required">
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
                            <div class="col-md-4 required">
                                <label for="language_id" class="form-label">Language</label>
                                <select class="form-select single-select" id="language_id" data-placeholder="Choose language" name="language_id">
									<option value="">Choose Language</option>
                                    @foreach($languages as $language)
									<option value="{{ $language->id }}">{{ $language->name }}</option>
                                    @endforeach
								</select>
                                @error('language_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12 required">
                                <label for="city_id" class="form-label">City</label>
                                <div id="input_city_fields_wrap">
                                    <div class="row input-field-wrap">
                                        <div class="col-md-5 required">
                                            <select class="form-select single-select city-id" id="city_id" data-placeholder="Choose city" name="cities[0][city_id]" required>
                                                <option value="">Choose city</option>
                                                @foreach($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5 required">
                                            <input type="text" class="form-control city-duration" id="city_duration" name="cities[0][city_duration]" placeholder="Days" required>
                                        </div>
                                        <div class="col-md-2">
                                            <a class="btn btn-dim btn-outline-primary add_city_field_button">
                                                {{ __('Add More') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 required">
                                <label for="tag_id" class="form-label">Tags</label>
                                <select class="form-select multiple-select-field" id="tag_id" data-placeholder="Choose tags" name="tag_id[]" multiple>
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
                            @foreach($types as $key => $type)
                                @php
                                    if($type->slug == 'standard'){
                                        $star = '2 Star';
                                    }elseif ($type->slug == 'deluxe') {
                                        $star = '3 Star';
                                    }elseif ($type->slug == 'super-deluxe') {
                                        $star = '4 Star';
                                    }else{
                                        $star = '5 Star';
                                    }
                                @endphp
                                <div class="col-md-12 required">
                                    
                                    <label for="title" class="form-label"><strong>{{ $type->name }} Price({{ $star }})</strong></label>
                                        
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="row">
                                            @foreach($months as $mkey => $row)
                                            <div class="col-md-2 required">
                                                <div class="form-check form-check-info">
                                                    <input type="hidden" value="{{ $type->id }}" name="price[{{$type->slug}}][{{$mkey}}][type_id]">
                                                    <input class="form-check-input" type="hidden" name="price[{{$type->slug}}][{{$mkey}}][month]" value="{{$row['id']}}">
                                                    <label class="form-check-label mb-1" for="flexCheckInfo{{$row['name']}}">
                                                    {{$row['name']}}
                                                    </label>
                                                    <input type="text" class="form-control mb-2" name="price[{{$type->slug}}][{{$mkey}}][price]" placeholder="Price" required>
                                                </div> 
                                            </div>
                                            @endforeach
                                        </div>  
                                    </div>
                                    <div class="col-md-12 required">
                                        <label for="itineraries" class="form-label">Tour Itinerary</label>
                                        <input type="hidden" value="{{ $type->id }}" name="itineraries[{{$type->slug}}][{{$key}}][type_id]">
                                        <textarea class="form-control summernote" rows="5" name="itineraries[{{$type->slug}}][{{$key}}][tour_itinerary]" placeholder="Package tour itinerary" required></textarea>
                                    </div>
                                    <div class="col-md-12 required">
                                        <label for="itinerary_description" class="form-label">Tour Itinerary Description</label>
                                        <input type="hidden" value="{{ $type->id }}" name="itinerary_descriptions[{{$type->slug}}][{{$key}}][type_id]">
                                        <textarea class="form-control summernote" rows="5" name="itinerary_descriptions[{{$type->slug}}][{{$key}}][tour_itinerary_description]" placeholder="Package tour itinerary description" required></textarea>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-md-4 required">
                                <label for="duration" class="form-label">Duration</label>
                                <input type="text" class="form-control" id="duration" name="duration" placeholder="Package duration">
                                @error('duration')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4 required">
                                <label for="total_price" class="form-label">Total Price</label>
                                <input type="text" class="form-control" id="total_price" name="total_price" placeholder="Package total price">
                                @error('total_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4 required">
                                <label for="lowest_price" class="form-label">Lowest Price</label>
                                <input type="text" class="form-control" id="lowest_price" name="lowest_price" placeholder="Package lowest price">
                                @error('lowest_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div> 
                            <div class="col-md-12 required">
                                <label for="short_description" class="form-label">Short Description</label>
                                <textarea class="form-control" rows="5" name="short_description" id="short_description" placeholder="Package short description"></textarea>
                                @error('short_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12 required">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control summernote" rows="5" name="description" id="description" placeholder="Package description" required></textarea>
                                
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <label for="" class="form-label">Package Feature</label>
                            <div id="input_fields_wrap">
                                <div class="row input-field-wrap">
                                    <div class="col-md-10 required">
                                        <input type="text" class="form-control pakage-feature" id="pakage_feature" name="pakage_feature[]" placeholder="Package Fature value" required>
                                        
                                    </div>
                                    <div class="col-md-2">
                                        <a class="btn btn-dim btn-outline-primary add_field_button">
                                            {{ __('Add More') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <label for="inclusion" class="form-label">Tour Inclusion</label>
                                <textarea class="form-control summernote" rows="5" name="inclusion" id="inclusion" placeholder="Package inclusion" required></textarea>
                                
                                @error('inclusion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="exclusion" class="form-label">Tour Exclusion</label>
                                <textarea class="form-control summernote" rows="5" name="exclusion" id="exclusion" placeholder="Package exclusion" required></textarea>
                                
                                @error('exclusion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="booking_policy" class="form-label">Booking Policy</label>
                                <textarea class="form-control summernote" rows="5" name="booking_policy" id="booking_policy" placeholder="Package booking policy" required></textarea>
                                
                                @error('booking_policy')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="cancellation_policy" class="form-label">Cancellation Policy</label>
                                <textarea class="form-control summernote" rows="5" name="cancellation_policy" id="cancellation_policy" placeholder="Package cancellation policy" required></textarea>
                                
                                @error('cancellation_policy')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="summary" class="form-label">Package Summary</label>
                                <textarea class="form-control summernote" rows="5" name="summary" id="summary" placeholder="Package summary" required></textarea>
                                
                                @error('summary')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div> 
                            <div class="col-md-4">
                                <label for="top_destination" class="form-label">Top Selling</label>
                                <div class="d-flex align-items-center gap-3">
                                  
                                    <div class="form-check form-check-success">
                                        <input class="form-check-input" type="radio" name="top_selling" value="1" id="flexRadioSuccess">
                                        <label class="form-check-label" for="flexRadioSuccess">
                                        Yes
                                        </label>
                                    </div>
                                    <div class="form-check form-check-danger">
                                        <input class="form-check-input" type="radio" name="top_selling" value="0" id="flexRadioDanger">
                                        <label class="form-check-label" for="flexRadioDanger">
                                        No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="rated" class="form-label">Rated</label>
                                <input type="number" class="form-control" id="rated" name="rated" placeholder="Package rated">
                                @error('rated')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="review" class="form-label">Review</label>
                                <input type="number" class="form-control" id="review" name="review" placeholder="Package review">
                                @error('review')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <label for="" class="form-label">Package Do's</label>
                            <div id="input_fields_wrap_do">
                                <div class="row input-field-wrap-do">
                                    <div class="col-md-10 required">
                                        <input type="text" class="form-control package-do" id="pakage_do" name="pakage_do[]" placeholder="Package do value" required>
                                        
                                    </div>
                                    <div class="col-md-2">
                                        <a class="btn btn-dim btn-outline-primary add_field_button_do">
                                            {{ __('Add More') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <label for="" class="form-label">Package Dont's</label>
                            <div id="input_fields_wrap_dont">
                                <div class="row input-field-wrap-dont">
                                    <div class="col-md-10 required">
                                        <input type="text" class="form-control pakage-dont" id="pakage_dont" name="package_dont[]" placeholder="Package dont value" required>
                                        
                                    </div>
                                    <div class="col-md-2">
                                        <a class="btn btn-dim btn-outline-primary add_field_button_dont">
                                            {{ __('Add More') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <label for="" class="form-label">Itinerary</label>
                            <div id="input_fields_wrap_itinerary">
                                <div class="col-md-2 float-end">
                                    <a class="btn btn-dim btn-outline-primary add_field_button_itinerary">
                                        {{ __('Add More') }}
                                    </a>
                                </div>
                                <div class="row input-field-wrap-itinerary">
                                    <div class="col-md-2 required">
                                        <label for="day_no" class="form-label">Day No.</label>
                                        <input type="number" class="form-control" id="day_no" name="tour_itineraries[0][day_no]" placeholder="Day no" required>
                                        
                                    </div>
                                    <div class="col-md-2 required">
                                        <label for="day_no" class="form-label">Check In</label>
                                        <select class="form-select single-select" id="check_in" name="tour_itineraries[0][check_in]" required>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 required">
                                        <label for="sight_seeing" class="form-label">Sight Seeing</label>
                                        <select class="form-select single-select" id="sight_seeing" name="tour_itineraries[0][sight_seeing]" required>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 required">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="title" name="tour_itineraries[0][title]" placeholder="Title" required>
                                        
                                    </div>
                                    <div class="col-md-6 required">
                                        <label for="title_text" class="form-label">Text</label>
                                        <input type="text" class="form-control" id="title_text" name="tour_itineraries[0][title_text]" placeholder="Text" required>
                                        
                                    </div>
                                    <div class="col-md-6 required">
                                        <label for="stay_at" class="form-label">Stay At</label>
                                        <input type="text" class="form-control" id="stay_at" name="tour_itineraries[0][stay_at]" placeholder="Stay at" required>
                                        
                                    </div>
                                    <div id="input_hotel_fields_wrap_0">
                                        <div class="row input-field-wrap-hotel">
                                            <div class="col-md-2 required">
                                                <label for="type_id" class="form-label">Type</label>
                                                <select class="form-select single-select type-id" id="type_id" data-placeholder="Choose type" name="hotels[0][type_id]" required>
                                                    <option value="">Choose type</option>
                                                    @foreach($types as $row)
                                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 required">
                                                <label for="hotel_file" class="form-label">Hotel</label>
                                                <input type="file" class="form-control" name="hotels[0][hotel_file]" id="img" accept="image/*" required>
                                            </div>
                                            <div class="col-md-3 required">
                                                <label for="hotel_text" class="form-label">Text</label>
                                                <input type="text" class="form-control" name="hotels[0][hotel_text]" id="hotel_text">
                                            </div>
                                            <div class="col-md-2">
                                                <a class="ms-1 btn btn-sm btn-outline-danger px-1 remove_hotel_field" data-hotel-no="0"><i class="bx bxs-trash"></i></a></div></div>
                                                <a class="btn btn-dim btn-outline-primary add_city_field_button-hotel">
                                                    {{ __('Add More') }}
                                                </a>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 required">
                               
                               
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
                        <input type="hidden" class="fetchCityActionUrl" value="{{route('admin.state-wise-city')}}">
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
<x-admin.pakage.create-script :cities="$cities" :types="$types"/>

@endsection