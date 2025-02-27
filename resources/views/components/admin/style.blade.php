@if(setting()->file_path_fav_icon !='')
	<link rel="icon" href="{{ setting()->file_path_fav_url }}" type="image/png" />
@endif
<!--plugins-->
<link href="{{ asset('admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset('admin/assets/plugins/notifications/css/lobibox.min.css')}}" />
<link href="{{ asset('admin/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet"/>

<!-- loader-->
<link href="{{ asset('admin/assets/css/pace.min.css') }}" rel="stylesheet"/>
<script src="{{ asset('admin/assets/js/pace.min.js') }}"></script>
<!-- Bootstrap CSS -->
<link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" rel="stylesheet"/>
<link href="{{ asset('admin/assets/css/app.css') }}" rel="stylesheet">
<link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet">
<link href="{{ asset('admin/assets/css/custom.css') }}" rel="stylesheet">
<!-- Theme Style CSS -->
<link rel="stylesheet" href="{{ asset('admin/assets/css/dark-theme.css') }}"/>
<link rel="stylesheet" href="{{ asset('admin/assets/css/semi-dark.css') }}"/>
<link rel="stylesheet" href="{{ asset('admin/assets/css/header-colors.css') }}"/>