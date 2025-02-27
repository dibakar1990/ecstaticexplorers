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
                        <form class="row g-3" id="editForm" method="post" action="{{ route('admin.homestays.update',['homestay' => $item->id]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12 required">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" value="{{ $item->title }}" name="title" placeholder="Homestay title">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
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
                                <label for="location_id" class="form-label">Location</label>
                                <select class="form-select single-select" id="location_id" data-placeholder="Choose language" name="location_id">
									<option value="">Choose Location</option>
									<option value="{{ $item->location_id }}" @if($item->location_id == $item->location->id){{'selected'}}@endif>{{ $item->location->name }}</option>
                                   
								</select>
                                @error('location_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6 required">
                                <label for="property_classification" class="form-label">Property Classification</label>
                                <input type="text" class="form-control" value="{{ $item->property_classification }}" id="property_classification" name="property_classification" placeholder="Homestay property classification">
                                @error('property_classification')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6 required">
                                <label for="property_uniqueness" class="form-label">Property Uniqueness</label>
                                <input type="text" class="form-control" value="{{ $item->property_uniqueness }}" id="property_uniqueness" name="property_uniqueness" placeholder="Homestay property uniqueness">
                                @error('property_uniqueness')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6 required">
                                <label for="traiff" class="form-label">Traiff</label>
                                <input type="text" class="form-control" value="{{ $item->tariff }}" id="traiff" name="traiff" placeholder="Homestay traiff">
                                @error('traiff')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6 required">
                                <label for="price" class="form-label">Per Night Price</label>
                                <input type="text" class="form-control" value="{{ $item->price_per_night }}" id="price" name="price" placeholder="Homestay price">
                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12 required">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control summernote" rows="5" name="description" id="description" placeholder="Homestay description" required> {{ $item->description }} </textarea>
                                
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12 required">
                                <label for="benefit" class="form-label">Benefits</label>
                                <textarea class="form-control summernote" rows="5" name="benefit" id="description" placeholder="Homestay benefit" required> {{ $item->benefits }} </textarea>
                                
                                @error('benefit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="booking_policy" class="form-label">Booking Policy</label>
                                <textarea class="form-control summernote" rows="5" name="booking_policy" id="booking_policy" placeholder="Homestay booking policy" required>{{ $item->booking_policy }}</textarea>
                                
                                @error('booking_policy')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="cancellation_policy" class="form-label">Cancellation Policy</label>
                                <textarea class="form-control summernote" rows="5" name="cancellation_policy" id="cancellation_policy" placeholder="Homestay cancellation policy" required>{{ $item->cancellation_policy }}</textarea>
                                
                                @error('cancellation_policy')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <label for="" class="form-label">Facilities</label>
                            <div id="input_fields_wrap_itinerary">
                                <div class="col-md-2 float-end">
                                    <a class="btn btn-dim btn-outline-primary add_field_button_itinerary">
                                        {{ __('Add More') }}
                                    </a>
                                </div>
                                
                                <div class="row input-field-wrap-itinerary">
                                    <div class="col-md-6 required">
                                        <label for="title_text" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="title_text" name="facilities[0][title_text]" placeholder="Text" required>
                                        
                                    </div>
                                    <div class="col-md-4 required">
                                        <label for="bed" class="form-label">Bed</label>
                                        <input type="text" class="form-control" id="bed" name="facilities[0][bed]" placeholder="Bed" required>
                                        
                                    </div>
                                    <div class="col-md-2 required">
                                        <label for="occupancy" class="form-label">Occupancy</label>
                                        <input type="number" class="form-control" id="occupancy" name="facilities[0][occupancy]" placeholder="Occupancy" required>
                                        
                                    </div>
                                    <div class="col-md-5 required">
                                        <label for="toilet_with_geyser" class="form-label"> Attached western toilet with Geyser</label>
                                        <select class="form-select single-select" id="toilet_with_geyser" name="facilities[0][toilet_with_geyser]" required>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 required">
                                        <label for="view" class="form-label">View</label>
                                        <input type="text" class="form-control" id="view" name="facilities[0][view]" placeholder="Bed" required>
                                        
                                    </div>
                                    
                                    <div class="col-md-3 required">
                                        <label for="toilet" class="form-label">Attached Toilet</label>
                                        <select class="form-select single-select" id="toilet" name="facilities[0][toilet]" required>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 required">
                                        <label for="file_img" class="form-label">Image</label>
                                        <input type="file" class="form-control" name="facilities[0][facility_file]" id="file_img" accept="image/*" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 required">
                                <label for="img" class="form-label">Image</label>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" name="file[]" id="img" accept="image/*" multiple>
                                </div>
                                <div class="row preview-images-zone">
                                    @foreach($item->homestay_images as $rowImage)
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
                        <input type="hidden" id="last_facility_id" value="{{count($item->homestay_facilities)}}">
                        <input type="hidden" class="fetchCityActionUrl" value="{{route('admin.state-wise-location')}}">
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
<x-admin.homestay.edit-script/>
@endsection