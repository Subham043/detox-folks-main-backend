@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="warehouse_management.order.get" page="Order" :list='["List"]' />
												<!-- end page title -->

												<div class="row">
																<div class="col-lg-12">
																				<div class="card">
																								<form action="{{ route("warehouse_management.order.get") }}" method="GET">
																												<div class="card-header d-flex justify-content-between align-items-center">
																																<h4 class="card-title mb-0">Order</h4>
																																<button type="submit" class="btn btn-primary">
																																				Filter
																																</button>
																												</div><!-- end card header -->

																												<div class="card-body border-end-0 border-start-0 border border-dashed">
																																{{-- <form action="{{ route("warehouse_management.order.get") }}" method="GET">
                                                                                                                        <!--end row-->
                                                                                                                    </form> --}}
																																<div class="row g-1 align-items-end justify-content-end">
																																				<div class="col-xxl-12 col-lg-12 col-sm-12">
																																								<label class="form-label" for="">Search</label>
																																								<div class="search-box">
																																												<input type="text" class="form-control search" name="filter[search]"
																																																placeholder="Search for anything..." value="{{ $search }}">
																																												<i class="ri-search-line search-icon"></i>
																																								</div>
																																				</div>
																																</div>
																												</div>
																								</form>

																								<div class="card-body">
																												<div id="customerList">
																																<div class="table-responsive table-card mb-1">
																																				@if ($order->total() > 0)
																																								<table class="table-nowrap table align-middle" id="customerTable">
																																												<thead class="table-light">
																																																<tr>
																																																				<th class="sort" data-sort="customer_name">ID</th>
																																																				<th class="sort" data-sort="customer_name">Name</th>
																																																				<th class="sort" data-sort="customer_name">Email</th>
																																																				<th class="sort" data-sort="customer_name">Phone</th>
																																																				<th class="sort" data-sort="customer_name">Products</th>
																																																				<th class="sort" data-sort="customer_name">Total Amount</th>
																																																				<th class="sort" data-sort="customer_name">Mode Of Payment</th>
																																																				<th class="sort" data-sort="customer_name">Payment Status</th>
																																																				<th class="sort" data-sort="customer_name">Order Status</th>
																																																				<th class="sort" data-sort="date">Status Updated On</th>
																																																				<th class="sort" data-sort="date">Placed On</th>
																																																				<th class="sort" data-sort="action">Action</th>
																																																</tr>
																																												</thead>
																																												<tbody class="list form-check-all">
																																																@foreach ($order->items() as $item)
																																																				<tr>
																																																								<td class="customer_name">{{ $item->id }}</td>
																																																								<td class="customer_name">{{ $item->name }}</td>
																																																								<td class="customer_name">{{ $item->email }}</td>
																																																								<td class="customer_name">{{ $item->phone }}</td>
																																																								<td class="customer_name">
																																																												@foreach ($item->products as $k => $v)
																																																																<span
																																																																				class="badge bg-success">{{ $v->name }}</span><br />
																																																												@endforeach
																																																								</td>
																																																								<td class="customer_name">&#8377;{{ $item->total_price }}</td>
																																																								<td class="customer_name">{{ $item->payment->mode ?? "" }}</td>
																																																								<td class="customer_name">{{ $item->payment->status ?? "" }}</td>
																																																								<td class="customer_name">
																																																												{{ $item->current_status ? $item->current_status->status : "" }}
																																																								</td>
																																																								<td class="customer_name">
																																																												{{ $item->current_status ? $item->current_status->created_at->diffForHumans() : "" }}
																																																								</td>
																																																								<td class="date">{{ $item->created_at->diffForHumans() }}</td>
																																																								<td>
																																																												<div class="d-flex gap-2">
																																																																<div class="edit">
																																																																				<a href="{{ route("warehouse_management.order_detail.get", $item->id) }}"
																																																																								class="btn btn-sm btn-primary edit-item-btn">View</a>
																																																																</div>

                                                                                                                                                                                                                                                                @if (!in_array(\App\Enums\OrderEnumStatus::CANCELLED, $item->statuses->pluck("status")->toArray()))

                                                                                                                                                                                                                                                                    @if (!in_array(\App\Enums\OrderEnumStatus::PACKED, $item->statuses->pluck("status")->toArray()) && in_array(\App\Enums\OrderEnumStatus::CONFIRMED, $item->statuses->pluck("status")->toArray()))
                                                                                                                                                                                                                                                                                    <div class="remove">
                                                                                                                                                                                                                                                                                                    <button
                                                                                                                                                                                                                                                                                                                    class="btn btn-sm btn-warning remove-item-btn"
                                                                                                                                                                                                                                                                                                                    data-link="{{ route("warehouse_management.order_placed.get", $item->id) }}">Packing Completed</button>
                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                    @endif

                                                                                                                                                                                                                                                                @endif
																																																												</div>
																																																								</td>
																																																				</tr>
																																																@endforeach

																																												</tbody>
																																								</table>
																																				@else
																																								<x-includes.no-result />
																																				@endif
																																</div>
																																{{ $order->withQueryString()->onEachSide(5)->links("admin.includes.pagination") }}
																												</div>
																								</div><!-- end card -->
																				</div>
																				<!-- end col -->
																</div>
																<!-- end col -->
												</div>
												<!-- end row -->

								</div>
				</div>

@stop
