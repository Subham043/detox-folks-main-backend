@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="delivery_management.agent.paginate.get" page="Delivery Agent" :list='["List"]' />
												<!-- end page title -->

												<div class="row">
																<div class="col-lg-12">
																				<div class="card">
																								<div class="card-header">
																												<h4 class="card-title mb-0">Delivery Agents</h4>
																								</div><!-- end card header -->

																								<div class="card-body">
																												<div id="customerList">
																																<div class="row g-4 mb-3">
																																				<div class="col-sm-auto">
																																								<div>
																																												<a href="{{ route("user.create.get") }}" type="button" target="_blank"
																																																class="btn btn-success add-btn" id="create-btn"><i
																																																				class="ri-add-line me-1 align-bottom"></i> Create Delivery Agent</a>
																																								</div>
																																				</div>
																																				<div class="col-sm">
																																								<x-includes.search :search="$search"
																																												link="delivery_management.agent.paginate.get" />
																																				</div>
																																</div>
																																<div class="table-responsive table-card mb-1 mt-3">
																																				@if ($data->total() > 0)
																																								<table class="table-nowrap table align-middle" id="customerTable">
																																												<thead class="table-light">
																																																<tr>
																																																				<th class="sort" data-sort="customer_name">Name</th>
																																																				<th class="sort" data-sort="customer_name">Email</th>
																																																				<th class="sort" data-sort="customer_name">Phone</th>
																																																				<th class="sort" data-sort="customer_name">Orders Assigned</th>
																																																				<th class="sort" data-sort="date">Created On</th>
																																																				<th class="sort" data-sort="action">Action</th>
																																																</tr>
																																												</thead>
																																												<tbody class="list form-check-all">
																																																@foreach ($data->items() as $item)
																																																				<tr>
																																																								<td class="customer_name">{{ $item->name }}</td>
																																																								<td class="customer_name">{{ $item->email }}</td>
																																																								<td class="customer_name">{{ $item->phone }}</td>
																																																								<td class="customer_name">{{ $item->order_assigned_count }}</td>
																																																								<td class="date">{{ $item->created_at->format("d M Y h:i A") }}</td>
																																																								<td>
																																																												<div class="d-flex gap-2">
																																																																<div class="edit">
																																																																				<a href="{{ route("user.update.get", $item->id) }}"
																																																																								class="btn btn-sm btn-primary edit-item-btn">Edit</a>
																																																																</div>

																																																																<div class="edit">
																																																																				<a href="{{ route("delivery_management.agent.assign_order.get", $item->id) }}"
																																																																								class="btn btn-sm btn-dark edit-item-btn">Assign
																																																																								Order</a>
																																																																</div>

																																																																<div class="edit">
																																																																				<a href="{{ route("delivery_management.agent.assigned_order.get", $item->id) }}"
																																																																								class="btn btn-sm btn-warning edit-item-btn">Orders
																																																																								Assigned</a>
																																																																</div>

																																																																<div class="remove">
																																																																				<button class="btn btn-sm btn-danger remove-item-btn"
																																																																								data-link="{{ route("user.delete.get", $item->id) }}">Delete</button>
																																																																</div>
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
																																{{ $data->onEachSide(5)->links("admin.includes.pagination") }}
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
