@extends('layouts.admin.app')

@section('title')
    Dashboard
@endsection
@section('css')

@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            @if(Auth::guard('admin')->user()->is_super_admin == 1) 
            <div class="row">
                <div class="col-md-4">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total State</p>
                                    <h4 class="my-1">{{$dataCount['stateCount']}}</h4>
                                    
                                </div>
                                <div class="widgets-icons bg-light-success text-success ms-auto"><i class="fas fa-city"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total City</p>
                                    <h4 class="my-1">{{$dataCount['cityCount']}}</h4>
                                    
                                </div>
                                <div class="widgets-icons bg-light-warning text-warning ms-auto"><i class="fas fa-city"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Pakage</p>
                                    <h4 class="my-1">{{$dataCount['pakageCount']}}</h4>
                                    
                                </div>
                                <div class="widgets-icons bg-light-danger text-danger ms-auto"><i class='fas fa-clipboard-list'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Contact</p>
                                    <h4 class="my-1">{{$dataCount['contatCount']}}</h4>
                                    
                                </div>
                                <div class="widgets-icons bg-light-warning text-warning ms-auto"><i class="fas fa-envelope-open-text"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Blog</p>
                                    <h4 class="my-1">{{$dataCount['blogCount']}}</h4>
                                    
                                </div>
                                <div class="widgets-icons bg-light-danger text-danger ms-auto"><i class='fas fa-clipboard-list'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Quote</p>
                                    <h4 class="my-1">{{$dataCount['quoteCount']}}</h4>
                                    
                                </div>
                                <div class="widgets-icons bg-light-success text-success ms-auto"><i class="fas fa-envelope"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <!--end row-->
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h5 class="mb-0">Recent Contact</h5>
                        </div>
                       
                    </div>
                    <hr/>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $rowContact)
                                @php
                                    $sendMailUrl = route('admin.contact.send.mail',['id' => $rowContact->id ]);
                                    $showUrl = route('admin.contacts.show',['contact' => $rowContact->id ]);
                                    $deleteUrl = route('admin.contacts.destroy',['contact' => $rowContact->id]);
                                @endphp
                                <tr>
                                    <td>{{$rowContact->name}}</td>
                                    <td>
                                        {{$rowContact->email}}
                                    </td>
                                    <td>{{$rowContact->phone}}</td>
                                    <td>{{ Carbon\Carbon::parse($rowContact->created_at)->format('d M, Y')}}</td>
                                    
                                    <td>
                                        <div class="d-flex">
                                            <a href="javascript:;" class="btn btn-sm btn-outline-primary px-1 openPopup" data-action-url="{{$showUrl}}" data-title="Contact Details" data-bs-toggle="modal"><i class="bx bxs-show"></i></a>&nbsp;
                                            <a href="javascript:;" class="btn btn-sm btn-outline-success px-1 openPopup" data-action-url="{{$sendMailUrl}}" data-title="Send Mail {{$rowContact->email}}" data-bs-toggle="modal"><i class="lni lni-envelope"></i></a>&nbsp;
                                            <a href="javascript:;" class="ms-1 btn btn-sm btn-outline-danger px-1" data-bs-target="#deleteConfirm" data-bs-toggle="modal" onclick="deleteConfirm('{{$deleteUrl}}','Are you sure, want to delete?', 'Delete Contact Confirmation')"><i class="bx bxs-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md-4">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total State</p>
                                    <h4 class="my-1">{{$dataCount['stateCount']}}</h4>
                                    
                                </div>
                                <div class="widgets-icons bg-light-success text-success ms-auto"><i class="fas fa-city"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total City</p>
                                    <h4 class="my-1">{{$dataCount['cityCount']}}</h4>
                                    
                                </div>
                                <div class="widgets-icons bg-light-warning text-warning ms-auto"><i class="fas fa-city"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Pakage</p>
                                    <h4 class="my-1">{{$dataCount['pakageCount']}}</h4>
                                    
                                </div>
                                <div class="widgets-icons bg-light-danger text-danger ms-auto"><i class='fas fa-clipboard-list'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif 
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('admin/assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/index.js') }}"></script>
@endsection