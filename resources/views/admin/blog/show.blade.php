@extends('layouts.admin.app')

@section('title')
    Blog Details
@endsection
@section('css')
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
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
                    </ol>
                </nav>
            </div>
            
        </div>
        <!--end breadcrumb-->
        <div class="card">
            <div class="row g-0">
              <div class="col-md-4 border-end">
                @if($item->file_path !='')
                    <img src="{{ $item->file_path_url }}" class="img-fluid" alt="...">
                @endif
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h4 class="card-title">{{ $item->title }}</h4>
                  
                  <p class="card-text fs-6">
                    @foreach($item->blog_tags as $row)
                        <div class="chip">{{ $row->tag->name }}</div>
                    @endforeach
                  </p>
                  <dl class="row">
                    <dt class="col-sm-3">Category </dt>
                    <dd class="col-sm-9">{{ $item->blog_category->name }}</dd>
                    <dt class="col-sm-3">Created By# </dt>
                    <dd class="col-sm-9">{{ $item->user->full_name }}</dd>
                  
                    <dt class="col-sm-3">Translated By</dt>
                    <dd class="col-sm-9">{{ setting()->app_title ? config('app.name') : '' }}</dd>
                  </dl>
                  <hr>
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
                                <div class="tab-title"> Blog Description </div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#primaryprofile" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-bookmark-alt font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Tags</div>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="tab-content pt-3">
                    <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                        {!! $item->description !!}
                    </div>
                    <div class="tab-pane fade" id="primaryprofile" role="tabpanel">
                        @foreach($item->blog_tags as $row)
                            <div class="chip">{{ $row->tag->name }}</div>
                        @endforeach
                </div>
            </div>

          </div>
        
        
    </div>
</div>
@endsection

@section('js')

@endsection