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
                            
                            <label for="" class="form-label"><strong>Package Do's</strong></label>
                            <div class="">
                                <a class="btn btn-dim btn-outline-primary float-end add_field_button_itineray">
                                    {{ __('Add More') }}
                                </a>
                            </div>
                            
                            <div id="input_fields_wrap_itineray_0_0" class="main-content" data-id="0">
                                <div class="row">
                                    <div class="col-md-2 required">
                                        <label for="day_no_iti_0" class="form-label">Day No.</label>
                                        <input type="number" class="form-control" id="day_no_iti_0" name="tour_itineraries[0][day_no]" required>
                                        
                                    </div>
                                    <div class="col-md-2 required">
                                        <label for="check_in_iti_0" class="form-label">Check In</label>
                                        <select class="form-select single-select" id="check_in_iti_0" name="tour_itineraries[0][check_in]" required>
                                            <option value="">Select</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 required">
                                        <label for="sight_seeing_iti_0" class="form-label">Sight Seeing</label>
                                        <select class="form-select single-select" id="sight_seeing_iti_0" name="tour_itineraries[0][sight_seeing]" required>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 required">
                                        <label for="title_iti_0" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="title_iti_0" name="tour_itineraries[0][title]" placeholder="Title" required>                                        
                                    </div>
                                    <div class="col-md-5 required">
                                        <label for="title_text_iti_0" class="form-label">Text</label>
                                        <input type="text" class="form-control" id="title_text_0" name="tour_itineraries[0][title_text]" placeholder="Text" required>                                        
                                    </div>
                                    <div class="col-md-5 required">
                                        <label for="stay_at__iti_0" class="form-label">Stay At</label>
                                        <input type="text" class="form-control" id="stay_at" name="tour_itineraries[0][stay_at]" placeholder="Stay at" required>                                        
                                    </div>
                                </div>
                                <label for="" class="form-label itineary-hotel"><strong>Hotel</strong></label>
                                <div class="">
                                    <a class="btn btn-dim btn-outline-primary float-end add-hotel-field-button">
                                        {{ __('Add More') }}
                                    </a>
                                </div>
                                <div id="input_hotel_fields_wrap_iti_0_0">
                                    <div class="row">
                                        <div class="col-md-3 required">
                                            <label for="type_id_hotel_iti_0" class="form-label">Type</label>
                                            <select class="form-select single-select type-id" id="type_id_hotel_iti_0" data-placeholder="Choose type" name="hotels[0][type_id]" required>
                                                <option value="">Choose type</option>
                                                @foreach($types as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 required">
                                            <label for="hotel_file_iti_0" class="form-label">Hotel</label>
                                            <input type="file" class="form-control" name="hotels[0][hotel_file]" id="hotel_file_iti_0" accept="image/*" required>
                                        </div>
                                        <div class="col-md-4 required">
                                            <label for="hotel_text_iti_0" class="form-label">Text</label>
                                            <input type="text" class="form-control" name="hotels[0][hotel_text]" id="hotel_text_iti_0">
                                        </div>
                                        
                                        
                                    </div>
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
<script>
    $( document ).ready(function() {
        var hotel_wrapper         = $("#input_hotel_fields_wrap_iti_0_0"); 
        var add_hotel_button      = $(".add-hotel-field-button"); 
        var h = 1;
        var wrapperItinerary        = $("#input_fields_wrap_itineray_0_0"); //Fields wrapper
        var add_button_itinerary     = $(".add_field_button_itineray"); //Add button ID
       
        var w = 1;
        //console.log(add_hotel_button);
        

        var count = 0;
        
        $(add_button_itinerary).click(function(e){ //on add input button click
           count += 1;
           alert(count);
           
            e.preventDefault();
            var html = '<div id="input_fields_wrap_itineray_'+count+'_'+w+'" data-id="'+w+'"><div class="row input-field-wrap-itineray">';
                html +='<div class="col-md-2 required"><label for="day_no_iti_'+w+'" class="form-label">Day No.</label>';
                html +='<input type="number" class="form-control" id="day_no_iti_'+w+'" name="tour_itineraries['+w+'][day_no]" required></div>';
                html +='<div class="col-md-2 required"><label for="check_in_iti_'+w+'" class="form-label">Check In</label>';
                html +='<select class="form-select single-select" id="check_in_iti_'+w+'" name="tour_itineraries['+w+'][check_in]" required><option value="">Select</option><option value="1">Yes</option><option value="0">No</option></select></div>';
                html +='<div class="col-md-2 required"><label for="sight_seeing_iti_'+w+'" class="form-label">Sight Seeing</label>';
                html +='<select class="form-select single-select" id="sight_seeing_iti_'+w+'" name="tour_itineraries['+w+'][sight_seeing]" required><option value="1">Yes</option><option value="0">No</option></select></div>';
                html +='<div class="col-md-4 required"><label for="title_iti_'+w+'" class="form-label">Title</label>';
                html +='<input type="text" class="form-control" id="title_iti_'+w+'" name="tour_itineraries['+w+'][title]" placeholder="Title" required></div>';
                html +='<div class="col-md-5 required"><label for="title_text_iti_'+w+'" class="form-label">Text</label><input type="text" class="form-control" id="title_text_'+w+'" name="tour_itineraries['+w+'][title_text]" placeholder="Text" required></div><div class="col-md-5 required"><label for="stay_at__iti_'+w+'" class="form-label">Stay At</label><input type="text" class="form-control" id="stay_at" name="tour_itineraries['+w+'][stay_at]" placeholder="Stay at" required></div></div><label for="" class="form-label itineary-hotel"><strong>Hotel</strong></label>';
                html +='<div class=""><a class="btn btn-dim btn-outline-primary float-end add-hotel-field-button">Add More</a></div>';
                html +='<div id="input_hotel_fields_wrap_iti_'+count+'_'+w+'"><div class="row input-field-wrap-hotel"><div class="col-md-3 required"><label for="type_id_hotel_iti_'+w+'" class="form-label">Type</label><select class="form-select single-select type-id" id="type_id_hotel_iti_'+w+'" data-placeholder="Choose type" name="hotels['+w+'][type_id]" required>';
                html +='<option value="">Choose type</option>';
                <?php foreach ($types as $tkey => $type):?>
            html +='<option value="{{ $type->id }}">{{ $type->name }}</option>';
            <?php endforeach ?>
            html +='</select></div><div class="col-md-3 required"><label for="hotel_file_iti_'+w+'" class="form-label">Hotel</label><input type="file" class="form-control" name="hotels['+w+'][hotel_file]" id="hotel_file_iti_0" accept="image/*" required></div><div class="col-md-4 required"><label for="hotel_text_iti_'+w+'" class="form-label">Text</label><input type="text" class="form-control" name="hotels['+w+'][hotel_text]" id="hotel_text_iti_'+w+'"></div></div></div></div>';
            $(wrapperItinerary).append(html);
            $('#check_in_'+w).select2({
                theme: 'bootstrap4',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                allowClear: Boolean($(this).data('allow-clear')),
            });
            $('#sight_seeing_'+w).select2({
                theme: 'bootstrap4',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                allowClear: Boolean($(this).data('allow-clear')),
            });
            w++;
            $(document).on("click", '.add-hotel-field-button', function(event) { 
                var parentID = $(this).parent().parent().attr('data-id');
            
                alert(parentID);
            //$(add_hotel_button).click(function(e){ 
                event.preventDefault();
                var html ='';
                html +='<div id="input_hotel_fields_wrap_iti_'+parentID+'_'+h+'">';
                html +='<div class="row"><div class="col-md-3 required"><select class="form-select type-id" id="type_id_iti_'+h+'" data-placeholder="Choose type" name="hotels['+h+'][type_id]" required><option value="">Choose type</option>';
                    <?php foreach ($types as $tkey => $type):?>
                    html +='<option value="{{ $type->id }}">{{ $type->name }}</option>';
                <?php endforeach ?>
                
                html +='</select></div><div class="col-md-3 required"><input type="file" class="form-control" name="hotels['+h+'][hotel_file]" id="img_'+h+'" accept="image/*"></div><div class="col-md-4 required"><input type="text" class="form-control" id="hotel_text'+h+'" name="hotels['+h+'][hotel_text]" placeholder="Days" required></div><div class="col-md-2"><a class="ms-1 btn btn-sm btn-outline-danger px-1 remove_hotel_field" data-hotel-no="input_hotel_fields_wrap_iti_'+parentID+'_'+h+'"><i class="bx bxs-trash"></i></a></div></div></div>';
                //if(parentID != h){
                    $(hotel_wrapper).append(html);
            // }

                $('#type_id'+h).select2({
                    theme: 'bootstrap4',
                    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                    placeholder: $( this ).data( 'placeholder' ),
                    allowClear: Boolean($(this).data('allow-clear')),
                });
                
                h++;
            });

            $(hotel_wrapper).on("click",".remove_hotel_field", function(e){ //user click on remove text
                e.preventDefault(); 
                var hotel_filed = $(this).attr('data-hotel-no');
                //alert(hotel_filed);
                $('#'+hotel_filed).remove();
            });
        });
        $(wrapperItinerary).on("click",".remove_field_itinerary", function(d){ //user click on remove text
            d.preventDefault(); 
            var num = $(this).attr('data-no-itinerary');
            $('#input_fields_wrap_itineray_'+num).remove();
        });
    });
        
    </script>
@endsection