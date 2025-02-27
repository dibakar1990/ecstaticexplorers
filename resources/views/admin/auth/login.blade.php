<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow" />
	<!--favicon-->
	@if(setting()->file_path_fav_icon !='')
	<link rel="icon" href="{{ setting()->file_path_fav_url }}" type="image/png" />
	@endif
	<!--plugins-->
	<link href="{{ asset('admin/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
	<!-- loader-->
	<link href="{{ asset('admin/assets/css/pace.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('admin/assets/js/pace.min.js') }}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('admin/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{ asset('admin/assets/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/custom.css') }}" rel="stylesheet">
	<title>Login - {{config('app.name')}}</title>
</head>

<body class="">
	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="card mb-0">
							<div class="card-body">
								<div class="p-4">
									
									<div class="mb-3 text-center">
										@if(setting()->file_path !='')
										<img src="{{ setting()->file_path_url }}" alt="" />
										@else
										<img src="{{ asset('admin/assets/images/no-image.jpg') }}" alt="" />
										@endif
									</div>
									<div class="text-center mb-4">
										<x-admin.alert/>
										<p class="mb-0">Please log in to your account</p>
										
									</div>
									<div class="form-body">
										<form id="loginForm" class="row g-3" method="POST" action="{{route('admin.login')}}">
                                            @csrf
											<div class="col-12">
												<label for="inputEmailAddress" class="form-label">Email</label>
												<input type="email" class="form-control" name="email" id="inputEmailAddress" placeholder="Enter email address">
                                                @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
											</div>
											<div class="col-12">
												<label for="inputChoosePassword" class="form-label">Password</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" class="form-control border-end-0" name="password" id="inputChoosePassword" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                                    
												</div>
                                                @error('password')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                               
											</div>
											<div class="col-md-6">
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="remember" {{ old('remember') != null ? 'checked' : '' }}>
													<label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
												</div>
											</div>
											<div class="col-md-6 text-end">	<a href="{{ route('admin.password.request') }}">Forgot Password ?</a>
											</div>
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn btn-primary">Sign in</button>
												</div>
											</div>
											
										</form>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>
	<!--plugins-->
	<script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/validation/jquery.validate.min.js') }}"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});

            $( "#loginForm" ).validate( {
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    }
                },
                messages: {
                    email: {
                        required: "This field is required"
                    },
                    password: {
                        required: "This field is required"
                    }
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.col-12').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }

            } );
		});
        
	</script>
	<!--app JS-->
	<script src="{{ asset('admin/assets/js/app.js') }}"></script>
</body>

</html>