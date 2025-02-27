<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow" />
	<!--favicon-->
    @if(setting()->file_path_fav_icon !='')
	<link rel="icon" href="{{ setting()->file_path_fav_url }}" type="image/png" />
	@else
	<link rel="icon" href="{{ asset('admin/assets/images/favicon.ico') }}" type="image/png" />
	@endif
	<!-- loader-->
	<link href="{{ asset('admin/assets/css/pace.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('admin/assets/js/pace.min.js') }}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('admin/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{ asset('admin/assets/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet">
	<title>Forgot-Password - {{ config('app.name') ?? null }}</title>
    <style>
        .invalid-feedback{
            display: inline !important;
        }
    </style>
</head>

<body class="">
	<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-forgot d-flex align-items-center justify-content-center">
			<div class="card forgot-box">
				<div class="card-body">
					<div class="p-3">
						<div class="text-center">
							<img src="{{ asset('admin/assets/images/icons/forgot-2.png') }}" width="100" alt="" />
						</div>
                        <div id="alertHide"><x-admin.alert></x-admin.alert></div>
						<h4 class="mt-5 font-weight-bold">Forgot Password?</h4>
						<p class="text-muted">Enter your registered email ID to reset the password</p>
                        <form id="forgotPassword" method="POST" action="{{ route('admin.password.email') }}">
                            @csrf
                            <div class="my-4">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" placeholder="Enter email" />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Send</button>
                                <a href="{{ route('admin.login') }}" class="btn btn-light"><i class='bx bx-arrow-back me-1'></i>Back to Login</a>
                            </div>
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
</body>
<script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/main.js') }}"></script>
<script>
    $('#forgotPassword').validate({
        ignore: [],
        debug: false,
        rules: {
            email: {
                required: true,
                email:true
            }
        },
        messages: {
            email: {
                required: "This field is required",
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.my-4').append(error);
        },
        highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        }
    });
</script>
</html>