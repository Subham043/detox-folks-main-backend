@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="product_review.paginate.get" :id="$product_id" page="Product Review"
																:list='["List"]' />
												<!-- end page title -->

												<div class="row">
																<x-includes.back-button link="product.paginate.get" />
																<div class="col-lg-12">
																				<div class="card">
																								<div class="card-header">
																												<h4 class="card-title mb-0">Product Review</h4>
																								</div><!-- end card header -->

																								<div class="card-body">
																												<div id="customerList">
																																<div class="row g-4 mb-3">
																																				<div class="col-sm-auto">
																																								<div>
																																												<a href="{{ route("product_review.create.get", $product_id) }}"
																																																type="button" class="btn btn-success add-btn" id="create-btn"><i
																																																				class="ri-add-line me-1 align-bottom"></i> Create</a>
																																								</div>
																																				</div>
																																				<div class="col-sm">
																																								<x-includes.search :search="$search" :id="$product_id"
																																												link="product_review.paginate.get" />
																																				</div>
																																</div>
																																<div class="table-responsive table-card mb-1 mt-3">
																																				@if ($data->total() > 0)
																																								<table class="table-nowrap table align-middle" id="customerTable">
																																												<thead class="table-light">
																																																<tr>
																																																				<th class="sort" data-sort="customer_name">Rating</th>
																																																				<th class="sort" data-sort="customer_name">Comment</th>
																																																				<th class="sort" data-sort="customer_name">User Name</th>
																																																				<th class="sort" data-sort="customer_name">User Email</th>
																																																				<th class="sort" data-sort="customer_name">Is Draft</th>
																																																				<th class="sort" data-sort="date">Created On</th>
																																																				<th class="sort" data-sort="action">Action</th>
																																																</tr>
																																												</thead>
																																												<tbody class="list form-check-all">
																																																@foreach ($data->items() as $item)
																																																				<tr>
																																																								<td class="customer_name">{{ $item->rating }}</td>
																																																								<td class="customer_name">{{ Str::limit($item->comment, 20) }}
                                                                                                                                                                                                                                </td>
                                                                                                                                                                                                                                <td class="customer_name">{{ $item->user->name ?? '' }}</td>
                                                                                                                                                                                                                                <td class="customer_name">{{ $item->user->email ?? '' }}</td>
                                                                                                                                                                                                                                @if ($item->is_draft == 1)
																																																												<td class="status"><span
																																																																				class="badge badge-soft-success text-uppercase">Yes</span>
																																																												</td>
																																																								@else
																																																												<td class="status"><span
																																																																				class="badge badge-soft-danger text-uppercase">No</span>
																																																												</td>
																																																								@endif
																																																								<td class="date">{{ $item->created_at->format("d M Y h:i A") }}</td>
																																																								<td>
																																																												<div class="d-flex gap-2">
																																																																<div class="edit">
																																																																				<a href="{{ route("product_review.update.get", [$product_id, $item->id]) }}"
																																																																								class="btn btn-sm btn-primary edit-item-btn">Edit</a>
																																																																</div>
																																																																<div class="remove">
																																																																				<button class="btn btn-sm btn-danger remove-item-btn"
																																																																								data-link="{{ route("product_review.delete.get", [$product_id, $item->id]) }}">Delete</button>
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
