@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="promoter.report.paginate.get" page="Promoter Report Data" :list='["Update"]' />
												<!-- end page title -->

												<div class="row" id="image-container">
																<x-includes.back-button link="promoter.report.paginate.get" />
																<div class="col-lg-12">
																				<form id="countryForm" method="post" action="{{ route("promoter.report.update.post", $data->id) }}"
																								enctype="multipart/form-data">
																								@csrf
																								<div class="card">
																												<div class="card-header align-items-center d-flex">
																																<h4 class="card-title flex-grow-1 mb-0">Promoter Report Information</h4>
																												</div><!-- end card header -->
																												<div class="card-body">
																																<div class="live-preview">
																																				<div class="row gy-4">
																																								<div class="col-xxl-6 col-md-6">
																																												@include("admin.includes.input", [
																																																"key" => "name",
																																																"label" => "Name",
																																																"value" => $data->name,
																																												])
																																								</div>
																																								<div class="col-xxl-6 col-md-6">
																																												@include("admin.includes.input", [
																																																"key" => "phone",
																																																"label" => "Phone",
																																																"value" => $data->phone,
																																												])
																																								</div>
																																								<div class="col-xxl-6 col-md-6">
																																												@include("admin.includes.textarea", [
																																																"key" => "location",
																																																"label" => "Location",
																																																"value" => $data->location,
																																												])
																																								</div>
																																								<div class="col-xxl-6 col-md-6">
																																												@include("admin.includes.textarea", [
																																																"key" => "remarks",
																																																"label" => "Remarks",
																																																"value" => $data->remarks,
																																												])
																																								</div>
																																								<div class="col-lg-12 col-md-12">
																																												<div class="mt-md-0 mt-4">
																																																<div>
																																																				<div class="form-check form-switch form-check-right mb-2">
																																																								<input class="form-check-input" type="checkbox" role="switch"
																																																												id="is_app_installed" name="is_app_installed"
																																																												{{ $data->is_app_installed == false ? "" : "checked" }}>
																																																								<label class="form-check-label" for="is_app_installed">Is App Installed?</label>
																																																				</div>
																																																</div>

																																												</div>
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
												])
												.addField('#phone', [{
																				rule: 'required',
																				errorMessage: 'Phone is required',
																},
												])
												.addField('#location', [{
																validator: (value, fields) => true,
												}, ])
                                                .addField('#remarks', [{
																validator: (value, fields) => true,
												}, ])
												.onSuccess(async (event) => {
																var submitBtn = document.getElementById('submitBtn')
																submitBtn.innerHTML = spinner
																submitBtn.disabled = true;
																try {
																				var formData = new FormData();
																				formData.append('is_app_installed', document.getElementById('is_app_installed').checked ? 1 : 0)
																				formData.append('name', document.getElementById('name').value)
																				formData.append('phone', document.getElementById('phone').value)
                                                                                formData.append('location', document.getElementById('location').value)
                                                                                formData.append('remarks', document.getElementById('remarks').value)
																				const response = await axios.post('{{ route("promoter.report.update.post", $data->id) }}', formData)
																				successToast(response.data.message)
																} catch (error) {
																				if (error?.response?.data?.errors?.name) {
																								validation.showErrors({
																												'#name': error?.response?.data?.errors?.name[0]
																								})
																				}
																				if (error?.response?.data?.errors?.phone) {
																								validation.showErrors({
																												'#phone': error?.response?.data?.errors?.phone[0]
																								})
																				}
																				if (error?.response?.data?.errors?.location) {
																								validation.showErrors({
																												'#location': error?.response?.data?.errors?.location[0]
																								})
																				}
																				if (error?.response?.data?.errors?.remarks) {
																								validation.showErrors({
																												'#remarks': error?.response?.data?.errors?.remarks[0]
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
