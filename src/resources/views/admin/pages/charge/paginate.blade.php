@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												@include("admin.includes.breadcrumb", [
																"page" => "Cart Charges",
																"page_link" => route("charge.paginate.get"),
																"list" => ["List"],
												])
												<!-- end page title -->

												<div class="row">
																<div class="col-lg-12">
																				<div class="card">
																								<div class="card-header">
																												<h4 class="card-title mb-0">Cart Charges</h4>
																								</div><!-- end card header -->

																								<div class="card-body">
																												<div id="customerList">
																																<div class="row g-4 mb-3">
																																				<div class="col-sm-auto">
																																								<div>
																																												@can("create charges")
																																																<a href="{{ route("charge.create.get") }}" type="button"
																																																				class="btn btn-success add-btn" id="create-btn"><i
																																																								class="ri-add-line me-1 align-bottom"></i> Create</a>
																																												@endcan
																																								</div>
																																				</div>
																																				<div class="col-sm">
																																								@include("admin.includes.search_list", [
																																												"link" => route("charge.paginate.get"),
																																												"search" => $search,
																																								])
																																				</div>
																																</div>
																																<div class="table-responsive table-card mb-1 mt-3">
																																				@if ($data->total() > 0)
																																								<table class="table-nowrap table align-middle" id="customerTable">
																																												<thead class="table-light">
																																																<tr>
																																																				<th class="sort" data-sort="customer_name">Charge Name</th>
																																																				<th class="sort" data-sort="customer_name">Charge Slug</th>
																																																				<th class="sort" data-sort="customer_name">Amount</th>
																																																				<th class="sort" data-sort="customer_name">Status</th>
																																																				<th class="sort" data-sort="date">Created On</th>
																																																				<th class="sort" data-sort="action">Action</th>
																																																</tr>
																																												</thead>
																																												<tbody class="list form-check-all">
																																																@foreach ($data->items() as $item)
																																																				<tr>
																																																								<td class="customer_name">{{ $item->charges_name }}</td>
																																																								<td class="customer_name">{{ $item->charges_slug }}</td>
																																																								<td class="customer_name">{{ $item->charges_in_amount }}</td>
																																																								@if ($item->is_active == 1)
																																																												<td class="status"><span
																																																																				class="badge badge-soft-success text-uppercase">Active</span>
																																																												</td>
																																																								@else
																																																												<td class="status"><span
																																																																				class="badge badge-soft-danger text-uppercase">Draft</span>
																																																												</td>
																																																								@endif
																																																								<td class="date">{{ $item->created_at->diffForHumans() }}</td>
																																																								<td>
																																																												<div class="d-flex gap-2">
																																																																@can("edit charges")
																																																																				<div class="edit">
																																																																								<a href="{{ route("charge.update.get", $item->id) }}"
																																																																												class="btn btn-sm btn-primary edit-item-btn">Edit</a>
																																																																				</div>
																																																																@endcan

																																																																@can("delete charges")
																																																																				<div class="remove">
																																																																								<button class="btn btn-sm btn-danger remove-item-btn"
																																																																												data-link="{{ route("charge.delete.get", $item->id) }}">Delete</button>
																																																																				</div>
																																																																@endcan
																																																												</div>
																																																								</td>
																																																				</tr>
																																																@endforeach

																																												</tbody>
																																								</table>
																																				@else
																																								@include("admin.includes.no_result")
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
