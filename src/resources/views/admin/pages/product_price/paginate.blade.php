@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="product_price.paginate.get" :id="$product_id" page="Product Price"
																:list='["List"]' />
												<!-- end page title -->

												<div class="row">
																<x-includes.back-button link="product.paginate.get" />
																<div class="col-lg-12">
																				<div class="card">
																								<div class="card-header">
																												<h4 class="card-title mb-0">Product Price</h4>
																								</div><!-- end card header -->

																								<div class="card-body">
																												<div id="customerList">
																																<div class="row g-4 mb-3">
																																				<div class="col-sm-auto">
																																								<div>
																																												<a href="{{ route("product_price.create.get", $product_id) }}" type="button"
																																																class="btn btn-success add-btn" id="create-btn"><i
																																																				class="ri-add-line me-1 align-bottom"></i> Create</a>
																																								</div>
																																				</div>
																																				<div class="col-sm">
																																								<x-includes.search :search="$search" :id="$product_id"
																																												link="product_price.paginate.get" />
																																				</div>
																																</div>
																																<div class="table-responsive table-card mb-1 mt-3">
																																				@if ($data->total() > 0)
																																								<table class="table-nowrap table align-middle" id="customerTable">
																																												<thead class="table-light">
																																																<tr>
																																																				<th class="sort" data-sort="customer_name">Minimum Quantity</th>
																																																				<th class="sort" data-sort="customer_name">Price</th>
																																																				<th class="sort" data-sort="customer_name">Discount(%)</th>
																																																				<th class="sort" data-sort="date">Created On</th>
																																																				<th class="sort" data-sort="action">Action</th>
																																																</tr>
																																												</thead>
																																												<tbody class="list form-check-all">
																																																@foreach ($data->items() as $item)
																																																				<tr>
																																																								<td class="customer_name">{{ $item->min_quantity }}</td>
																																																								<td class="customer_name">{{ $item->price }}</td>
																																																								<td class="customer_name">{{ $item->discount }}</td>
																																																								<td class="date">{{ $item->created_at->diffForHumans() }}</td>
																																																								<td>
																																																												<div class="d-flex gap-2">
																																																																<div class="edit">
																																																																				<a href="{{ route("product_price.update.get", [$product_id, $item->id]) }}"
																																																																								class="btn btn-sm btn-primary edit-item-btn">Edit</a>
																																																																</div>
																																																																<div class="remove">
																																																																				<button class="btn btn-sm btn-danger remove-item-btn"
																																																																								data-link="{{ route("product_price.delete.get", [$product_id, $item->id]) }}">Delete</button>
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
