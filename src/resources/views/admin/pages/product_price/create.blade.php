@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="product_price.paginate.get" :id="$product_id" page="Product Price"
																:list='["Create"]' />
												<!-- end page title -->

												<div class="row">
																<x-includes.back-button link="product_price.paginate.get" :id="$product_id" />
																<div class="col-lg-12">
																				<form id="countryForm" method="post" action="{{ route("product_price.create.post", $product_id) }}"
																								enctype="multipart/form-data">
																								@csrf
																								<div class="card">
																												<div class="card-header align-items-center d-flex">
																																<h4 class="card-title flex-grow-1 mb-0">Product Price Detail</h4>
																												</div><!-- end card header -->
																												<div class="card-body">
																																<div class="live-preview">
																																				<div class="row gy-4">
																																								<div class="col-xxl-4 col-md-4">
																																												@include("admin.includes.input", [
																																																"key" => "min_quantity",
																																																"label" => "Minimum Quantity",
																																																"value" => old("min_quantity"),
																																												])
																																								</div>
																																								<div class="col-xxl-4 col-md-4">
																																												@include("admin.includes.input", [
																																																"key" => "price",
																																																"label" => "Price",
																																																"value" => old("price"),
																																												])
																																								</div>
																																								<div class="col-xxl-4 col-md-4">
																																												@include("admin.includes.input", [
																																																"key" => "discount",
																																																"label" => "Discount (%)",
																																																"value" => old("discount"),
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
												.addField('#min_quantity', [{
																rule: 'required',
																errorMessage: 'Minimum Quantity is required',
												}, ])
												.addField('#price', [{
																rule: 'required',
																errorMessage: 'Price is required',
												}, ])
												.addField('#discount', [{
																rule: 'required',
																errorMessage: 'Discount is required',
												}, ])
												.onSuccess(async (event) => {
																var submitBtn = document.getElementById('submitBtn')
																submitBtn.innerHTML = spinner
																submitBtn.disabled = true;
																try {
																				var formData = new FormData();
																				formData.append('min_quantity', document.getElementById('min_quantity').value)
																				formData.append('price', document.getElementById('price').value)
																				formData.append('discount', document.getElementById('discount').value)

																				const response = await axios.post('{{ route("product_price.create.post", $product_id) }}',
																								formData)
																				successToast(response.data.message)
																				event.target.reset();
																} catch (error) {
																				if (error?.response?.data?.errors?.min_quantity) {
																								validation.showErrors({
																												'#min_quantity': error?.response?.data?.errors?.min_quantity[0]
																								})
																				}
																				if (error?.response?.data?.errors?.price) {
																								validation.showErrors({
																												'#price': error?.response?.data?.errors?.price[0]
																								})
																				}
																				if (error?.response?.data?.errors?.discount) {
																								validation.showErrors({
																												'#discount': error?.response?.data?.errors?.discount[0]
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
