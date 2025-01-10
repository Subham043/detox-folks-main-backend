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
																								<form id="loginForm" method="post" action="{{ route("login_otp.post") }}">
																												@csrf
																												<div class="mb-3">
																																@include("admin.includes.input", [
																																				"key" => "phone",
																																				"label" => "Phone Number",
																																				"value" => old("phone"),
																																])
																												</div>

																												<div class="mb-3">
																																<div class="float-end">
																																				<button type="button" id="send_otp" class="text-muted btn btn-link p-0">Send
																																								OTP</button>
																																</div>
																																@include("admin.includes.input", [
																																				"key" => "otp",
																																				"label" => "OTP",
																																				"value" => "",
																																])
																												</div>

																												<div class="form-check">
																																<input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
																																<label class="form-check-label" for="auth-remember-check">Remember me</label>
																												</div>

																												<div class="mt-4">
																																<button class="btn btn-success w-100" id="loginBtn" type="submit">Sign In</button>
																												</div>
																												<div class="mt-4 text-center">
																																<p class="mb-0"><a href="{{ route("login_email.get") }}"
																																								class="fw-semibold text-primary text-decoration-underline"> Click here</a> To Login
																																				with Email & Password</p>
                                                                                                                                <p class="mb-0"><a href="{{ route("login_phone.get") }}"
																																								class="fw-semibold text-primary text-decoration-underline"> Click here</a> To Login
																																				with Phone Number & Password</p>
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
                    async function requestOTP() {
                        const otpInput = document.getElementById('otp');

                        // Check if the WebOTP API is available
                        if (!('OTPCredential' in window)) {
                            return;
                        }

                        try {
                            // Request the OTP via WebOTP API
                            const otp = await navigator.credentials.get({
                                otp: { transport: ['sms'] },
                                signal: new AbortController().signal, // Optional for aborting
                            });

                            // Fill the OTP input field with the received OTP
                            otpInput.value = otp.code;
                        } catch (error) {
                            console.error("Error fetching OTP:", error);
                        }
                    }

                    // Automatically request the OTP when the page loads
                    //window.onload = requestOTP;
                </script>
				<script type="text/javascript" nonce="{{ csp_nonce() }}">
								// initialize the validation library
								const validation = new JustValidate('#loginForm', {
												errorFieldCssClass: 'is-invalid',
												focusInvalidField: true,
												lockForm: true,
								});
								const validationOtp = new JustValidate('#loginForm', {
												errorFieldCssClass: 'is-invalid',
												focusInvalidField: true,
												lockForm: true,
								});
								// apply rules to form fields
								validation
												.addField('#phone', [{
																rule: 'required',
																errorMessage: 'Phone is required',
												}, ])
												.addField('#otp', [{
																rule: 'required',
																errorMessage: 'OTP is required',
												}])
												.onSuccess((event) => {
																event.target.submit();
												});
								validationOtp
												.addField('#phone', [{
																rule: 'required',
																errorMessage: 'Phone is required',
												}, ])

								document.getElementById("send_otp").addEventListener("click", async function() {
												var submitBtn = document.getElementById("send_otp");
												validationOtp.revalidateField('#phone').then(async (isValid) => {
																if (isValid) {
																				submitBtn.innerHTML = `Sending OTP...`
																				submitBtn.disabled = true;
																				document.getElementById("loginBtn").disabled = true
																				try {
																								var formData = new FormData();
																								formData.append('phone', document.getElementById('phone').value)
																								const response = await axios.post('{{ route("login_send_otp.post") }}',
																												formData)
                                                                                                await requestOTP()
																								successToast(response.data.message)
																				} catch (error) {
																								if (error?.response?.data?.message) {
																												errorToast(error?.response?.data?.message)
																								}
																				} finally {
																								submitBtn.innerHTML = `Send OTP`
																								submitBtn.disabled = false;
																								document.getElementById("loginBtn").disabled = false
																				}
																}
												})

								})
				</script>

@stop
