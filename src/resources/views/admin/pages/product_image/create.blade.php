@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="product_image.paginate.get" :id="$product_id" page="Product Image"
																:list='["Create"]' />
												<!-- end page title -->

												<div class="row">
																<x-includes.back-button link="product_image.paginate.get" :id="$product_id" />
																<div class="col-lg-12">
																				<form id="countryForm" method="post" action="{{ route("product_image.create.post", $product_id) }}"
																								enctype="multipart/form-data">
																								@csrf
																								<div class="card">
																												<div class="card-header align-items-center d-flex">
																																<h4 class="card-title flex-grow-1 mb-0">Product Image Detail</h4>
																												</div><!-- end card header -->
																												<div class="card-body">
																																<div class="live-preview">
																																				<div class="row gy-4">
																																								<div class="col-xxl-4 col-md-4">
																																												@include("admin.includes.file_input", [
																																																"key" => "image",
																																																"label" => "Image",
																																												])
																																								</div>
																																								<div class="col-xxl-4 col-md-4">
																																												@include("admin.includes.input", [
																																																"key" => "image_title",
																																																"label" => "Image Title",
																																																"value" => old("image_title"),
																																												])
																																								</div>
																																								<div class="col-xxl-4 col-md-4">
																																												@include("admin.includes.input", [
																																																"key" => "image_alt",
																																																"label" => "Image Alt",
																																																"value" => old("image_alt"),
																																												])
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
												.addField('#image', [{
																				rule: 'minFilesCount',
																				value: 0,
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
												.addField('#image_title', [{
																rule: 'required',
																errorMessage: 'Image Title is required',
												}, ])
												.addField('#image_alt', [{
																rule: 'required',
																errorMessage: 'Image Alt is required',
												}, ])
												.onSuccess(async (event) => {
																var submitBtn = document.getElementById('submitBtn')
																submitBtn.innerHTML = spinner
																submitBtn.disabled = true;
																try {
																				var formData = new FormData();
																				formData.append('image_title', document.getElementById('image_title').value)
																				formData.append('image_alt', document.getElementById('image_alt').value)
																				if ((document.getElementById('image').files).length > 0) {
																								formData.append('image', document.getElementById('image').files[0])
																				}
																				const response = await axios.post('{{ route("product_image.create.post", $product_id) }}',
																								formData)
																				successToast(response.data.message)
																				event.target.reset();
																} catch (error) {
																				if (error?.response?.data?.errors?.image) {
																								validation.showErrors({
																												'#image': error?.response?.data?.errors?.image[0]
																								})
																				}
																				if (error?.response?.data?.errors?.image_title) {
																								validation.showErrors({
																												'#image_title': error?.response?.data?.errors?.image_title[0]
																								})
																				}
																				if (error?.response?.data?.errors?.image_alt) {
																								validation.showErrors({
																												'#image_alt': error?.response?.data?.errors?.image_alt[0]
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
