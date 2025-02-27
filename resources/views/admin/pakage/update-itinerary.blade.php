@extends('layouts.admin.app')
@section('title') Update Itinerary @endsection
@section('content')   
<div class="page-wrapper">
    <div class="page-content"> 
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Users</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.package.itinerary', encrypt($itinerary->package_id)) }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Update</li> 
                    </ol>  
                </nav>
            </div>
        </div> 
        <div class="row">
            <div class="col-xl-12 mx-auto">
                <div class="card"> 
                    <div class="card-body p-4">    
                        <form class="row g-3" method="post" action="{{ route('admin.package.itinerary.update.post', encrypt($itinerary->id)) }}" enctype="multipart/form-data">  
                        @csrf 
                            <div class="col-md-6">
                                <label class="form-label">Type *</label>
                                <select class="form-control" name="type_id" required> 
                                    @for($i = 0; $i < count($type); $i++)
                                        <option value="{{ $type[$i]->id }}" @if($itinerary->type_id == $type[$i]->id) selected @endif>{{ $type[$i]->name }}</option>
                                    @endfor
                                </select> 
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Day No. *</label>
                                <input type="number" class="form-control" name="day_no" value="{{ $itinerary->day_no }}" required> 
                            </div>
                            <div class="col-md-6 mt-2">
                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control" name="title" value="{{ $itinerary->title }}" required> 
                            </div>
                            <div class="col-md-6 mt-2">
                                <label class="form-label">Check In *</label>
                                <select class="form-control" name="check_in" required>
                                    <option value="1" @if($itinerary->check_in == 1) selected @endif>Yes</option>
                                    <option value="0" @if($itinerary->check_in == 0) selected @endif>No</option>
                                </select>
                            </div> 
                            <div class="col-md-6 mt-2">
                                <label class="form-label">Sight Seeing *</label>
                                <select class="form-control" name="sight_seeing" required>
                                    <option value="1" @if($itinerary->sight_seeing == 1) selected @endif>Yes</option>
                                    <option value="0" @if($itinerary->sight_seeing == 0) selected @endif>No</option>
                                </select> 
                            </div> 
                            <div class="col-md-6 mt-2">
                                <label class="form-label">Text *</label>
                                <input type="text" class="form-control" name="text" value="{{ $itinerary->text }}" required> 
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="form-label">Stay At *</label>
                                <input type="text" class="form-control" name="stay_at" value="{{ $itinerary->stay_at }}" required> 
                            </div>
                            <!--<div class="col-md-12 mt-2">-->
                            <!--    <label class="form-label">Hotel *</label>  -->
                            <!--    <div id="add_data">  -->
                            <!--        <div class="row"> -->
                            <!--            <div class="col-md-5">-->
                            <!--                <input type="file" class="form-control" name="data_file[]" accept="image/*" required> -->
                            <!--            </div>-->
                            <!--            <div class="col-md-5 required">-->
                            <!--                <input type="text" class="form-control" name="data_title[]" placeholder="Text" required>  -->
                            <!--            </div> -->
                            <!--            <div class="col-md-2">-->
                            <!--                <a class="btn btn-dim btn-outline-primary" onclick="onAddData()">Add More</a>-->
                            <!--            </div>-->
                            <!--        </div> -->
                            <!--    </div>-->
                            <!--</div> -->
                            <div class="col-md-12 mt-4">
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
<script>
    var i = 0; 
    function onAddData() { 
        $('#add_data').append(
        '<div id="add_data_'+i+'"><div class="row mt-2"><div class="col-md-5"><input type="file" class="form-control" name="data_file[]" accept="image/*" required></div><div class="col-md-5 required"><input type="text" class="form-control" name="data_title[]" placeholder="Text" required></div><div class="col-md-2"><a class="btn btn-dim btn-outline-danger" onclick="deleteData('+i+')">Delete</a></div></div></div>'
        )  
        i++;
    }  
    function deleteData(e) {
        $('#add_data_'+e+'').remove(); 
    }   
</script>  