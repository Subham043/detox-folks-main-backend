@extends("admin.layouts.dashboard")

@section("css")

                <style nonce="{{ csp_nonce() }}">
                                .color_input{
                                    width: 20px;
                                    height: 20px;
                                }
                </style>
@stop

@section("content")

				<div class="modal" id="deliverModal" tabindex="-1">
								<div class="modal-dialog">
												<div class="modal-content">
																<div class="modal-header">
																				<h5 class="modal-title">To Complete Delivery Please Enter OTP</h5>
																				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
																</div>
																<form action="javascript:void(0);" id="otpForm">
																				<div class="modal-body">
																								@include("admin.includes.input", [
																												"key" => "otp",
																												"label" => "OTP",
																												"value" => old("otp"),
																								])
																								<p><code>Note: </code>The otp will be sent to customer mobile no - {{ $order->phone }}.</p>
																				</div>
																				<div class="modal-footer">
																								<button type="button" class="btn btn-secondary" id="send_otp">Send OTP</button>
																								<button type="submit" class="btn btn-primary" id="completeBtn">Complete</button>
																				</div>
																</form>
												</div>
								</div>
				</div>

				<div class="page-content">
								<div class="container-fluid">

												<x-includes.breadcrumb link="delivery_management.agent.order.get" page="Order" :list='["Detail"]' />

												<div class="row project-wrapper">
																<div class="row justify-content-between mb-3">
																				<div class="col-sm-auto">
																								<div>
																												<a href="{{ route("delivery_management.agent.order.get") }}" type="button"
																																class="btn btn-dark add-btn" id="create-btn"><i
																																				class="ri-arrow-go-back-line me-1 align-bottom"></i> Go Back</a>
																								</div>
																				</div>
																				@if (!in_array(\App\Enums\OrderEnumStatus::CANCELLED, $order_statuses))
																								@if ($order->current_status->status == \App\Enums\OrderEnumStatus::OFD)
																												<div class="col-sm-auto px-0">
																																<div>
                                                                                                                                                @if ($order->payment && $order->payment->status != \App\Enums\PaymentStatus::PAID)
																																				<a type="button" href="{{route("delivery_management.agent.order_generate_qr_code.get", $order->id)}}" class="btn btn-warning"><i
																																												class="ri-map-pin-user-line me-1 align-bottom"></i> Generate Payment QR Code</a>
                                                                                                                                                @endif
																																				<button type="button" class="btn btn-secondary add-btn" data-bs-toggle="modal"
																																								data-bs-target="#deliverModal" id="create-btn"><i
																																												class="ri-map-pin-user-line me-1 align-bottom"></i> Delivery Completed</button>
																																</div>
																												</div>
																								@endif
																				@endif
																</div>
																<div class="col-xxl-12">

																				<div class="row">
																								<div class="col-xl-12">
																												<div class="card">
																																<div class="card-header">
																																				<div class="d-flex align-items-center">
																																								<h5 class="card-title flex-grow-1 mb-0">Order #{{ $order->id }}</h5>
																																				</div>
																																</div>
																																<div class="card-body">
																																				<div class="table-responsive table-card">
																																								<table class="table-nowrap table-borderless mb-0 table align-middle">
																																												<thead class="table-light text-muted">
																																																<tr>
																																																				<th scope="col">Product Details</th>
																																																				<th scope="col">Item Price</th>
																																																				<th scope="col">Quantity</th>
																																																				<th scope="col" class="text-end">Total Amount</th>
																																																</tr>
																																												</thead>
																																												<tbody>
																																																@foreach ($order->products as $k => $v)
																																																				<tr>
																																																								<td>
																																																												<div class="d-flex align-items-center flex-wrap">
																																																																<div class="avatar-md bg-light flex-shrink-0 rounded p-1">
																																																																				<img src="{{ $v->image_link }}" alt=""
																																																																								class="img-fluid d-block">
																																																																</div>
																																																																<div class="flex-grow-1 ms-3">
																																																																				<h5 class="fs-16"><a href="#"
																																																																												class="link-primary">{{ $v->name }}</a>
																																																																				</h5>
																																																																				<p class="text-muted mb-0"><span
																																																																												class="fw-medium">{{ $v->short_description }}</span>
																																																																				</p>
                                                                                                                                                                                                                                                                                @if($v->color)
																																																																				<p class="text-dark mb-0"><span
																																																																												class="fw-medium d-inline-flex w-auto gap-1 align-items-center">Selected Color: <span class="d-inline-flex w-auto gap-1 align-items-center"><input type="color" value="{{ $v->color }}" class="color_input" disabled /><span class="text-muted">{{ $v->color }}</span></span></span>
																																																																				</p>
                                                                                                                                                                                                                                                                                @endif
																																																																</div>
																																																												</div>
																																																								</td>
																																																								<td>&#8377; {{ $v->discount_in_price }}/{{ $v->unit }}</td>
																																																								<td>{{ $v->quantity }}</td>
																																																								<td class="fw-medium text-end">
																																																												&#8377; {{ $v->amount }}
																																																								</td>
																																																				</tr>
																																																@endforeach

																																																<tr class="border-top border-top-dashed">
																																																				<th>
																																																								Sub-Total :
																																																				</th>
																																																				<td></td>
																																																				<th class="text-end" colspan="4">&#8377; {{ $order->subtotal }}</th>
																																																</tr>
																																																@foreach ($order->charges as $k => $v)
																																																				<tr class="border-top border-top-dashed">
																																																								<th>
																																																												{{ $v->charges_name }} :
																																																								</th>
																																																								<td></td>
																																																								<th class="text-end" colspan="4">&#8377;
																																																												{{ $v->total_charge_in_amount }}</th>
																																																				</tr>
																																																@endforeach
																																																<tr class="border-top border-top-dashed">
																																																				<th>
																																																								Total :
																																																				</th>
																																																				<td></td>
																																																				<th class="text-end" colspan="4">&#8377; {{ $order->total_price }}
																																																				</th>
																																																</tr>
																																												</tbody>
																																								</table>
																																				</div>
																																</div>
																												</div>
																												<!--end card-->
																												<div class="card">
																																<div class="card-header">
																																				<div class="d-sm-flex align-items-center">
																																								<h5 class="card-title flex-grow-1 mb-0">Order Status</h5>
																																				</div>
																																</div>
																																<div class="card-body">
																																				<div class="profile-timeline">
																																								<div class="accordion accordion-flush" id="accordionFlushExample">
																																												<div class="accordion-item border-0">
																																																<div class="accordion-header" id="headingOne">
																																																				<a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse"
																																																								href="#collapseOne" aria-expanded="true"
																																																								aria-controls="collapseOne">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-xs flex-shrink-0">
																																																																<div @class([
																																																																				"avatar-title rounded-circle",
																																																																				"bg-success" => in_array(
																																																																								\App\Enums\OrderEnumStatus::PLACED,
																																																																								$order_statuses),
																																																																				"bg-light text-success" => !in_array(
																																																																								\App\Enums\OrderEnumStatus::PLACED,
																																																																								$order_statuses),
																																																																])>
																																																																				<i class="ri-shopping-bag-line"></i>
																																																																</div>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<h6 class="fs-15 fw-semibold mb-0">ORDER PLACED @if (in_array(\App\Enums\OrderEnumStatus::PLACED, $order_statuses))-
																																																																								@foreach ($order->statuses as $v)
																																																																												@if (\App\Enums\OrderEnumStatus::PLACED == $v->status)
																																																																																<span
																																																																																				class="fw-normal">{{ $v->created_at->diffForHumans() }}</span>
																																																																												@endif
																																																																								@endforeach
																																																																				@endif
																																																																</h6>
																																																												</div>
																																																								</div>
																																																				</a>
																																																</div>
																																												</div>
																																												@if (!in_array(\App\Enums\OrderEnumStatus::CANCELLED, $order_statuses))
																																																<div class="accordion-item border-0">
																																																				<div class="accordion-header" id="headingTwo">
																																																								<a class="accordion-button p-2 shadow-none"
																																																												data-bs-toggle="collapse" href="#collapseTwo"
																																																												aria-expanded="false" aria-controls="collapseTwo">
																																																												<div class="d-flex align-items-center">
																																																																<div class="avatar-xs flex-shrink-0">
																																																																				<div @class([
																																																																								"avatar-title rounded-circle",
																																																																								"bg-success" => in_array(
																																																																												\App\Enums\OrderEnumStatus::CONFIRMED,
																																																																												$order_statuses),
																																																																								"bg-light text-success" => !in_array(
																																																																												\App\Enums\OrderEnumStatus::CONFIRMED,
																																																																												$order_statuses),
																																																																				])>
																																																																								<i class="ri-checkbox-multiple-line"></i>
																																																																				</div>
																																																																</div>
																																																																<div class="flex-grow-1 ms-3">
																																																																				<h6 class="fs-15 fw-semibold mb-1">CONFIRMED
																																																																								@if (in_array(\App\Enums\OrderEnumStatus::CONFIRMED, $order_statuses))-
																																																																												@foreach ($order->statuses as $v)
																																																																																@if (\App\Enums\OrderEnumStatus::CONFIRMED == $v->status)
																																																																																				<span
																																																																																								class="fw-normal">{{ $v->created_at->diffForHumans() }}</span>
																																																																																@endif
																																																																												@endforeach
																																																																								@endif
																																																																				</h6>
																																																																</div>
																																																												</div>
																																																								</a>
																																																				</div>
																																																</div>
																																																<div class="accordion-item border-0">
																																																				<div class="accordion-header" id="headingTwo">
																																																								<a class="accordion-button p-2 shadow-none"
																																																												data-bs-toggle="collapse" href="#collapseTwo"
																																																												aria-expanded="false" aria-controls="collapseTwo">
																																																												<div class="d-flex align-items-center">
																																																																<div class="avatar-xs flex-shrink-0">
																																																																				<div @class([
																																																																								"avatar-title rounded-circle",
																																																																								"bg-success" => in_array(
																																																																												\App\Enums\OrderEnumStatus::PACKED,
																																																																												$order_statuses),
																																																																								"bg-light text-success" => !in_array(
																																																																												\App\Enums\OrderEnumStatus::PACKED,
																																																																												$order_statuses),
																																																																				])>
																																																																								<i class="mdi mdi-gift-outline"></i>
																																																																				</div>
																																																																</div>
																																																																<div class="flex-grow-1 ms-3">
																																																																				<h6 class="fs-15 fw-semibold mb-1">ORDER PACKED
																																																																								@if (in_array(\App\Enums\OrderEnumStatus::PACKED, $order_statuses))-
																																																																												@foreach ($order->statuses as $v)
																																																																																@if (\App\Enums\OrderEnumStatus::PACKED == $v->status)
																																																																																				<span
																																																																																								class="fw-normal">{{ $v->created_at->diffForHumans() }}</span>
																																																																																@endif
																																																																												@endforeach
																																																																								@endif
																																																																				</h6>
																																																																</div>
																																																												</div>
																																																								</a>
																																																				</div>
																																																</div>
																																																<div class="accordion-item border-0">
																																																				<div class="accordion-header" id="headingTwo">
																																																								<a class="accordion-button p-2 shadow-none"
																																																												data-bs-toggle="collapse" href="#collapseTwo"
																																																												aria-expanded="false" aria-controls="collapseTwo">
																																																												<div class="d-flex align-items-center">
																																																																<div class="avatar-xs flex-shrink-0">
																																																																				<div @class([
																																																																								"avatar-title rounded-circle",
																																																																								"bg-success" => in_array(
																																																																												\App\Enums\OrderEnumStatus::READY,
																																																																												$order_statuses),
																																																																								"bg-light text-success" => !in_array(
																																																																												\App\Enums\OrderEnumStatus::READY,
																																																																												$order_statuses),
																																																																				])>
																																																																								<i class="ri-truck-line"></i>
																																																																				</div>
																																																																</div>
																																																																<div class="flex-grow-1 ms-3">
																																																																				<h6 class="fs-15 fw-semibold mb-1">READY FOR SHIPMENT
																																																																								@if (in_array(\App\Enums\OrderEnumStatus::READY, $order_statuses))-
																																																																												@foreach ($order->statuses as $v)
																																																																																@if (\App\Enums\OrderEnumStatus::READY == $v->status)
																																																																																				<span
																																																																																								class="fw-normal">{{ $v->created_at->diffForHumans() }}</span>
																																																																																@endif
																																																																												@endforeach
																																																																								@endif
																																																																				</h6>
																																																																</div>
																																																												</div>
																																																								</a>
																																																				</div>
																																																</div>
																																																<div class="accordion-item border-0">
																																																				<div class="accordion-header" id="headingThree">
																																																								<a class="accordion-button p-2 shadow-none"
																																																												data-bs-toggle="collapse" href="#collapseThree"
																																																												aria-expanded="false" aria-controls="collapseThree">
																																																												<div class="d-flex align-items-center">
																																																																<div class="avatar-xs flex-shrink-0">
																																																																				<div @class([
																																																																								"avatar-title rounded-circle",
																																																																								"bg-success" => in_array(\App\Enums\OrderEnumStatus::OFD, $order_statuses),
																																																																								"bg-light text-success" => !in_array(
																																																																												\App\Enums\OrderEnumStatus::OFD,
																																																																												$order_statuses),
																																																																				])>
																																																																								<i class="mdi mdi-package-variant"></i>
																																																																				</div>
																																																																</div>
																																																																<div class="flex-grow-1 ms-3">
																																																																				<h6 class="fs-15 fw-semibold mb-1">OUT FOR DELIVERY
																																																																								@if (in_array(\App\Enums\OrderEnumStatus::OFD, $order_statuses))-
																																																																												@foreach ($order->statuses as $v)
																																																																																@if (\App\Enums\OrderEnumStatus::OFD == $v->status)
																																																																																				<span
																																																																																								class="fw-normal">{{ $v->created_at->diffForHumans() }}</span>
																																																																																@endif
																																																																												@endforeach
																																																																								@endif
																																																																				</h6>
																																																																</div>
																																																												</div>
																																																								</a>
																																																				</div>
																																																</div>
																																																<div class="accordion-item border-0">
																																																				<div class="accordion-header" id="headingFive">
																																																								<a class="accordion-button p-2 shadow-none"
																																																												data-bs-toggle="collapse" href="#collapseFile"
																																																												aria-expanded="false">
																																																												<div class="d-flex align-items-center">
																																																																<div class="avatar-xs flex-shrink-0">
																																																																				<div @class([
																																																																								"avatar-title rounded-circle",
																																																																								"bg-success" => in_array(
																																																																												\App\Enums\OrderEnumStatus::DELIVERED,
																																																																												$order_statuses),
																																																																								"bg-light text-success" => !in_array(
																																																																												\App\Enums\OrderEnumStatus::DELIVERED,
																																																																												$order_statuses),
																																																																				])>
																																																																								<i class="ri-map-pin-user-line"></i>
																																																																				</div>
																																																																</div>
																																																																<div class="flex-grow-1 ms-3">
																																																																				<h6 class="fs-14 fw-semibold mb-0">DELIVERED
																																																																								@if (in_array(\App\Enums\OrderEnumStatus::DELIVERED, $order_statuses))-
																																																																												@foreach ($order->statuses as $v)
																																																																																@if (\App\Enums\OrderEnumStatus::DELIVERED == $v->status)
																																																																																				<span
																																																																																								class="fw-normal">{{ $v->created_at->diffForHumans() }}</span>
																																																																																@endif
																																																																												@endforeach
																																																																								@endif
																																																																				</h6>
																																																																</div>
																																																												</div>
																																																								</a>
																																																				</div>
																																																</div>
																																												@else
																																																<div class="accordion-item border-0">
																																																				<div class="accordion-header" id="headingTwo">
																																																								<a class="accordion-button p-2 shadow-none"
																																																												data-bs-toggle="collapse" href="#collapseTwo"
																																																												aria-expanded="false" aria-controls="collapseTwo">
																																																												<div class="d-flex align-items-center">
																																																																<div class="avatar-xs flex-shrink-0">
																																																																				<div @class(["avatar-title rounded-circle", "bg-danger"])>
																																																																								<i class="ri-close-line"></i>
																																																																				</div>
																																																																</div>
																																																																<div class="flex-grow-1 ms-3">
																																																																				<h6 class="fs-15 fw-semibold mb-1">CANCELLED
																																																																								@if (!in_array(\App\Enums\OrderEnumStatus::CANCELLED, $order_statuses))-
																																																																												@foreach ($order->statuses as $v)
																																																																																@if (\App\Enums\OrderEnumStatus::DELIVERED == $v->status)
																																																																																				<span
																																																																																								class="fw-normal">{{ $v->created_at->diffForHumans() }}</span>
																																																																																@endif
																																																																												@endforeach
																																																																								@endif
																																																																				</h6>
																																																																</div>
																																																												</div>
																																																								</a>
																																																				</div>
																																																</div>
																																												@endif
																																								</div>
																																								<!--end accordion-->
																																				</div>
																																</div>
																												</div>
																												<!--end card-->
																								</div>
																								<!--end col-->
																								<div class="col-xl-6">

																												<div class="card">
																																<div class="card-header">
																																				<div class="d-flex">
																																								<h5 class="card-title flex-grow-1 mb-0">Customer Details</h5>
																																				</div>
																																</div>
																																<div class="card-body">
																																				<ul class="list-unstyled vstack mb-0 gap-3">
																																								<li><i
																																																class="ri-user-2-line text-muted fs-16 me-2 align-middle"></i>{{ $order->name }}
																																								</li>
																																								<li><i
																																																class="ri-mail-line text-muted fs-16 me-2 align-middle"></i>{{ $order->email }}
																																								</li>
																																								<li><i
																																																class="ri-phone-line text-muted fs-16 me-2 align-middle"></i>+91-{{ $order->phone }}
																																								</li>
																																				</ul>
																																</div>
																												</div>
																								</div>
																								<div class="col-xl-6">

																												<!--end card-->
																												<div class="card">
																																<div class="card-header">
																																				<h5 class="card-title mb-0"><i
																																												class="ri-map-pin-line text-muted me-1 align-middle"></i> Shipping Address
																																				</h5>
																																</div>
																																<div class="card-body">
																																				<ul class="list-unstyled vstack mb-0 gap-2">
																																								<li><b class="text-muted">Address:</b> {{ $order->address }}</li>
																																								<li><b class="text-muted">City/Pin:</b> {{ $order->city }} - {{ $order->pin }}
																																								</li>
																																								<li><b class="text-muted">State:</b> {{ $order->state }}</li>
																																								<li><b class="text-muted">Country:</b> {{ $order->country }}</li>
																																								<li><b class="text-muted">Delivery Slot:</b> {{ $order->delivery_slot ?? 'N/A' }}</li>
																																				</ul>
																																</div>
																												</div>
																												<!--end card-->
																								</div>
																								<div class="col-xl-12">

																												<!--end card-->
																												<div class="card">
																																<div class="card-header">
																																				<div class="d-flex align-items-center justify-content-between">
																																								<h5 class="card-title mb-0">Map
																																								</h5>
																																								@if ($order->map_information)
																																												<a href="https://maps.google.com/maps?daddr={{ $order->map_information->geometry->location->lat }},{{ $order->map_information->geometry->location->lng }}&hl=en"
																																																target="_blank" type="button" class="btn btn-secondary add-btn"
																																																id="address-btn"><i
																																																				class="ri-map-pin-line text-light me-1 align-middle"></i>
																																																Get Direction</a>
																																								@endif
																																				</div>
																																</div>
																																<div class="card-body">
																																				@if ($order->map_information)
																																								<iframe class="w-100" height="300" marginheight="0" marginwidth="0"
																																												src="https://maps.google.com/maps?q={{ $order->map_information->geometry->location->lat }},{{ $order->map_information->geometry->location->lng }}&hl=en&zoom=20&output=embed">
																																								</iframe>
																																								<br />
																																								<ul class="list-unstyled vstack mb-0 gap-2">
																																												<li><b class="text-muted">Address:</b>
																																																{{ $order->map_information->description }}
																																												</li>
																																								</ul>
																																				@else
																																								<ul class="list-unstyled vstack mb-0 gap-2">
																																												<li>Map Not Available
																																												</li>
																																								</ul>
																																				@endif
																																</div>
																												</div>
																												<!--end card-->
																								</div>
																								<div class="col-12">

																												<div class="card">
																																<div class="card-header">
																																				<div class="d-flex align-items-center justify-content-between">
																																								<h5 class="card-title mb-0"><i
																																																class="ri-secure-payment-line text-muted me-1 align-bottom"></i> Payment
																																												Details</h5>
																																				</div>
																																</div>
																																<div class="card-body">
																																				<div class="d-flex align-items-center mb-2">
																																								<div class="flex-shrink-0">
																																												<p class="text-muted mb-0">Payment Method:</p>
																																								</div>
																																								<div class="flex-grow-1 ms-2">
																																												<h6 class="mb-0">{{ $order->payment ? $order->payment->mode : "N/A" }}</h6>
																																								</div>
																																				</div>
																																				<div class="d-flex align-items-center mb-2">
																																								<div class="flex-shrink-0">
																																												<p class="text-muted mb-0">Payment Status:</p>
																																								</div>
																																								<div class="flex-grow-1 ms-2">
																																												<h6 class="mb-0">{{ $order->payment ? $order->payment->status : "N/A" }}
																																												</h6>
																																								</div>
																																				</div>
																																				<div class="d-flex align-items-center">
																																								<div class="flex-shrink-0">
																																												<p class="text-muted mb-0">Total Amount:</p>
																																								</div>
																																								<div class="flex-grow-1 ms-2">
																																												<h6 class="mb-0">&#8377; {{ $order->total_price }}</h6>
																																								</div>
																																				</div>
																																</div>
																												</div>
																												<!--end card-->
																								</div>
																								<!--end col-->
																				</div>

																</div>
												</div>
								</div>
								<!-- container-fluid -->
				</div><!-- End Page-content -->

@stop

@section("javascript")
				<script nonce="{{ csp_nonce() }}">
								document.getElementById('send_otp').addEventListener('click', async () => {
												var submitBtn = document.getElementById('send_otp');
												submitBtn.innerHTML = spinner
												submitBtn.disabled = true;
												try {

																const response = await axios.get(
																				'{{ route("delivery_management.agent.order_send_otp.get", $order->id) }}')
																successToast(response.data.message)
												} catch (error) {
																if (error?.response?.data?.message) {
																				errorToast(error?.response?.data?.message)
																}
												} finally {
																submitBtn.innerHTML = `Send OTP`
																submitBtn.disabled = false;
												}
								})
								const validation = new JustValidate('#otpForm', {
												errorFieldCssClass: 'is-invalid',
												focusInvalidField: true,
												lockForm: true,
								});
								// apply rules to form fields
								validation
												.addField('#otp', [{
																rule: 'required',
																errorMessage: 'Otp is required',
												}, ])
												.onSuccess(async (event) => {
																var submitBtn = document.getElementById('completeBtn')
																submitBtn.innerHTML = spinner
																submitBtn.disabled = true;
																try {
																				var formData = new FormData();
																				formData.append('otp', document.getElementById('otp').value)
																				const response = await axios.post(
																								'{{ route("delivery_management.agent.order_deliver_order.post", $order->id) }}', formData)
																				successToast(response.data.message)
																				setTimeout(() => {
																								location.reload()
																				}, 1000);
																} catch (error) {
																				console.log(error)
																				if (error?.response?.data?.errors?.otp) {
																								validation.showErrors({
																												'#otp': error?.response?.data?.errors?.otp[0]
																								})
																				}
																				if (error?.response?.data?.message) {
																								errorToast(error?.response?.data?.message)
																				}
																} finally {
																				submitBtn.innerHTML = `Complete`
																				submitBtn.disabled = false;
																}
												})
				</script>
@stop
