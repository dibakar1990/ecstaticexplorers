@extends('layouts.admin.app')
@section('title') Add Quote @endsection
@section('css') 
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection
@section('content')
<div class="page-wrapper">
    <div class="page-content"> 
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Users</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.quotes') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol> 
                </nav>
            </div>
        </div> 
        <div class="row">
            <div class="col-xl-12 mx-auto">
                <div class="card"> 
                    <div class="card-body p-4">
                        <form class="row g-3" id="createForm" method="post" action="{{ route('admin.quote.add.post') }}"> 
                        @csrf 
                            <div class="col-md-6">
                                <label class="form-label">Invoice Number</label>
                                <input type="text" class="form-control" name="invoice_number">  
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Place of Supply</label>
                                <input type="text" class="form-control" name="place_of_supply">  
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Transaction Category</label>
                                <input type="text" class="form-control" name="transaction_category">  
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Date</label>
                                <input type="text" class="form-control" name="date">  
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Transaction Type</label>
                                <input type="text" class="form-control" name="transaction_type">  
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Document Type</label>
                                <input type="text" class="form-control" name="document_type">  
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control" name="location">  
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Customer Name</label>
                                <input type="text" class="form-control" name="customer_name">  
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Travel Date</label>
                                <input type="text" class="form-control" name="travel_date">  
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Customer Contact Number</label>
                                <input type="text" class="form-control" name="customer_contact_number">  
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Total Pax</label>
                                <input type="text" class="form-control" name="total_pax">  
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Number of Adults</label>
                                <input type="text" class="form-control" name="number_of_adult">  
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Number of Children (5 to 10 yrs)</label>
                                <input type="text" class="form-control" name="number_of_children">  
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Number of Infants (0 to 5 yrs)</label>
                                <input type="text" class="form-control" name="number_of_infant">  
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Pick up Point</label>
                                <input type="text" class="form-control" name="pick_up_point">  
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Drop Point</label>
                                <input type="text" class="form-control" name="drop_point">  
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Transportation</label>
                                <input type="text" class="form-control" name="transportation">  
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">No. Of Room</label>
                                <input type="text" class="form-control" name="no_of_room">  
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label">Meal Plan</label>
                                <input type="text" class="form-control" name="meal_plan">  
                            </div> 
                            <div class="col-md-12">
                                <label class="form-label">Accommodation</label>
                                <textarea class="form-control summernote" name="accommodation" rows="5"></textarea> 
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Cost Breakup</label>
                                <textarea class="form-control summernote" name="cost_breakup" rows="5"></textarea> 
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Detailed Itinerary</label>
                                <textarea class="form-control summernote" name="itinerary" rows="5"></textarea> 
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Package Inclusions</label>
                                <textarea class="form-control summernote" name="package_inclusion" rows="5"></textarea> 
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Package Exclusion</label>
                                <textarea class="form-control summernote" name="package_exclusion" rows="5"></textarea> 
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Mode of Payment</label>
                                <textarea class="form-control summernote" name="mode_of_payment" rows="5"></textarea> 
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Terms & Conditions</label>
                                <textarea class="form-control summernote" name="term_condition" rows="5"></textarea> 
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Cancellation Policy</label>
                                <textarea class="form-control summernote" name="cancellation_policy" rows="5"></textarea> 
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
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(function() {
            'use strict'; 
            $('.summernote').summernote({
                height: 250
            }); 
        });
    </script> 
@endsection