@extends('layouts.admin.app')

@section('title')
    Package Details
@endsection
@section('css')
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
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
                    </ol>
                </nav>
            </div>
            
        </div>
        <!--end breadcrumb-->
        <div class="card">
            <div class="row g-0">
              <div class="col-md-4 border-end">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($item->pakage_images as $rowImage)
                            @php
                                if($rowImage->default_status == 1){
                                    $active = 'active';
                                }else{
                                    $active = '';
                                }
                            @endphp
                            @if($rowImage->file_path !=='')
                                <div class="carousel-item {{$active}}">
                                    <img src="{{$rowImage->file_path_url}}" class="d-block w-100" alt="...">
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev">	<span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next">	<span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
               
                
                <div class="row mb-3 row-cols-auto g-2 justify-content-center mt-3">
                    @foreach($item->pakage_images as $rowImage)
                    @if($rowImage->file_path !=='')
                        <div class="col"><img src="{{ $rowImage->file_path_url }}" width="100" height="100" class="border rounded cursor-pointer" alt=""></div>
                    @else
                        <div class="col"><img src="{{ asset('backend/assets/images/no-image.jpg') }}" width="70" class="border rounded cursor-pointer" alt=""></div>
                    @endif
                    @endforeach
                </div>
               
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h4 class="card-title">{{ $item->title }}</h4>
                    
                    <div class="d-flex gap-3">
                        <p class="card-text fs-6">
                            @foreach($item->pakage_tags as $rowTag)
                                <div class="chip active">{{ $rowTag->tag->name }}</div>
                            @endforeach
                        </p>
                    </div>
                    
                    <div class="mb-3"> 
                     {!! $item->short_description !!}
                    </div>
                    
                    <div class="row gy-3 gy-md-4">
                        <div class="col-12 col-lg-4">
                            <div class="card border-dark">
                            <div class="card-body p-3 p-md-4 p-xxl-5 d-flex justify-content-center align-items-center">
                                <div class="me-3 text-primary">
                                    <i class="fas fa-history"></i>
                                </div>
                                <div>
                                <h4 class="mb-1">Duration</h4>
                                <p class="mb-1 text-secondary">{{$item->duration}}</p>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card border-dark">
                                <div class="card-body p-3 p-md-4 p-xxl-5 d-flex justify-content-center align-items-center">
                                    <div class="me-3 text-primary">
                                        <i class="fas fa-city"></i>
                                    </div>
                                    <div>
                                    <h4 class="mb-1">Tour Type</h4>
                                    <p class="mb-1 text-secondary">{{$item->state->name}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card border-dark">
                                <div class="card-body p-3 p-md-4 p-xxl-5 d-flex justify-content-center align-items-center">
                                    <div class="me-3 text-primary">
                                        <i class="fas fa-language"></i>
                                    </div>
                                    <div>
                                    <h4 class="mb-1">Language</h4>
                                    <p class="mb-1 text-secondary">{{$item->language->name}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  <dl class="row">
                    <dt class="col-sm-3">Category#</dt>
                    
                    <dd class="col-sm-9">{{$item->category->name}}</dd>
                  
                    <dt class="col-sm-3">City</dt>
                    <dd class="col-sm-9">
                        @foreach ($item->pakage_cities as $rowCity)
                            {{$rowCity->city->name.' ('.$rowCity->duration.'D)'}} @if (!$loop->last)<i class="fas fa-arrow-right"></i>@endif 
                        @endforeach
                      
                    </dd>
                  
                    <dt class="col-sm-3">Price</dt>
                    <dd class="col-sm-9">
                        <ul class="nav nav-tabs nav-primary mb-0" role="tablist">
                            @foreach ($types as $key => $type)
                            @php
                                if($key == 0){
                                    $active = 'active';
                                }else{
                                    $active = '';
                                }
                            @endphp
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{$active}}" data-bs-toggle="tab" href="#primary{{$type->slug}}" role="tab" aria-selected="true">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-title"> {{$type->name}} </div>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="tab-content pt-3">
                            @foreach ($types as $key => $type)
                                @php
                                    if($key == 0){
                                        $active = 'show active';
                                    }else{
                                        $active = '';
                                    }
                                @endphp
                                <div class="tab-pane fade {{$active}}" id="primary{{$type->slug}}" role="tabpanel">
                                    <div class="row">
                                        @foreach($months as $row)
                                            @foreach($item->pakage_prices as $rowPrice)
                                                @if(($rowPrice->month == $row['id']) && ($rowPrice->type_id == $type->id))
                                                    <div class="col-12 col-lg-3">
                                                        <div class="mb-3"> 
                                                            <span class="price h4"><i class="fas fa-rupee-sign"></i>{{$rowPrice->price}}</span> 
                                                            <span class="text-muted">/{{$row['name']}}</span> 
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </dd>
                  </dl>
                  <hr>
                    <div class="row row-cols-auto row-cols-1 row-cols-md-12 align-items-center">
                        <div class="col">
                            <label class="form-label">Highlights of The Tour</label>
                            @foreach ($item->pakage_features as $pakageFeature)
                                <div class="form-check form-check-success">
                                    <input class="form-check-input" type="checkbox" id="flexCheckCheckedSuccess{{$pakageFeature->id}}" checked="" disabled>
                                    <label class="form-check-label" for="flexCheckCheckedSuccess{{$pakageFeature->id}}" style="opacity: inherit">
                                        {{$pakageFeature->name}}
                                    </label> 
                                </div>
                            @endforeach
                        </div> 
                    </div>
                </div>
              </div>
            </div>
            <hr/>
            <div class="card-body">
                <ul class="nav nav-tabs nav-primary mb-0" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab" aria-selected="true">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-comment-detail font-18 me-1'></i>
                                </div>
                                <div class="tab-title"> Tour Itinerary </div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#primaryInclusion" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-comment-detail font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Tour Inclusion</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#primaryExclusion" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-comment-detail font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Tour Exclusion</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#primaryBookingPolicy" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-comment-detail font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Booking Policy</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#primaryCancellationPolicy" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-comment-detail font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Cancellation Policy</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#primarySummary" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-comment-detail font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Summary</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#do_s" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">  
                                <div class="tab-icon"><i class='bx bx-comment-detail font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Do's</div>
                            </div> 
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#don_ts" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">  
                                <div class="tab-icon"><i class='bx bx-comment-detail font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Don'ts</div>
                            </div>  
                        </a>
                    </li>
                    
                </ul>
                <div class="tab-content pt-3">
                    <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                        <ul class="nav nav-tabs nav-primary mb-0" role="tablist">
                            @foreach ($types as $key => $type)
                            @php
                                if($key == 0){
                                    $active = 'active';
                                }else{
                                    $active = '';
                                }
                            @endphp
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{$active}}" data-bs-toggle="tab" href="#primary{{$type->slug.'-'.$key}}" role="tab" aria-selected="true">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-title"> {{$type->name}} </div>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="tab-content pt-3">
                            @foreach ($types as $key => $type)
                                @php
                                    if($key == 0){
                                        $active = 'show active';
                                    }else{
                                        $active = '';
                                    }
                                @endphp
                                <div class="tab-pane fade {{$active}}" id="primary{{$type->slug.'-'.$key}}" role="tabpanel">
                                    <div class="row">
                                        @foreach($item->pakage_itineraries as $rowItinerary)
                                            @if($rowItinerary->type_id == $type->id)
                                                <div class="col-12 col-lg-3">
                                                    <div class="mb-3"> 
                                                        <span class="text-muted">{!! $rowItinerary->tour_itinerary !!}</span> 
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="primaryInclusion" role="tabpanel">
                        <p>{!! $item->tour_inclusion !!}</p>
                    </div>
                    <div class="tab-pane fade" id="primaryExclusion" role="tabpanel">
                        <p>{!! $item->tour_exclusion !!}</p>
                    </div>
                    <div class="tab-pane fade" id="primaryBookingPolicy" role="tabpanel">
                        <p>{!! $item->booking_policy !!}</p>
                    </div>
                    <div class="tab-pane fade" id="primaryCancellationPolicy" role="tabpanel">
                        <p>{!! $item->cancellation_policy !!}</p>
                    </div>
                    <div class="tab-pane fade" id="primarySummary" role="tabpanel">
                        <p>{!! $item->summary !!}</p>
                    </div>
                    <div class="tab-pane fade" id="do_s" role="tabpanel">
                        <p>{!! $item->do_s !!}</p>
                    </div>
                    <div class="tab-pane fade" id="don_ts" role="tabpanel">
                        <p>{!! $item->don_ts !!}</p>
                    </div> 
                </div>
            </div>
        </div>
        
        
    </div>
</div>
@endsection

@section('js')

@endsection