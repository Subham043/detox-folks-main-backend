@extends("admin.layouts.dashboard")

@section("css")

                <style nonce="{{ csp_nonce() }}">
                                .color_input{
                                    height: 40px;
                                }
                </style>
@stop

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="product_color.paginate.get" :id="$product_id" page="Product Color"
																:list='["Update"]' />
												<!-- end page title -->

												<div class="row" id="image-container">
																<x-includes.back-button link="product_color.paginate.get" :id="$product_id" />
																<div class="col-lg-12">
																				<form id="countryForm" method="post"
																								action="{{ route("product_color.update.post", [$product_id, $data->id]) }}"
																								enctype="multipart/form-data">
																								@csrf
																								<div class="card">
																												<div class="card-header align-items-center d-flex">
																																<h4 class="card-title flex-grow-1 mb-0">Product Color Detail</h4>
																												</div><!-- end card header -->
																												<div class="card-body">
																																<div class="live-preview">
																																				<div class="row gy-4">
																																								<div class="col-xxl-6 col-md-12">
																																												@include("admin.includes.input", [
																																																"key" => "name",
																																																"label" => "Name",
																																																"value" => $data->name,
																																												])
																																								</div>
																																								<div class="col-xxl-6 col-md-12">
																																												@include("admin.includes.color_input", [
																																																"key" => "code",
																																																"label" => "Code",
																																																"value" => $data->code,
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
												.addField('#code', [{
																				rule: 'required',
																				errorMessage: 'Code is required',
																},
												])
												.onSuccess(async (event) => {
																var submitBtn = document.getElementById('submitBtn')
																submitBtn.innerHTML = spinner
																submitBtn.disabled = true;
																try {
																				var formData = new FormData();
																				formData.append('name', document.getElementById('name').value)
																				formData.append('code', document.getElementById('code').value)

																				const response = await axios.post(
																								'{{ route("product_color.update.post", [$product_id, $data->id]) }}', formData)
																				successToast(response.data.message)
																				setInterval(location.reload(), 1500);
																} catch (error) {
																				if (error?.response?.data?.errors?.name) {
																								validation.showErrors({
																												'#name': error?.response?.data?.errors?.name[0]
																								})
																				}
																				if (error?.response?.data?.errors?.code) {
																								validation.showErrors({
																												'#code': error?.response?.data?.errors?.code[0]
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
