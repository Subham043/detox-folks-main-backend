@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<div class="position-relative mx-n4 mt-n4">
																<div class="profile-wid-bg profile-setting-img">
																				<img src="{{ asset("admin/images/logo.webp") }}" class="profile-wid-img" alt="">
																</div>
												</div>

												<div class="row mt-5">

																<!--end col-->
																<div class="col-xxl-12 mt-5">
																				<div class="card mt-xxl-n5">
																								<div class="card-header">
																												<h4 class="card-title mb-0">Profile</h4>
																								</div>
																								<div class="card-body p-4">
																												<form action="javascript:void(0);" id="profileForm">
																																<div class="row">
																																				<div class="col-lg-4">
																																								@include("admin.includes.input", [
																																												"key" => "name",
																																												"label" => "Name",
																																												"value" => Auth::user()->name,
																																								])
																																				</div>
																																				<!--end col-->
																																				<div class="col-lg-4">
																																								@include("admin.includes.input", [
																																												"key" => "email",
																																												"label" => "Email (Optional)",
																																												"value" => Auth::user()->email,
																																								])
																																								@if (Auth::user()->email_verified_at)
																																												<p class="d-flex align-items-center gap-1"><code><span>Verified
																																																								Email</span></code>
																																												</p>
																																								@else
																																												<p class="mb-0 pb-0"><code>Note:</code> Please <a class="btn btn-link p-0"
																																																				href="{{ route("admin_email.verification.send") }}">click
																																																				here</a>
																																																to verify your email</p>
																																								@endif
																																				</div>
																																				<!--end col-->
																																				<div class="col-lg-4">
																																								@include("admin.includes.input", [
																																												"key" => "phone",
																																												"label" => "Phone",
																																												"value" => Auth::user()->phone,
																																								])
																																								{{-- @if (Auth::user()->phone_verified_at)
																																												<p class="d-flex align-items-center gap-1"><code><span>Verified
																																																								Phone</span></code>
																																												</p>
																																								@else
																																												<p><code>Note:</code> Please <button class="btn btn-link p-0"
																																																				data-bs-toggle="modal" type="button"
																																																				data-bs-target="#exampleModal">click
																																																				here</button>
																																																to verify your phone</p>
																																								@endif --}}
																																				</div>
																																				<!--end col-->

																																				<div class="col-lg-12 mt-2">
																																								<div class="hstack justify-content-end gap-2">
																																												<button type="submit" class="btn btn-primary" id="submitBtn">Update</button>
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
				<div class="modal" id="exampleModal" tabindex="-1">
								<div class="modal-dialog">
												<div class="modal-content">
																<div class="modal-header">
																				<h5 class="modal-title">Modal title</h5>
																				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
																</div>
																<div class="modal-body">
																				<p>Modal body text goes here.</p>
																</div>
																<div class="modal-footer">
																				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
																				<button type="button" class="btn btn-primary">Save changes</button>
																</div>
												</div>
								</div>
				</div>

@stop

@section("javascript")
				<script type="text/javascript" nonce="{{ csp_nonce() }}">
								// initialize the validation library
								const validation = new JustValidate('#profileForm', {
												errorFieldCssClass: 'is-invalid',
												focusInvalidField: true,
												lockForm: true,
								});
								// apply rules to form fields
								validation
												.addField('#name', [{
																				rule: 'required',
																				errorMessage: 'Name is required',
																},
																{
																				rule: 'customRegexp',
																				value: /^[a-zA-Z\s]*$/,
																				errorMessage: 'Name is invalid',
																},
												])
												.addField('#email', [
																{
																				rule: 'email',
																				errorMessage: 'Email is invalid!',
																},
												])
												.addField('#phone', [{
																rule: 'required',
																errorMessage: 'Phone is required',
												}, ])
												.onSuccess(async (event) => {
																var submitBtn = document.getElementById('submitBtn')
																submitBtn.innerHTML = spinner
																submitBtn.disabled = true;
																try {
																				var formData = new FormData();
																				formData.append('name', document.getElementById('name').value)
																				formData.append('email', document.getElementById('email').value)
																				formData.append('phone', document.getElementById('phone').value)
																				const response = await axios.post('{{ route("profile.post") }}', formData)
																				successToast(response.data.message)
																				setTimeout(() => {
																								location.reload()
																				}, 1000);
																} catch (error) {
																				if (error?.response?.data?.errors?.name) {
																								validation.showErrors({
																												'#name': error?.response?.data?.errors?.name[0]
																								})
																				}
																				if (error?.response?.data?.errors?.email) {
																								validation.showErrors({
																												'#email': error?.response?.data?.errors?.email[0]
																								})
																				}
																				if (error?.response?.data?.errors?.phone) {
																								validation.showErrors({
																												'#phone': error?.response?.data?.errors?.phone[0]
																								})
																				}
																				if (error?.response?.data?.message) {
																								errorToast(error?.response?.data?.message)
																				}
																} finally {
																				submitBtn.innerHTML = `
        Update
        `
																				submitBtn.disabled = false;
																}
												})
				</script>
@stop
