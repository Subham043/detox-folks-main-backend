@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="delivery_slot.paginate.get" page="Delivery Slot" :list='["Create"]' />
												<!-- end page title -->

												<div class="row">
																<x-includes.back-button link="delivery_slot.paginate.get" />
																<div class="col-lg-12">
																				<form id="countryForm" method="post" action="{{ route("delivery_slot.create.post") }}"
																								enctype="multipart/form-data">
																								@csrf
																								<div class="card">
																												<div class="card-header align-items-center d-flex">
																																<h4 class="card-title flex-grow-1 mb-0">Delivery Slot Detail</h4>
																												</div><!-- end card header -->
																												<div class="card-body">
																																<div class="live-preview">
																																				<div class="row gy-4">
																																								<div class="col-xxl-12 col-md-12">
																																												@include("admin.includes.input", [
																																																"key" => "name",
																																																"label" => "Name",
																																																"value" => old("name"),
																																												])
																																								</div>
																																								<div class="col-lg-3 col-md-3">
																																												<div class="mt-md-0 mt-4">
																																																<div>
																																																				<div class="form-check form-switch form-check-right mb-2">
																																																								<input class="form-check-input" type="checkbox" role="switch"
																																																												id="is_cod_allowed" name="is_cod_allowed" checked>
																																																								<label class="form-check-label" for="is_cod_allowed">Is COD Allowed</label>
																																																				</div>
																																																</div>

																																												</div>
																																								</div>
																																								<div class="col-lg-3 col-md-3">
																																												<div class="mt-md-0 mt-4">
																																																<div>
																																																				<div class="form-check form-switch form-check-right mb-2">
																																																								<input class="form-check-input" type="checkbox" role="switch"
																																																												id="is_draft" name="is_draft" checked>
																																																								<label class="form-check-label" for="is_draft">Delivery Slot
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
												.onSuccess(async (event) => {
																var submitBtn = document.getElementById('submitBtn')
																submitBtn.innerHTML = spinner
																submitBtn.disabled = true;
																try {
																				var formData = new FormData();
																				formData.append('is_draft', document.getElementById('is_draft').checked ? 1 : 0)
																				formData.append('is_cod_allowed', document.getElementById('is_cod_allowed').checked ? 1 : 0)
																				formData.append('name', document.getElementById('name').value)
																				const response = await axios.post('{{ route("delivery_slot.create.post") }}', formData)
																				successToast(response.data.message)
																				event.target.reset();
																} catch (error) {
																				if (error?.response?.data?.errors?.name) {
																								validation.showErrors({
																												'#name': error?.response?.data?.errors?.name[0]
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
