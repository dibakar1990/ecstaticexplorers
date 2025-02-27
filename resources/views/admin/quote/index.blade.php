@extends('layouts.admin.app')
@section('title') Quotes @endsection 
@section('content')  
<div class="page-wrapper">
    <div class="page-content"> 
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">@yield('title')</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">List</li>
                    </ol>
                </nav>
            </div> 
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.quote.add') }}" class="btn btn-sm btn-primary px-3 radius-30">Add Quote</a>
                </div>   
            </div>
        </div>  
        <div class="card border-top border-0 border-4 border-primary"> 
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" style="width: 100%;">
                        <thead> 
                            <tr> 
                                <th>Invoice Number</th>
                                <th>Customer Name</th>
                                <th>Travel Date</th>
                                <th>Customer Contact Number</th> 
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotes as $quote)
                                <tr>
                                    <td>{{ $quote->invoice_number }}</td>
                                    <td>{{ $quote->customer_name }}</td>
                                    <td>{{ $quote->travel_date }}</td>
                                    <td>{{ $quote->customer_contact_number }}</td>
                                    <td> 
                                        <div class="d-flex">
                                            <a href="{{ route('admin.quote.detail', encrypt($quote->id)) }}" class="btn btn-sm btn-outline-success px-1" target="_blank"><i class="bx bxs-download"></i></a>
                                            <a href="{{ route('admin.quote.update', encrypt($quote->id)) }}" class="ms-2 btn btn-sm btn-outline-primary px-1"><i class="bx bxs-edit"></i></a> 
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#deleteData" class="ms-2 btn btn-sm btn-outline-danger px-1" ><i class="bx bxs-trash"></i></a>
                                        </div>  
                                    </td>
                                </tr>  
                                <div class="modal fade" id="deleteData" tabindex="-1" aria-labelledby="deleteDataLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteDataLabel">Delete User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>   
                                            <div class="modal-body">
                                                <h6 class="text-center">Are you sure, you want to delete this quote?</h6>
                                            </div>    
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                <a href="{{ route('admin.quote.delete', encrypt($quote->id)) }}" type="button" class="btn btn-primary">Yes</a> 
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection  