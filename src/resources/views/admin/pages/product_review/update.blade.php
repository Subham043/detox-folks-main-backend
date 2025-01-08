@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="product_review.paginate.get" :id="$product_id" page="Product Review"
																:list='["Update"]' />
												<!-- end page title -->

												<div class="row" id="image-container">
																<x-includes.back-button link="product_review.paginate.get" :id="$product_id" />
																<div class="col-lg-12">
																				<form id="countryForm" method="post"
																								action="{{ route("product_review.update.post", [$product_id, $data->id]) }}"
																								enctype="multipart/form-data">
																								@csrf
																								<div class="card">
																												<div class="card-header align-items-center d-flex">
																																<h4 class="card-title flex-grow-1 mb-0">Product Review Detail</h4>
																												</div><!-- end card header -->
																												<div class="card-body">
																																<div class="live-preview">
																																				<div class="row gy-4">
																																								<div class="col-xxl-12 col-md-12">
																																										<div>
                                                                                                                                                                                        <label for="rating" class="form-label">Rating</label>
                                                                                                                                                                                        <select class="form-control" name="rating" id="rating">
                                                                                                                                                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                                                                                                                                                                        <option value="{{ $i }}"
                                                                                                                                                                                                                                        {{ $i == $data->rating ? "selected" : "" }}>{{ $i }}
                                                                                                                                                                                                                                        star
                                                                                                                                                                                                                        </option>
                                                                                                                                                                                                        @endfor
                                                                                                                                                                                        </select>
                                                                                                                                                                                        @error("rating")
                                                                                                                                                                                                        <div class="invalid-message">{{ $message }}</div>
                                                                                                                                                                                        @enderror
                                                                                                                                                                        </div>
																																								</div>
																																								<div class="col-xxl-12 col-md-12">
																																												@include("admin.includes.textarea", [
																																																"key" => "comment",
																																																"label" => "Comment",
																																																"value" => $data->comment,
																																												])
																																								</div>
                                                                                                                                                                <div class="col-lg-12 col-md-12">
																																												<div class="mt-md-0 mt-4">
																																																<div>
																																																				<div class="form-check form-switch form-check-right mb-2">
																																																								<input class="form-check-input" type="checkbox" role="switch"
																																																												id="is_draft" name="is_draft"
																																																												{{ $data->is_draft == false ? "" : "checked" }}>
																																																								<label class="form-check-label" for="is_draft">Testimonial
																																																												Status</label>
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
												.addField('#rating', [{
																rule: 'required',
																errorMessage: 'Rating is required',
												}, ])
												.onSuccess(async (event) => {
																var submitBtn = document.getElementById('submitBtn')
																submitBtn.innerHTML = spinner
																submitBtn.disabled = true;
																try {
																				var formData = new FormData();
                                                                                formData.append('is_draft', document.getElementById('is_draft').checked ? 1 : 0)
																				formData.append('rating', document.getElementById('rating').value)
																				formData.append('comment', document.getElementById('comment').value)

																				const response = await axios.post(
																								'{{ route("product_review.update.post", [$product_id, $data->id]) }}', formData)
																				successToast(response.data.message)
																				setInterval(location.reload(), 1500);
																} catch (error) {
																				if (error?.response?.data?.errors?.rating) {
																								validation.showErrors({
																												'#rating': error?.response?.data?.errors?.rating[0]
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
