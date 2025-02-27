@extends('layouts.admin.app')

@section('title')
    HomeStays
@endsection
@section('css')
<link href="{{ asset('admin/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
<link href="{{ asset('admin/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/plugins/toastr/toastr.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">@yield('title')</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">List</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.homestays.create') }}" class="btn btn-sm btn-primary px-3 radius-30">Add New</a>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->
     
        <div class="row">
            <div class="col-xxl-2 col-lg-2 mb-3">
                <div class="form-group">
                    <select class="single-select" id="select_action" name="select_action">
                        <option value="">{{ __('Select Action') }}</option>
                        <option value="is_delete">{{ __('Delete') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-xxl-2 col-lg-2 mb-3">
                <button class="btn btn-dim btn-outline-primary disabled applyAction" id="apply_action">Apply</button>
            </div>
            <div class="col-xxl-2 col-lg-2 mb-3 filter-status">
                <div class="form-group">
                    <select class="single-select" id="filter_status" name="status">
                        <option value="">{{ __('Status Search') }}</option>
                        <option value="1">{{ __('Active') }}</option>
                        <option value="0">{{ __('Inactive') }}</option>
                    </select>
                </div>
            </div>
            
            <div class="col-xxl-2 col-lg-2 mb-3">
                <div class="form-group">
                    <select class="single-select" id="state_id" name="state_id">
                        <option value="">{{ __('State Search') }}</option>
                        @foreach ($states as $row)
                            <option value="{{ $row->id}}">{{ $row->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xxl-2 col-lg-2 mb-3">
                <div class="form-group">
                    <input id="searchbox" class="form-control" placeholder="Search...." type="search"></input>
                </div>
            </div>
        </div>
        
        <div class="card border-top border-0 border-4 border-primary">
           
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    <div class="form-check form-check-primary">
                                        <input class="form-check-input" type="checkbox" name="multi_check" id="multi_check" onclick="checkall()">
                                        <label class="form-check-label" for="multi_check"></label>
                                    </div>
                                </th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>State</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <input type="hidden" class="statusActionUrl" value="{{route('admin.homestay.status')}}">
                    <input type="hidden" class="actionUrl" value="{{route('admin.homestay.action')}}">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('admin/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/toastr/toastr.min.js') }}"></script>
<x-admin.status></x-admin.status>
<x-admin.toast-alert></x-admin.toast-alert>
<script>
    $(function () {
        $('.single-select').select2({
			theme: 'bootstrap4',
			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
			placeholder: $(this).data('Status Search'),
			allowClear: Boolean($(this).data('allow-clear')),
		});
      
        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            bInfo: false,
            bFilter:false,
            lengthChange: false,
            order: [[0, 'desc']],
            
            language: {
                processing: '<div class="spinner-border text-primary" role="status"> <span class="visually-hidden">Loading...</span></div>'
            },
            ajax: {
                url: "{{ route('admin.homestays.index') }}",
                data: function (d) {
                    d.status = $('#filter_status').val(),
                    d.state_id = $('#state_id').val(),
                    d.search = $('#searchbox').val()
                }
            },
            fnDrawCallback: function(oSettings) {
                if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
                    $(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
                } else {
                    $(oSettings.nTableWrapper).find('.dataTables_paginate').show();
                }
            },
            columns: [
                {data: 'id', name: 'id', visible: false},
                { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                {data: 'file_path_url', name: 'file_path_url', orderable: false, searchable: false},
                {data: 'title', name: 'title'},
                {data: 'state', name: 'state'},
                {data: 'location', name: 'location'},
                {data: 'status', name: 'status', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#filter_status').change(function(){
            table.draw();
        });
        $('#state_id').change(function(){
            table.draw();
        });

        $("#searchbox").keyup(function(){
            table.draw();
        });

        document.getElementById("searchbox").addEventListener("search", function(event) {
            table.draw();
        });
        
    });
</script>
@endsection