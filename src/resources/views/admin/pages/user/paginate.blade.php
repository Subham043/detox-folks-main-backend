@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="user.paginate.get" page="User" :list='["List"]' />
												<!-- end page title -->

												<div class="row">
																<div class="col-lg-12">
																				<div class="card">
																								<div class="card-header">
																												<h4 class="card-title mb-0">Users</h4>
																								</div><!-- end card header -->

																								<div class="card-body">
																												<div id="customerList">
																																<div class="row justify-content-between g-4 mb-3">
																																				<div class="col-sm-auto">
																																								<div>
																																												<a href="{{ route("user.create.get") }}" type="button"
																																																class="btn btn-success add-btn" id="create-btn"><i
																																																				class="ri-add-line me-1 align-bottom"></i> Create</a>
                                                                                                                                                                                <a href="{{ route("user.excel.get") }}" download type="button"
																																												class="btn btn-info add-btn" id="create-btn"><i
																																																class="ri-file-excel-fill me-1 align-bottom"></i> Excel Download</a>
																																								</div>
																																				</div>
																																				<form action="{{route('user.paginate.get')}}" method="GET" class="col-md-auto col-sm-12 d-flex gap-2 justify-content-end align-items-center">
                                                                                                                                                                <div class="col-xxl-4 col-lg-4 col-sm-12">
                                                                                                                                                                    <select class="form-control" name="filter[has_role]"
                                                                                                                                                                                    id="has_role">
                                                                                                                                                                                    <option value="all" @if (strpos("all", $has_role) !== false) selected @endif>all
                                                                                                                                                                                    </option>
                                                                                                                                                                                    @foreach ($roles as $v)
                                                                                                                                                                                                    <option value="{{ $v }}"
                                                                                                                                                                                                                    @if (strpos($v, $has_role) !== false) selected @endif>
                                                                                                                                                                                                                    {{ $v }}</option>
                                                                                                                                                                                    @endforeach
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
																																																				<th class="sort" data-sort="customer_name">Email</th>
																																																				<th class="sort" data-sort="customer_name">Phone</th>
																																																				<th class="sort" data-sort="status">Role</th>
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
																																																								<td class="customer_name">{{ $item->current_role }}</td>
																																																								<td class="date">{{ $item->created_at->format("d M Y h:i A") }}</td>
																																																								<td>
																																																												<div class="d-flex gap-2">
																																																																<div class="edit">
																																																																				<a href="{{ route("user.update.get", $item->id) }}"
																																																																								class="btn btn-sm btn-primary edit-item-btn">Edit</a>
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
