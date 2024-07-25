@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<div class="position-relative mx-n4 mt-n4">
																<div class="profile-wid-bg profile-setting-img">
																				<img src="{{ asset("admin/images/logo.png") }}" class="profile-wid-img" alt="">
																</div>
												</div>

												<div class="row mt-5">

																<!--end col-->
																<div class="col-xxl-12 mt-5">
																				<div class="card mt-xxl-n5">
																								<div class="card-header">
																												<h4 class="card-title mb-0">Setting</h4>
																								</div>
																								<div class="card-body p-4">
																												<form action="javascript:void(0);" id="passwordForm">
																																<div class="row g-2">
																																				<div class="col-lg-4">
																																								<div>
																																												@include("admin.includes.password_input", [
																																																"key" => "old_password",
																																																"label" => "Old Password",
																																																"value" => "",
																																												])
																																								</div>
																																				</div>
																																				<!--end col-->
																																				<div class="col-lg-4">
																																								<div>
																																												@include("admin.includes.password_input", [
																																																"key" => "password",
																																																"label" => "Password",
																																																"value" => "",
																																												])
																																								</div>
																																				</div>
																																				<!--end col-->
																																				<div class="col-lg-4">
																																								<div>
																																												@include("admin.includes.password_input", [
																																																"key" => "confirm_password",
																																																"label" => "Confirm Password",
																																																"value" => "",
																																												])
																																								</div>
																																				</div>
																																				<!--end col-->
																																				<div class="col-lg-12 mt-3">
																																								<div class="text-end">
																																												<button type="submit" class="btn btn-success" id="submitBtn2">Change
																																																Password</button>
																																								</div>
																																				</div>
																																				<!--end col-->
																																</div>
																																<!--end row-->
																												</form>
																								</div>
																				</div>
																</div>
																<!--end col-->
												</div>
												<!--end row-->

								</div>
								<!-- container-fluid -->
				</div><!-- End Page-content -->

@stop

@section("javascript")
				<script type="text/javascript" nonce="{{ csp_nonce() }}">
								// initialize the validation library

								// initialize the validation library
								const validationPassword = new JustValidate('#passwordForm', {
												errorFieldCssClass: 'is-invalid',
												focusInvalidField: true,
												lockForm: true,
								});
								// apply rules to form fields
								validationPassword
												.addField('#password', [{
																				rule: 'required',
																				errorMessage: 'Password is required',
																},
																{
																				rule: 'strongPassword',
																}
												])
												.addField('#confirm_password', [{
																				rule: 'required',
																				errorMessage: 'Confirm Password is required',
																},
																{
																				validator: (value, fields) => {
																								if (fields['#password'] && fields['#password'].elem) {
																												const repeatPasswordValue = fields['#password'].elem.value;

																												return value === repeatPasswordValue;
																								}

																								return true;
																				},
																				errorMessage: 'Password and Confirm Password must be same',
																},
												])
												.addField('#old_password', [{
																rule: 'required',
																errorMessage: 'Old Password is required',
												}])
												.onSuccess(async (event) => {
																var submitBtn = document.getElementById('submitBtn2')
																submitBtn.innerHTML = spinner
																submitBtn.disabled = true;
																try {
																				var formData = new FormData();
																				formData.append('old_password', document.getElementById('old_password').value)
																				formData.append('password', document.getElementById('password').value)
																				formData.append('confirm_password', document.getElementById('confirm_password').value)
																				const response = await axios.post('{{ route("password.post") }}', formData)
																				successToast(response.data.message)
																				event.target.reset();
																} catch (error) {
																				if (error?.response?.data?.errors?.old_password) {
																								validationPassword.showErrors({
																												'#old_password': error?.response?.data?.errors?.old_password[0]
																								})
																				}
																				if (error?.response?.data?.errors?.password) {
																								validationPassword.showErrors({
																												'#password': error?.response?.data?.errors?.password[0]
																								})
																				}
																				if (error?.response?.data?.errors?.confirm_password) {
																								validationPassword.showErrors({
																												'#confirm_password': error?.response?.data?.errors?.confirm_password[0]
																								})
																				}
																				if (error?.response?.data?.message) {
																								errorToast(error?.response?.data?.message)
																				}
																} finally {
																				submitBtn.innerHTML = `
            Change Password
            `
																				submitBtn.disabled = false;
																}
												})
				</script>
@stop
