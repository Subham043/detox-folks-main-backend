@extends("admin.layouts.auth")

@section("content")

				<div class="row justify-content-center">
								<div class="col-md-8 col-lg-6 col-xl-5">
												<div class="card mt-4">

																<div class="card-body p-4">
																				<div class="mt-2 text-center">
																								<h5 class="text-primary">Welcome Back !</h5>
																								<p class="text-muted">Sign in to continue to PARCEL COUNTER.</p>
																				</div>
																				<div class="mt-4 p-2">
																								<form id="loginForm" method="post" action="{{ route("login.post") }}">
																												@csrf
																												<div class="mb-3">
																																@include("admin.includes.input", [
																																				"key" => "email",
																																				"label" => "Email",
																																				"value" => old("email"),
																																])
																												</div>

																												<div class="mb-3">
																																<div class="float-end">
																																				<a href="{{ route("forgot_password.get") }}" class="text-muted">Forgot password?</a>
																																</div>
																																@include("admin.includes.password_input", [
																																				"key" => "password",
																																				"label" => "Password",
																																				"value" => "",
																																])
																												</div>

																												<div class="form-check">
																																<input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
																																<label class="form-check-label" for="auth-remember-check">Remember me</label>
																												</div>

																												<div class="mt-4">
																																<button class="btn btn-success w-100" type="submit">Sign In</button>
																												</div>
																												<div class="mt-4 text-center">
																																<p class="mb-0"><a href="{{ route("login_otp.get") }}"
																																								class="fw-semibold text-primary text-decoration-underline"> Click here</a> To Login
																																				with Phone Number & OTP</p>
																																<p class="mb-0"><a href="{{ route("register.get") }}"
																																								class="fw-semibold text-primary text-decoration-underline"> Click here</a> To Register</p>
																												</div>

																								</form>
																				</div>
																</div>
																<!-- end card body -->
												</div>
												<!-- end card -->

								</div>
				</div>

@stop

@section("javascript")
				<script type="text/javascript" nonce="{{ csp_nonce() }}">
								// initialize the validation library
								const validation = new JustValidate('#loginForm', {
												errorFieldCssClass: 'is-invalid',
												focusInvalidField: true,
												lockForm: true,
								});
								// apply rules to form fields
								validation
												.addField('#email', [{
																				rule: 'required',
																				errorMessage: 'Email is required',
																},
																{
																				rule: 'email',
																				errorMessage: 'Email is invalid!',
																},
												])
												.addField('#password', [{
																rule: 'required',
																errorMessage: 'Password is required',
												}])
												.onSuccess((event) => {
																event.target.submit();
												});
				</script>

@stop
