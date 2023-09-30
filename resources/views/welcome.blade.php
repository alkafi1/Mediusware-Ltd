<!doctype html>
<html lang="en">


<!-- Mirrored from codervent.com/rocker/demo/vertical/authentication-signin.html by HTTrack Website Copier/3.x [XR&CO2014], Tue, 08 Mar 2022 15:17:46 GMT -->
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	{{--  <link rel="icon" href="{{ asset('/backend/images/favicon-32x32.png ') }}" type="image/png" />  --}}
	<!--plugins-->
	<link href="{{ asset('/backend/plugins/simplebar/css/simplebar.css ') }}" rel="stylesheet" />
	<link href="{{ asset('/backend/plugins/perfect-scrollbar/css/perfect-scrollbar.css ') }}" rel="stylesheet" />
	<link href="{{ asset('/backend/plugins/metismenu/css/metisMenu.min.css ') }}" rel="stylesheet" />
	<!-- loader-->
	<link href="{{ asset('/backend/css/pace.min.css ') }}" rel="stylesheet" />
	<script src="{{ asset('/backend/js/pace.min.js ') }}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{ asset('/backend/css/bootstrap.min.css ') }}" rel="stylesheet">
	<link href="{{ asset('/backend/css/bootstrap-extended.css ') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="{{ asset('/backend/css/app.css ') }}" rel="stylesheet">
	<link href="{{ asset('/backend/css/icons.css ') }}" rel="stylesheet">
	<title>Mediusware LTD</title>
</head>

<body class="bg-login">
	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="mb-4 text-center">
							<img src="{{ asset('/backend/images/logo-img.png ') }}" width="180" alt="" />
						</div>
						<div class="card">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="form-body">
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <a href="{{ route('login') }}" class="btn btn-primary">
                                                    <i class='bx bxs-log-in-circle'></i> Login
                                                </a>
                                            </div>
                                            <div class="d-grid mt-4">
                                                <a href="{{ route('register') }}" class="btn btn-primary">
                                                    <i class='bx bxs-log-in-circle'></i> Register
                                                </a>
                                            </div>
                                        </div>
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
	<script src="{{ asset('/backend/js/bootstrap.bundle.min.js ') }}"></script>
	<!--plugins-->
	<script src="{{ asset('/backend/js/jquery.min.js ') }}"></script>
	<script src="{{ asset('/backend/plugins/simplebar/js/simplebar.min.js ') }}"></script>
	<script src="{{ asset('/backend/plugins/metismenu/js/metisMenu.min.js ') }}"></script>
	<script src="{{ asset('/backend/plugins/perfect-scrollbar/js/perfect-scrollbar.js ') }}"></script>
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
		});
	</script>
	<!--app JS-->
	<script src="{{ asset('/backend/js/app.js ') }}"></script>
</body>


<!-- Mirrored from codervent.com/rocker/demo/vertical/authentication-signin.html by HTTrack Website Copier/3.x [XR&CO2014], Tue, 08 Mar 2022 15:17:47 GMT -->
</html>