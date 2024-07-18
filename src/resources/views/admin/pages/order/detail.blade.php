@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<x-includes.breadcrumb link="order_admin.paginate.get" page="Order" :list='["Detail"]' />

												<div class="row project-wrapper">
																<x-includes.back-button link="order_admin.paginate.get" />
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
																																																																</div>
																																																												</div>
																																																								</td>
																																																								<td>&#8377; {{ $v->discount_in_price }}/pieces</td>
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
																																								@if (!in_array(\App\Enums\OrderEnumStatus::CANCELLED, $order_statuses))
																																												<div class="mt-sm-0 row mt-2 flex-shrink-0 gap-1">
																																																@if (!in_array(\App\Enums\OrderEnumStatus::CONFIRMED, $order_statuses))
																																																				<button
																																																								data-link="{{ route("order_admin.update_order_status.get", $order->id) }}"
																																																								class="btn btn-soft-success btn-sm mt-sm-0 remove-item-btn col-auto mt-2"><i
																																																												class="ri-donut-chart-line me-1 align-bottom"></i>
																																																								Change Order Status :
																																																								CONFIRMED
																																																				</button>
																																																@elseif(!in_array(\App\Enums\OrderEnumStatus::PACKED, $order_statuses))
																																																				<button
																																																								data-link="{{ route("order_admin.update_order_status.get", $order->id) }}"
																																																								class="btn btn-soft-success btn-sm mt-sm-0 remove-item-btn col-auto mt-2"><i
																																																												class="ri-donut-chart-line me-1 align-bottom"></i>
																																																								Change Order Status :
																																																								PACKED
																																																				</button>
																																																@elseif(!in_array(\App\Enums\OrderEnumStatus::READY, $order_statuses))
																																																				<button
																																																								data-link="{{ route("order_admin.update_order_status.get", $order->id) }}"
																																																								class="btn btn-soft-success btn-sm mt-sm-0 remove-item-btn col-auto mt-2"><i
																																																												class="ri-donut-chart-line me-1 align-bottom"></i>
																																																								Change Order Status :
																																																								READY FOR SHIPMENT
																																																				</button>
																																																@elseif(!in_array(\App\Enums\OrderEnumStatus::OFD, $order_statuses))
																																																				<button
																																																								data-link="{{ route("order_admin.update_order_status.get", $order->id) }}"
																																																								class="btn btn-soft-success btn-sm mt-sm-0 remove-item-btn col-auto mt-2"><i
																																																												class="ri-donut-chart-line me-1 align-bottom"></i>
																																																								Change Order Status :
																																																								OUT FOR DELIVERY
																																																				</button>
																																																@elseif(!in_array(\App\Enums\OrderEnumStatus::DELIVERED, $order_statuses))
																																																				<button
																																																								data-link="{{ route("order_admin.update_order_status.get", $order->id) }}"
																																																								class="btn btn-soft-success btn-sm mt-sm-0 remove-item-btn col-auto mt-2"><i
																																																												class="ri-donut-chart-line me-1 align-bottom"></i>
																																																								Change Order Status :
																																																								DELIVERED
																																																				</button>
																																																@endif
																																																<button data-link="{{ route("order_admin.cancel.get", $order->id) }}"
																																																				class="btn btn-soft-danger btn-sm mt-sm-0 remove-item-btn col-auto mt-2"><i
																																																								class="mdi mdi-archive-remove-outline me-1 align-bottom"></i> Cancel
																																																				Order</button>
																																												</div>
																																								@endif
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
																																								<li>{{ $order->address }}</li>
																																								<li>{{ $order->city }} - {{ $order->pin }}</li>
																																								<li>{{ $order->state }}</li>
																																								<li>{{ $order->country }}</li>
																																				</ul>
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
																																								@if (!in_array(\App\Enums\OrderEnumStatus::CANCELLED, $order_statuses))
																																												@if ($order->payment && $order->payment->status != \App\Enums\PaymentStatus::PAID)
																																																<div class="mt-sm-0 row mt-2 flex-shrink-0 gap-1">
																																																				<button
																																																								data-link="{{ route("order_admin.payment_update.get", $order->id) }}"
																																																								class="btn btn-soft-success btn-sm mt-sm-0 remove-item-btn col-auto mt-2">
																																																								Change Payment Status :
																																																								PAID
																																																				</button>
																																																</div>
																																												@endif
																																								@endif
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
																																				@if ($order->payment)
																																								@foreach ($order->payment->resolvedPaymentData as $key => $value)
																																												@if (!is_array($value) && !is_object($value))
																																																@if ($value)
																																																				<div class="d-flex align-items-center">
																																																								<div class="flex-shrink-0">
																																																												<p class="text-muted mb-0">{{ $key }}:</p>
																																																								</div>
																																																								<div class="flex-grow-1 ms-2">
																																																												<h6 class="mb-0">
																																																																{{ $value }}
																																																												</h6>
																																																								</div>
																																																				</div>
																																																@endif
																																												@endif
																																								@endforeach
																																				@endif
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
