@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="testimonial.paginate.get" page="Testimonial" :list='["Create"]' />
												<!-- end page title -->

												<div class="row">
																<x-includes.back-button link="testimonial.paginate.get" />
																<div class="col-lg-12">
																				<form id="countryForm" method="post" action="{{ route("testimonial.create.post") }}"
																								enctype="multipart/form-data">
																								@csrf
																								<div class="card">
																												<div class="card-header align-items-center d-flex">
																																<h4 class="card-title flex-grow-1 mb-0">Testimonial Detail</h4>
																												</div><!-- end card header -->
																												<div class="card-body">
																																<div class="live-preview">
																																				<div class="row gy-4">
																																								<div class="col-xxl-3 col-md-3">
																																												@include("admin.includes.input", [
																																																"key" => "name",
																																																"label" => "Name",
																																																"value" => old("name"),
																																												])
																																								</div>
																																								<div class="col-xxl-3 col-md-3">
																																												@include("admin.includes.input", [
																																																"key" => "designation",
																																																"label" => "Designation",
																																																"value" => old("designation"),
																																												])
																																								</div>
																																								<div class="col-xxl-3 col-md-3">
																																												<div>
																																																<label for="star" class="form-label">Stars</label>
																																																<select class="form-control" name="star" id="star">
																																																				@for ($i = 1; $i <= 5; $i++)
																																																								<option value="{{ $i }}">{{ $i }} star
																																																								</option>
																																																				@endfor
																																																</select>
																																																@error("star")
																																																				<div class="invalid-message">{{ $message }}</div>
																																																@enderror
																																												</div>
																																								</div>
																																								<div class="col-xxl-3 col-md-3">
																																												@include("admin.includes.file_input", [
																																																"key" => "image",
																																																"label" => "Image",
																																												])
																																								</div>
																																								<div class="col-xxl-12 col-md-12">
																																												@include("admin.includes.textarea", [
																																																"key" => "message",
																																																"label" => "Message",
																																																"value" => old("message"),
																																												])
																																								</div>
																																								<div class="col-lg-12 col-md-12">
																																												<div class="mt-md-0 mt-4">
																																																<div>
																																																				<div class="form-check form-switch form-check-right mb-2">
																																																								<input class="form-check-input" type="checkbox" role="switch"
																																																												id="is_draft" name="is_draft" checked>
																																																								<label class="form-check-label" for="is_draft">Testimonial
																																																												Status</label>
																																																				</div>
																																																</div>

																																												</div>
																																								</div>
																																								<div class="col-xxl-12 col-md-12">
																																												<button type="submit" class="btn btn-primary waves-effect waves-light"
																																																id="submitBtn">Create</button>
																																								</div>

																																				</div>
																																				<!--end row-->
																																</div>

																												</div>
																								</div>

																				</form>
																</div>
																<!--end col-->
												</div>
												<!--end row-->

								</div> <!-- container-fluid -->
				</div><!-- End Page-content -->

@stop

@section("javascript")

				<script type="text/javascript" nonce="{{ csp_nonce() }}">
								// initialize the validation library
								const validation = new JustValidate('#countryForm', {
												errorFieldCssClass: 'is-invalid',
								});
								// apply rules to form fields
								validation
												.addField('#name', [{
																				rule: 'required',
																				errorMessage: 'Name is required',
																},
																{
																				rule: 'customRegexp',
																				value: COMMON_REGEX,
																				errorMessage: 'Name is invalid',
																},
												])
												.addField('#designation', [{
																				rule: 'required',
																				errorMessage: 'Designation is required',
																},
																{
																				rule: 'customRegexp',
																				value: COMMON_REGEX,
																				errorMessage: 'Designation is invalid',
																},
												])
												.addField('#star', [{
																rule: 'required',
																errorMessage: 'Star is required',
												}, ])
												.addField('#message', [{
																rule: 'required',
																errorMessage: 'Message is required',
												}, ])
												.addField('#image', [{
																				rule: 'required',
																				errorMessage: 'Image is required',
																},
																{
																				rule: 'minFilesCount',
																				value: 1,
																},
																{
																				rule: 'maxFilesCount',
																				value: 1,
																},
																{
																				rule: 'files',
																				value: {
																								files: {
																												extensions: ['jpeg', 'jpg', 'png', 'webp'],
																												maxSize: 500000,
																												minSize: 1,
																												types: ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'],
																								},
																				},
																},
												])
												.onSuccess(async (event) => {
																var submitBtn = document.getElementById('submitBtn')
																submitBtn.innerHTML = spinner
																submitBtn.disabled = true;
																try {
																				var formData = new FormData();
																				formData.append('is_draft', document.getElementById('is_draft').checked ? 1 : 0)
																				formData.append('name', document.getElementById('name').value)
																				formData.append('designation', document.getElementById('designation').value)
																				formData.append('message', document.getElementById('message').value)
																				formData.append('star', document.getElementById('star').value)
																				if ((document.getElementById('image').files).length > 0) {
																								formData.append('image', document.getElementById('image').files[0])
																				}
																				const response = await axios.post('{{ route("testimonial.create.post") }}', formData)
																				successToast(response.data.message)
																				event.target.reset();
																} catch (error) {
																				if (error?.response?.data?.errors?.name) {
																								validation.showErrors({
																												'#name': error?.response?.data?.errors?.name[0]
																								})
																				}
																				if (error?.response?.data?.errors?.designation) {
																								validation.showErrors({
																												'#designation': error?.response?.data?.errors?.designation[0]
																								})
																				}
																				if (error?.response?.data?.errors?.message) {
																								validation.showErrors({
																												'#message': error?.response?.data?.errors?.message[0]
																								})
																				}
																				if (error?.response?.data?.errors?.star) {
																								validation.showErrors({
																												'#star': error?.response?.data?.errors?.star[0]
																								})
																				}
																				if (error?.response?.data?.errors?.image) {
																								validation.showErrors({
																												'#image': error?.response?.data?.errors?.image[0]
																								})
																				}
																				if (error?.response?.data?.message) {
																								errorToast(error?.response?.data?.message)
																				}
																} finally {
																				submitBtn.innerHTML = `
            Create
            `
																				submitBtn.disabled = false;
																}
												});
				</script>
@stop
