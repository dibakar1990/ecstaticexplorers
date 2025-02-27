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
	<title>Syndron - Bootstrap 5 Admin Dashboard Template</title>
    <style>
        .invalid-feedback{
            display: inline !important;
        }
    </style>
</head>

<body>
	<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-reset-password d-flex align-items-center justify-content-center">
		 <div class="container">
			<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
				<div class="col mx-auto">
					<div class="card">
						<div class="card-body">
							<div class="p-4">
                                <div id="alertHide"><x-admin.alert></x-admin.alert></div>
								<div class="mb-4 text-center">
                                    @if(setting()->file_path !='')
											<img src="{{ setting()->file_path_url }}" alt="" />
                                    @else
                                        <img src="{{ asset('backend/assets/images/no-image.jpg') }}" alt="" />
                                    @endif
									
								</div>
								<div class="text-start mb-4">
									<h5 class="">Genrate New Password</h5>
									<p class="mb-0">We received your reset password request. Please enter your new password!</p>
								</div>
                                <form id="resetPasswordForm" action="{{route('admin.password.update',['token' => $token])}}" method="post">
                                    @csrf
                                    <div class="mb-3 mt-4">
                                        <label class="form-label">New Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password" />
                                        @error('confirm_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                    <div class="mb-4 mt-4">
                                        <label class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm password" />
                                        @error('confirm_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">Change Password</button> 
                                        <a href="{{ route('admin.login')}}" class="btn btn-light"><i class='bx bx-arrow-back mr-1'></i>Back to Login</a>
                                    </div>
                                </form>
							</div>
						</div>
					</div>
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
     $('#resetPasswordForm').validate({
        ignore: [],
        debug: false,
        rules: {
            password: {
                required: true,
            },
            confirm_password: {
                required: true,
                equalTo : '#password'
            },
        },
        messages: {
            password: {
                required: "This field is required",
            },
            confirm_password: {
                required: "This field is required",
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.mt-4').append(error);
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