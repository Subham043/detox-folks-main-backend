@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="product.paginate.get" page="Product" :list='["List"]' />
												<!-- end page title -->

												<div class="row">
																<div class="col-lg-12">
																				<div class="card">
																								<div class="card-header">
																												<h4 class="card-title mb-0">Product</h4>
																								</div><!-- end card header -->

																								<div class="card-body">
																												<div id="customerList">
																																<div class="row justify-content-between g-4 mb-3">
																																				<div class="col-sm-auto">
																																								<div>
																																												<a href="{{ route("product.create.get") }}" type="button"
																																																class="btn btn-success add-btn" id="create-btn"><i
																																																				class="ri-add-line me-1 align-bottom"></i> Create</a>
                                                                                                                                                                                <a href="{{ route("product.excel.get") }}" download type="button"
																																												class="btn btn-info add-btn" id="create-btn"><i
																																																class="ri-file-excel-fill me-1 align-bottom"></i> Excel Download</a>
																																								</div>
																																				</div>
                                                                                                                                                <form action="{{route('product.paginate.get')}}" method="GET" class="col-md-auto col-sm-12 d-flex gap-2 justify-content-end align-items-center">
                                                                                                                                                                <div class="col-xxl-4 col-lg-4 col-sm-12">
                                                                                                                                                                    <select class="form-control" name="filter[stock_status]"
                                                                                                                                                                                    id="stock_status">
                                                                                                                                                                                    <option value="all" @if (strpos("all", $stock_status) !== false) selected @endif>ALL
                                                                                                                                                                                    </option>
                                                                                                                                                                                    <option value="IN STOCK"
                                                                                                                                                                                                    @if (strpos("IN STOCK", $stock_status) !== false) selected @endif>
                                                                                                                                                                                                    IN STOCK</option>
                                                                                                                                                                                    <option value="FEW ITEMS LEFT"
                                                                                                                                                                                                    @if (strpos("FEW ITEMS LEFT", $stock_status) !== false) selected @endif>
                                                                                                                                                                                                    FEW ITEMS LEFT</option>
                                                                                                                                                                                    <option value="OUT OF STOCK"
                                                                                                                                                                                                    @if (strpos("OUT OF STOCK", $stock_status) !== false) selected @endif>
                                                                                                                                                                                                    OUT OF STOCK</option>
                                                                                                                                                                    </select>
                                                                                                                                                                </div>
                                                                                                                                                                <div class="col-xxl-auto col-lg-auto col-sm-12">
                                                                                                                                                                                <div class="search-box">
                                                                                                                                                                                                <input type="text" class="form-control search" name="filter[search]"
                                                                                                                                                                                                                placeholder="Search for anything..." value="{{ $search }}">
                                                                                                                                                                                                <i class="ri-search-line search-icon"></i>
                                                                                                                                                                                </div>
                                                                                                                                                                </div>
                                                                                                                                                                <button type="submit" class="btn btn-primary w-auto">
                                                                                                                                                                                Filter
                                                                                                                                                                </button>
																																				</form>
																																</div>
																																<div class="table-responsive table-card mb-1 mt-3">
																																				@if ($data->total() > 0)
																																								<table class="table-nowrap table align-middle" id="customerTable">
																																												<thead class="table-light">
																																																<tr>
																																																				<th class="sort" data-sort="customer_name">Name</th>
																																																				<th class="sort" data-sort="customer_name">Slug</th>
																																																				<th class="sort" data-sort="customer_name">Description</th>
																																																				<th class="sort" data-sort="customer_name">Stock Status</th>
																																																				<th class="sort" data-sort="customer_name">Status</th>
																																																				<th class="sort" data-sort="date">Created On</th>
																																																				<th class="sort" data-sort="action">Action</th>
																																																</tr>
																																												</thead>
																																												<tbody class="list form-check-all">
																																																@foreach ($data->items() as $item)
																																																				<tr>
																																																								<td class="customer_name">{{ $item->name }}</td>
																																																								<td class="customer_name">{{ $item->slug }}</td>
																																																								<td class="customer_name">
																																																												{{ Str::limit($item->description_unfiltered, 20) }}</td>
                                                                                                                                                                                                                                <td class="status"><span class="badge {{$item->available_stock<=0 ? 'badge-soft-danger' : ($item->available_stock<=$item->min_stock ? 'badge-soft-warning' : 'badge-soft-success')}} text-uppercase">{{$item->available_stock<=0 ? 'OUT OF STOCK' : ($item->available_stock<=$item->min_stock ? 'FEW ITEMS LEFT' : 'IN STOCK')}}</span></td>
																																																								@if ($item->is_draft == 1)
																																																												<td class="status"><span
																																																																				class="badge badge-soft-success text-uppercase">Active</span>
																																																												</td>
																																																								@else
																																																												<td class="status"><span
																																																																				class="badge badge-soft-danger text-uppercase">Draft</span>
																																																												</td>
																																																								@endif
																																																								<td class="date">{{ $item->created_at->format("d M Y h:i A") }}</td>
																																																								<td>
																																																												<div class="d-flex gap-2">
																																																																<div class="edit">
																																																																				<a href="{{ route("product.update.get", $item->id) }}"
																																																																								class="btn btn-sm btn-primary edit-item-btn">Edit</a>
																																																																</div>

																																																																<div class="edit">
																																																																				<a href="{{ route("product_specification.paginate.get", $item->id) }}"
																																																																								class="btn btn-sm btn-warning edit-item-btn">Specifications</a>
																																																																</div>

																																																																<div class="edit">
																																																																				<a href="{{ route("product_color.paginate.get", $item->id) }}"
																																																																								class="btn btn-sm btn-warning edit-item-btn">Colors</a>
																																																																</div>

																																																																<div class="edit">
																																																																				<a href="{{ route("product_price.paginate.get", $item->id) }}"
																																																																								class="btn btn-sm btn-warning edit-item-btn">Prices</a>
																																																																</div>

																																																																<div class="edit">
																																																																				<a href="{{ route("product_image.paginate.get", $item->id) }}"
																																																																								class="btn btn-sm btn-warning edit-item-btn">Images</a>
																																																																</div>

																																																																<div class="edit">
																																																																				<a href="{{ route("product_video.paginate.get", $item->id) }}"
																																																																								class="btn btn-sm btn-warning edit-item-btn">Video</a>
																																																																</div>

                                                                                                                                                                                                                                                                <div class="edit">
																																																																				<a href="{{ route("product_review.paginate.get", $item->id) }}"
																																																																								class="btn btn-sm btn-warning edit-item-btn">Reviews</a>
																																																																</div>

																																																																<div class="remove">
																																																																				<button class="btn btn-sm btn-danger remove-item-btn"
																																																																								data-link="{{ route("product.delete.get", $item->id) }}">Delete</button>
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
