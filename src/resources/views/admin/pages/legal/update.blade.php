@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="legal.paginate.get" page="Legal Pages" :list='["Update"]' />
												<!-- end page title -->

												<div class="row">
																<x-includes.back-button link="legal.paginate.get" />
																<div class="col-lg-12">
																				<form id="countryForm" method="post" action="{{ route("legal.update.post", $data->slug) }}"
																								enctype="multipart/form-data">
																								@csrf
																								<div class="card">
																												<div class="card-header align-items-center d-flex">
																																<h4 class="card-title flex-grow-1 mb-0">Legal Pages Detail</h4>
																												</div><!-- end card header -->
																												<div class="card-body">
																																<div class="live-preview">
																																				<div class="row gy-4">
																																								<div class="col-xxl-4 col-md-4">
																																												@include("admin.includes.input", [
																																																"key" => "heading",
																																																"label" => "Heading",
																																																"value" => $data->heading,
																																												])
																																								</div>
																																								<div class="col-xxl-4 col-md-4">
																																												@include("admin.includes.input", [
																																																"key" => "page_name",
																																																"label" => "Page Name",
																																																"value" => $data->page_name,
																																												])
																																								</div>
																																								<div class="col-xxl-4 col-md-4">
																																												<div>
																																																<label for="slug" class="form-label">Page Slug</label>
																																																<input type="text" class="form-control" disabled readonly
																																																				value="{{ $data->slug }}">
																																												</div>
																																								</div>
																																								<div class="col-xxl-12 col-md-12">
																																												<x-includes.quill key="description" label="Description" :value='$data->description' />
																																								</div>
																																								<div class="col-lg-12 col-md-12">
																																												<div class="mt-md-0 mt-4">
																																																<div>
																																																				<div class="form-check form-switch form-check-right mb-2">
																																																								<input class="form-check-input" type="checkbox" role="switch"
																																																												id="is_draft" name="is_draft"
																																																												{{ $data->is_draft == false ? "" : "checked" }}>
																																																								<label class="form-check-label" for="is_draft">Legal Page
																																																												Status</label>
																																																				</div>
																																																</div>

																																												</div>
																																								</div>

																																				</div>
																																				<!--end row-->
																																</div>

																												</div>
																								</div>

																								<div class="card">
																												<div class="card-header align-items-center d-flex">
																																<h4 class="card-title flex-grow-1 mb-0">Legal Pages Seo Detail</h4>
																												</div><!-- end card header -->
																												<div class="card-body">
																																<div class="live-preview">
																																				<div class="row gy-4">
																																								<div class="col-xxl-4 col-md-4">
																																												@include("admin.includes.textarea", [
																																																"key" => "meta_title",
																																																"label" => "Meta Title",
																																																"value" => $data->meta_title,
																																												])
																																								</div>
																																								<div class="col-xxl-4 col-md-4">
																																												@include("admin.includes.textarea", [
																																																"key" => "meta_keywords",
																																																"label" => "Meta Keywords",
																																																"value" => $data->meta_keywords,
																																												])
																																								</div>
																																								<div class="col-xxl-4 col-md-4">
																																												@include("admin.includes.textarea", [
																																																"key" => "meta_description",
																																																"label" => "Meta Description",
																																																"value" => $data->meta_description,
																																												])
																																								</div>
																																								<div class="col-xxl-12 col-md-12">
																																												<button type="submit" class="btn btn-primary waves-effect waves-light"
																																																id="submitBtn">Update</button>
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
				<script src="{{ asset("admin/js/pages/plugins/quill.min.js") }}"></script>

				<script type="text/javascript" nonce="{{ csp_nonce() }}">
								var quillDescription = new Quill('#description_quill', {
												theme: 'snow',
												modules: {
																toolbar: QUILL_TOOLBAR_OPTIONS
												},
								});

								quillDescription.on('text-change', function(delta, oldDelta, source) {
												if (source == 'user') {
																document.getElementById('description').value = quillDescription.root.innerHTML
												}
								});

								// initialize the validation library
								const validation = new JustValidate('#countryForm', {
												errorFieldCssClass: 'is-invalid',
								});
								// apply rules to form fields
								validation
												.addField('#heading', [{
																				rule: 'required',
																				errorMessage: 'Heading is required',
																},
																{
																				rule: 'customRegexp',
																				value: COMMON_REGEX,
																				errorMessage: 'Heading is invalid',
																},
												])
												.addField('#page_name', [{
																				rule: 'required',
																				errorMessage: 'Page Name is required',
																},
																{
																				rule: 'customRegexp',
																				value: COMMON_REGEX,
																				errorMessage: 'Page Name is invalid',
																},
												])
												.addField('#description', [{
																rule: 'required',
																errorMessage: 'Description is required',
												}, ])
												.addField('#meta_title', [{
																validator: (value, fields) => true,
												}, ])
												.addField('#meta_keywords', [{
																validator: (value, fields) => true,
												}, ])
												.addField('#meta_description', [{
																validator: (value, fields) => true,
												}, ])
												.onSuccess(async (event) => {
																var submitBtn = document.getElementById('submitBtn')
																submitBtn.innerHTML = spinner
																submitBtn.disabled = true;
																try {
																				var formData = new FormData();
																				formData.append('is_draft', document.getElementById('is_draft').checked ? 1 : 0)
																				formData.append('heading', document.getElementById('heading').value)
																				formData.append('page_name', document.getElementById('page_name').value)
																				formData.append('description', quillDescription.root.innerHTML)
																				formData.append('description_unfiltered', quillDescription.getText())
																				formData.append('meta_title', document.getElementById('meta_title').value)
																				formData.append('meta_keywords', document.getElementById('meta_keywords').value)
																				formData.append('meta_description', document.getElementById('meta_description').value)

																				const response = await axios.post('{{ route("legal.update.post", $data->slug) }}', formData)
																				successToast(response.data.message)
																				setInterval(location.reload(), 1500);
																} catch (error) {
																				if (error?.response?.data?.errors?.heading) {
																								validation.showErrors({
																												'#heading': error?.response?.data?.errors?.heading[0]
																								})
																				}
																				if (error?.response?.data?.errors?.page_name) {
																								validation.showErrors({
																												'#page_name': error?.response?.data?.errors?.page_name[0]
																								})
																				}
																				if (error?.response?.data?.errors?.description) {
																								validation.showErrors({
																												'#description': error?.response?.data?.errors?.description[0]
																								})
																				}
																				if (error?.response?.data?.errors?.meta_title) {
																								validation.showErrors({
																												'#meta_title': error?.response?.data?.errors?.meta_title[0]
																								})
																				}
																				if (error?.response?.data?.errors?.meta_keywords) {
																								validation.showErrors({
																												'#meta_keywords': error?.response?.data?.errors?.meta_keywords[0]
																								})
																				}
																				if (error?.response?.data?.errors?.meta_description) {
																								validation.showErrors({
																												'#meta_description': error?.response?.data?.errors?.meta_description[0]
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
												});
				</script>
@stop
