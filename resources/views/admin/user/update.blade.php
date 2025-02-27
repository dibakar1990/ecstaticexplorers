@extends('layouts.admin.app')
@section('title') Update User @endsection
@section('content')
<div class="page-wrapper">
    <div class="page-content"> 
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Users</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.users') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Update</li>
                    </ol> 
                </nav> 
            </div>
        </div> 
        <div class="row">
            <div class="col-xl-12 mx-auto">
                <div class="card"> 
                    <div class="card-body p-4">
                        <form class="row g-3" id="createForm" method="post" action="{{ route('admin.user.update.post', encrypt($user->id)) }}"> 
                        @csrf 
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}"> 
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror 
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}"> 
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror 
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Mobile No.</label>
                                <input type="number" class="form-control" name="mobile" value="{{ $user->mobile }}"> 
                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror 
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Email ID</label>
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}"> 
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror  
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