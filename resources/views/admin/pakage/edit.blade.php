@extends('layouts.admin.app')

@section('title')
    Package Edit
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
                        <form class="row g-3" id="editForm" method="post" action="{{ route('admin.pakages.update',['pakage' => $item->id]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12 required">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $item->title }}" placeholder="Package title">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4 required">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-select single-select" id="category_id" placeholder="Choose category" name="category_id">
									<option value="">Choose category</option>
                                    @foreach($categories as $category)
									<option value="{{ $category->id }}" @if($item->category_id == $category->id) {{ 'selected' }}@endif>{{ $category->name }}</option>
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
									<option value="{{ $state->id }}" @if($item->state_id == $state->id) {{ 'selected' }}@endif>{{ $state->name }}</option>
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
									<option value="{{ $language->id }}" @if($item->language_id == $language->id) {{ 'selected' }}@endif>{{ $language->name }}</option>
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
                                <a class="btn btn-dim btn-outline-primary float-end add_city_field_button">
                                    {{ __('Add More') }}
                                </a>
                            </div>
                            <div id="input_city_fields_wrap">
                                @foreach($item->pakage_cities as $key => $pakageCity)
                                    <div class="row input-field-wrap" id="input_city_fields_wrap_{{$key}}">
                                        <div class="col-md-5 required">
                                            <select class="form-select single-select city-id" id="city_id_{{$key}}" data-placeholder="Choose city" name="cities[{{$key}}][city_id]" required>
                                                <option value="">Choose city</option>
                                                @foreach($cities as $city)
                                                <option value="{{ $city->id }}" @if($pakageCity->city_id == $city->id) {{'selected'}}@endif>{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5 required">
                                            <input type="text" class="form-control city-duration" id="city_duration_{{$key}}" name="cities[{{$key}}][city_duration]" value="{{ $pakageCity->duration}}" placeholder="Days" required>
                                        </div>
                                        <div class="col-md-2">
                                            <a class="ms-1 btn btn-sm btn-outline-danger px-1 remove_city_field" data-city-no="{{$key}}"><i class="bx bxs-trash"></i></a>
                                        </div>
                                    </div>
                                
                                @endforeach
                            </div>
                            <div class="col-md-12 required">
                                <label for="tag_id" class="form-label">Tags</label>
                                <select class="form-select multiple-select-field" id="tag_id" placeholder="Choose tags" name="tag_id[]" multiple>
									<option value="">Choose tag</option>
                                    @foreach($tags as $tag)
									<option value="{{ $tag->id }}" {{ $item->pakage_tags->pluck('theme_id')->contains($tag->id) ? 'selected' : '' }}>{{ $tag->name }}</option>
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
                                                @foreach($item->pakage_prices as $rowPrice)
                                                    @if(($rowPrice->month == $row['id']) && ($rowPrice->type_id == $type->id))
                                                    <div class="col-md-2 required">
                                                        <div class="form-check form-check-info">
                                                            <input type="hidden" value="{{ $type->id }}" name="price[{{$type->slug}}][{{$mkey}}][type_id]">
                                                            <input class="form-check-input" type="hidden" name="price[{{$type->slug}}][{{$mkey}}][month]" value="{{$row['id']}}">
                                                            <label class="form-check-label mt-1" for="flexCheckInfo{{$row['name']}}">
                                                            {{$row['name']}}
                                                            </label>
                                                            <input type="number" class="form-control mb-2" name="price[{{$type->slug}}][{{$mkey}}][price]" value="{{ $rowPrice->price }}" placeholder="Price" required>
                                                            
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-12 required">
                                        <label for="inineary" class="form-label">Tour Itinerary</label>
                                        <input type="hidden" value="{{ $type->id }}" name="itineraries[{{$type->slug}}][{{$key}}][type_id]">
                                        @foreach($item->pakage_itineraries as $rowItinerary)
                                        @if($type->id == $rowItinerary->type->id)
                                            <textarea class="form-control summernote" rows="5" name="itineraries[{{$type->slug}}][{{$key}}][tour_itinerary]" placeholder="Pakage tour itinerary" required>{{ $rowItinerary->tour_itinerary }}</textarea>
                                        @endif
                                        @endforeach
                                    </div>
                                    <div class="col-md-12 required">
                                        <label for="itinerary_description" class="form-label">Tour Itinerary Description</label>
                                        <input type="hidden" value="{{ $type->id }}" name="itinerary_descriptions[{{$type->slug}}][{{$key}}][type_id]">
                                        @foreach($item->pakage_itinerary_descriptions as $rowItineraryDescription)
                                            @if($type->id == $rowItineraryDescription->type->id)
                                                <textarea class="form-control summernote" rows="5" name="itinerary_descriptions[{{$type->slug}}][{{$key}}][tour_itinerary_description]" placeholder="Package tour itinerary description" required>{{ $rowItineraryDescription->tour_itinerary_description}}</textarea>
                                            @endif
                                        @endforeach
                                    </div>
                                    
                                </div>
                            @endforeach

                            <div class="col-md-4 required">
                                <label for="duration" class="form-label">Duration</label>
                                <input type="text" class="form-control" id="duration" name="duration" value="{{$item->duration }}" placeholder="Pakage duration">
                                @error('duration')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4 required">
                                <label for="total_price" class="form-label">Total Price</label>
                                <input type="number" class="form-control" id="total_price" name="total_price" value="{{ $item->total_price }}" placeholder="Pakage total price">
                                @error('total_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4 required">
                                <label for="lowest_price" class="form-label">Lowest Price</label>
                                <input type="number" class="form-control" id="lowest_price" name="lowest_price" value="{{ $item->lowest_price }}" placeholder="Pakage lowest price">
                                @error('lowest_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12 required">
                                <label for="short_description" class="form-label">Short Description</label>
                                <textarea class="form-control" rows="5" name="short_description" id="short_description" placeholder="Pakage short description">{{ $item->short_description }}</textarea>
                                @error('short_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12 required">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control summernote" rows="5" name="description" id="description" placeholder="Blog description">{{ $item->description }}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12 required">
                                <label for="" class="form-label">Pakage Feature</label>
                                <a class="btn btn-dim btn-outline-primary float-end btn btn-dim btn-outline-primary add_field_button">
                                    {{ __('Add More') }}
                                </a>
                            </div>
                            <div id="input_fields_wrap">
                                @foreach($item->pakage_features as $fkey => $pakageFeature)
                                <div class="row input-field-wrap" id="input_fields_wrap_{{$fkey}}">
                                    <div class="col-md-10 required">
                                        <input type="text" class="form-control pakage-feature" id="pakage_feature_{{$fkey}}" name="pakage_feature[]" value="{{ $pakageFeature->name }}" placeholder="Pakage Fature value" required>
                                        
                                    </div>
                                    <div class="col-md-2">
                                        <a class="ms-1 btn btn-sm btn-outline-danger px-1 remove_field" data-no="{{$key}}"><i class="bx bxs-trash"></i></a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="col-md-12">
                                <label for="inclusion" class="form-label">Tour Inclusion</label>
                                <textarea class="form-control summernote" rows="5" name="inclusion" id="inclusion" placeholder="Pakage inclusion" required>{{$item->tour_inclusion }}</textarea>
                                
                                @error('inclusion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="exclusion" class="form-label">Tour Exclusion</label>
                                <textarea class="form-control summernote" rows="5" name="exclusion" id="exclusion" placeholder="Pakage exclusion" required>{{$item->tour_exclusion }}</textarea>
                                
                                @error('exclusion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="booking_policy" class="form-label">Booking Policy</label>
                                <textarea class="form-control summernote" rows="5" name="booking_policy" id="booking_policy" placeholder="Pakage booking policy" required>{{$item->booking_policy }}</textarea>
                                
                                @error('booking_policy')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="cancellation_policy" class="form-label">Cancellation Policy</label>
                                <textarea class="form-control summernote" rows="5" name="cancellation_policy" id="cancellation_policy" placeholder="Pakage cancellation policy" required>{{$item->cancellation_policy }}</textarea>
                                
                                @error('cancellation_policy')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="summary" class="form-label">Package Summary</label>
                                <textarea class="form-control summernote" rows="5" name="summary" id="summary" placeholder="Package summary" required>{{$item->summary }}</textarea>
                                
                                @error('summary')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div> 
                            <div class="col-md-4">
                                <label for="top_selling" class="form-label">Top Selling</label>
                                <div class="d-flex align-items-center gap-3">
                                  
                                    <div class="form-check form-check-success">
                                        <input class="form-check-input" type="radio" name="top_selling" value="1" id="flexRadioSuccess" @if($item->top_selling == 1) {{ 'checked'}}@endif>
                                        <label class="form-check-label" for="flexRadioSuccess">
                                        Yes
                                        </label>
                                    </div>
                                    <div class="form-check form-check-danger">
                                        <input class="form-check-input" type="radio" name="top_selling" value="0" id="flexRadioDanger" @if($item->top_selling == 0) {{ 'checked'}}@endif>
                                        <label class="form-check-label" for="flexRadioDanger">
                                        No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="rated" class="form-label">Rated</label>
                                <input type="number" class="form-control" id="rated" name="rated" value="{{ $item->rated }}" placeholder="Package rated">
                                @error('rated')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="review" class="form-label">Review</label>
                                <input type="number" class="form-control" id="review" name="review" value="{{ $item->review }}" placeholder="Package review">
                                @error('review')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12 required">
                                <label for="" class="form-label">Pakage Do's</label>
                                <a class="btn btn-dim btn-outline-primary float-end btn btn-dim btn-outline-primary add_field_button_do">
                                    {{ __('Add More') }}
                                </a>
                            </div>
                            <div id="input_fields_wrap_do">
                                @foreach($item->pakage_do as $dkey => $pakageDo)
                                <div class="row input-field-wrap-do" id="input_fields_wrap_do_{{$dkey}}">
                                    <div class="col-md-10 required">
                                        <input type="text" class="form-control pakage-do" id="pakage_do_{{$dkey}}" name="pakage_do[]" value="{{ $pakageDo->title }}" placeholder="Pakage do value" required>
                                        
                                    </div>
                                    <div class="col-md-2">
                                        <a class="ms-1 btn btn-sm btn-outline-danger px-1 remove_field_do" data-no-do="{{$dkey}}"><i class="bx bxs-trash"></i></a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="col-md-12 required">
                                <label for="" class="form-label">Pakage Dont's</label>
                                <a class="btn btn-dim btn-outline-primary float-end btn btn-dim btn-outline-primary add_field_button_dont">
                                    {{ __('Add More') }}
                                </a>
                            </div>
                            <div id="input_fields_wrap_dont">
                                @foreach($item->pakage_dont as $dnkey => $pakageDont)
                                <div class="row input-field-wrap-dont" id="input_fields_wrap_dont_{{$dnkey}}">
                                    <div class="col-md-10 required">
                                        <input type="text" class="form-control pakage-dont" id="pakage_dont_{{$dnkey}}" name="pakage_dont[]" value="{{ $pakageDont->title }}" placeholder="Pakage dont value" required>
                                        
                                    </div>
                                    <div class="col-md-2">
                                        <a class="ms-1 btn btn-sm btn-outline-danger px-1 remove_field_dont" data-no-dont="{{$dnkey}}"><i class="bx bxs-trash"></i></a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="col-md-12 required">
                                <label for="" class="form-label">Itinerary</label>
                                <a class="btn btn-dim btn-outline-primary add_field_button_itinerary float-end">
                                    {{ __('Add More') }}
                                </a>
                            </div>
                            <div id="input_fields_wrap_itinerary">
                                @foreach($item->pakage_tour_itineraries as $ikey => $tour)
                                    <div class="row input-field-wrap-itinerary" id="input_fields_wrap_itinerary_{{$ikey}}">
                                        <div class="col-md-2 required">
                                            <label for="day_no" class="form-label">Day No.</label>
                                            <input type="number" class="form-control" id="day_no" value="{{$tour->day_no}}" name="tour_itineraries[{{$ikey}}][day_no]" placeholder="Day no" required>
                                            
                                        </div>
                                        <div class="col-md-2 required">
                                            <label for="day_no" class="form-label">Check In</label>
                                            <select class="form-select single-select" id="check_in" name="tour_itineraries[{{$ikey}}][check_in]" required>
                                                <option value="1" @if($tour->check_in == 1){{'selected'}}@endif>Yes</option>
                                                <option value="0" @if($tour->check_in == 0){{'selected'}}@endif>No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 required">
                                            <label for="sight_seeing" class="form-label">Sight Seeing</label>
                                            <select class="form-select single-select" id="sight_seeing" name="tour_itineraries[{{$ikey}}][sight_seeing]" required>
                                                <option value="1" @if($tour->sight_seeing == 1){{'selected'}}@endif>Yes</option>
                                                <option value="0" @if($tour->sight_seeing == 0){{'selected'}}@endif>No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 required">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="title" value="{{$tour->title}}" name="tour_itineraries[{{$ikey}}][title]" placeholder="Title" required>
                                            
                                        </div>
                                        <div class="col-md-6 required">
                                            <label for="title_text" class="form-label">Text</label>
                                            <input type="text" class="form-control" id="title_text" value="{{$tour->text}}" name="tour_itineraries[{{$ikey}}][title_text]" placeholder="Text" required>
                                            
                                        </div>
                                        <div class="col-md-4 required">
                                            <label for="stay_at" class="form-label">Stay At</label>
                                            <input type="text" class="form-control" id="stay_at" value="{{$tour->stay_at}}" name="tour_itineraries[{{$ikey}}][stay_at]" placeholder="Stay at" required>
                                            
                                        </div>
                                        <div class="col-md-2">
                                            <a class="ms-1 btn btn-sm btn-outline-danger px-1 remove_field_itinerary" data-no-itinerary="{{$ikey}}" style="margin-top:35px;"><i class="bx bxs-trash"></i></a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-12 required">
                                <label for="" class="form-label">Itinerary Hotel</label>
                                <a class="btn btn-dim btn-outline-primary add_city_field_button-hotel float-end">
                                    {{ __('Add More') }}
                                </a>
                            </div>
                            <div class="col-md-12 required">
                               
                                <div id="input_hotel_fields_wrap">
                                    @foreach($item->pakage_itinerary_hotels as $hkey => $hotel)
                                    <input type="hidden" class="form-control" value="{{$hotel->id}}" name="hotels[{{$hkey}}][id]">
                                        <div class="row input-field-wrap-hotel" id="input_hotel_fields_wrap_{{$hkey}}">
                                            <div class="col-md-3 required">
                                                <label for="type_id" class="form-label">Type</label>
                                                <select class="form-select single-select type-id" id="type_id" data-placeholder="Choose type" name="hotels[{{$hkey}}][type_id]" required>
                                                    <option value="">Choose type</option>
                                                    @foreach($types as $row)
                                                    <option value="{{ $row->id }}" @if($hotel->type_id == $row->id){{'selected'}}@endif>{{ $row->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 required">
                                                <label for="hotel_file" class="form-label">Hotel</label>
                                                <input type="file" class="form-control" name="hotels[{{$hkey}}][hotel_file]" id="img" accept="image/*" required>
                                               
                                                @if ($hotel->file_path !='')
                                                    <img src="{{ $hotel->file_path_url }}" id="img_preview" class="rounded float-start" alt="..." style="height: 50px; width:50px; margin-top:5px;">
                                                @endif
                                            </div>
                                            <div class="col-md-4 required">
                                                <label for="hotel_text" class="form-label">Text</label>
                                                <input type="text" class="form-control" value="{{$hotel->title}}" name="hotels[{{$hkey}}][hotel_text]" id="hotel_text">
                                            </div>
                                            <div class="col-md-2">
                                                <a class="ms-1 btn btn-sm btn-outline-danger px-1 remove_hotel_field" data-hotel-no="{{$hkey}}" style="margin-top:35px;"><i class="bx bxs-trash"></i></a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="img" class="form-label">Image</label>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" name="file[]" id="img" accept="image/*" multiple>
                                </div>
                                <div class="row preview-images-zone">
                                    @foreach($item->pakage_images as $rowImage)
                                        @if ($rowImage->file_path !='')
                                        <img src="{{ $rowImage->file_path_url }}" id="img_preview" class="rounded float-start no-image-preview" alt="...">
                                        @else
                                            <img src="{{ asset('admin/assets/images/no-image.jpg') }}" id="img_preview" class="rounded float-start no-image-preview" alt="...">
                                        @endif
                                    @endforeach
                                </div>
                               
                               
                            </div>
                            
                            
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                                    
                                </div>
                            </div>
                        </form>
                        <input type="hidden" id="last_city_id" value="{{count($item->pakage_cities)}}">
                        <input type="hidden" id="last_id" value="{{count($item->pakage_features)}}">
                        @php
                            $countPakageDo = count($item->pakage_do);
                            if($countPakageDo > 0 ){
                                $pakage_do = $countPakageDo;
                            }else{
                                $pakage_do = 1;
                            }
                            $countPakageDont = count($item->pakage_dont);
                            if($countPakageDont > 0 ){
                                $pakage_dont = $countPakageDo;
                            }else{
                                $pakage_dont = 1;
                            }
                           
                        @endphp
                        <input type="hidden" id="last_do_id" value="{{$pakage_do}}">
                        <input type="hidden" id="last_dont_id" value="{{$pakage_dont}}">
                        <input type="hidden" id="last_tour_itinerary_id" value="{{count($item->pakage_tour_itineraries)}}">
                        <input type="hidden" id="last_itinerary_hotel_id" value="{{count($item->pakage_itinerary_hotels)}}">
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
<x-admin.pakage.edit-script :cities="$cities" :types="$types"/>
@endsection