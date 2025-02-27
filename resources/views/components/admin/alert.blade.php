@if ($message = Session::get('success'))
<div class="alert border-0 border-start border-5 border-success alert-dismissible fade show">
    <div>{{ $message }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert  border-0 border-start border-5 border-danger alert-dismissible fade show">
    <div>{{ $message }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert  border-0 border-start border-5 border-warning alert-dismissible fade show">
    <div>{{ $message }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif