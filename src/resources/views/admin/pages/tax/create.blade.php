@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="tax.paginate.get" page="Taxes" :list='["Create"]' />
												<!-- end page title -->

												<div class="row">
																<x-includes.back-button link="tax.paginate.get" />
																<div class="col-lg-12">
																				<form id="countryForm" method="post" action="{{ route("tax.create.post") }}"
																								enctype="multipart/form-data">
																								@csrf
																								<div class="card">
																												<div class="card-header align-items-center d-flex">
																																<h4 class="card-title flex-grow-1 mb-0">Tax Information</h4>
																												</div><!-- end card header -->
																												<div class="card-body">
																																<div class="live-preview">
																																				<div class="row gy-4">
																																								<div class="col-xxl-4 col-md-4">
																																												@include("admin.includes.input", [
																																																"key" => "tax_name",
																																																"label" => "Tax Name",
																																																"value" => old("tax_name"),
																																												])
																																								</div>
																																								<div class="col-xxl-4 col-md-4">
																																												@include("admin.includes.input", [
																																																"key" => "tax_slug",
																																																"label" => "Tax Slug",
																																																"value" => old("tax_slug"),
																																												])
																																								</div>
                                                                                                                                                                <div class="col-xxl-4 col-md-4">
																																												@include("admin.includes.input", [
																																																"key" => "tax_value",
																																																"label" => "Tax Value (%)",
																																																"value" => old("tax_value"),
																																												])
																																								</div>
																																								<div class="col-lg-12 col-md-12">
																																												<div class="mt-md-0 mt-4">
																																																<div>
																																																				<div class="form-check form-switch form-check-right mb-2">
																																																								<input class="form-check-input" type="checkbox" role="switch"
																																																												id="is_active" name="is_active" checked>
																																																								<label class="form-check-label" for="is_active">Tax
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
												.addField('#tax_name', [{
																				rule: 'required',
																				errorMessage: 'Tax Name is required',
																},
																{
																				rule: 'customRegexp',
																				value: COMMON_REGEX,
																				errorMessage: 'Tax Name is invalid',
																},
												])
												.addField('#tax_slug', [{
																				rule: 'required',
																				errorMessage: 'Taxs Slug is required',
																},
																{
																				rule: 'customRegexp',
																				value: COMMON_REGEX,
																				errorMessage: 'Taxs Slug is invalid',
																},
												])
												.addField('#tax_value', [{
																rule: 'required',
																errorMessage: 'Tax Value is required',
												}, ])
												.onSuccess(async (event) => {
																var submitBtn = document.getElementById('submitBtn')
																submitBtn.innerHTML = spinner
																submitBtn.disabled = true;
																try {
																				var formData = new FormData();
																				formData.append('is_active', document.getElementById('is_active').checked ? 1 : 0)
																				formData.append('tax_name', document.getElementById('tax_name').value)
																				formData.append('tax_slug', document.getElementById('tax_slug').value)
                                                                                formData.append('tax_value', document.getElementById('tax_value').value)
																				const response = await axios.post('{{ route("tax.create.post") }}', formData)
																				successToast(response.data.message)
																				event.target.reset();
																} catch (error) {
																				if (error?.response?.data?.errors?.tax_name) {
																								validation.showErrors({
																												'#tax_name': error?.response?.data?.errors?.tax_name[0]
																								})
																				}
																				if (error?.response?.data?.errors?.tax_slug) {
																								validation.showErrors({
																												'#tax_slug': error?.response?.data?.errors?.tax_slug[0]
																								})
																				}
																				if (error?.response?.data?.errors?.tax_value) {
																								validation.showErrors({
																												'#tax_value': error?.response?.data?.errors?.tax_value[0]
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
