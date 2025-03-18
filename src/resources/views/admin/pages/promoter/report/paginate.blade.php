@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="promoter.report.paginate.get" page="Promoter Report Data" :list='["List"]' />
												<!-- end page title -->

												<div class="row">
																<div class="col-lg-12">
																				<div class="card">
																								<div class="card-header">
																												<h4 class="card-title mb-0">Promoter Report Data</h4>
																								</div><!-- end card header -->

																								<div class="card-body">
																												<div id="customerList">
																																<div class="row g-4 mb-3">
																																				<div class="col-sm-auto">
																																								<div>
                                                                                                                                                                                @hasanyrole("App Promoter")
																																												<a href="{{ route("promoter.report.create.get") }}" type="button"
																																																class="btn btn-success add-btn" id="create-btn"><i
																																																				class="ri-add-line me-1 align-bottom"></i> Create</a>
                                                                                                                                                                                @endhasanyrole
                                                                                                                                                                                @hasanyrole("Sales Coordinators|Super-Admin|Staff")
                                                                                                                                                                                <a href="{{ route("promoter.report.list.get") }}" type="button" class="btn btn-dark add-btn" id="create-btn"><i
                                                                                                                                                                                        class="ri-file-chart-line me-1 align-bottom"></i> Report</a>
                                                                                                                                                                                @endhasanyrole
                                                                                                                                                                                <a href="{{ route("promoter.report.excel.get") }}?{{ request()->getQueryString() }}" download type="button"
																																												class="btn btn-info add-btn" id="create-btn"><i
																																																class="ri-file-excel-fill me-1 align-bottom"></i> Excel Download</a>
																																								</div>
																																				</div>
																																				<div class="col-sm">
																																								<x-includes.search :search="$search" link="promoter.report.paginate.get" />
																																				</div>
																																</div>
																																<div class="table-responsive table-card mb-1 mt-3">
																																				@if ($data->total() > 0)
																																								<table class="table-nowrap table align-middle" id="customerTable">
																																												<thead class="table-light">
																																																<tr>
																																																				<th class="sort" data-sort="customer_name">Name</th>
																																																				<th class="sort" data-sort="customer_name">Phone</th>
																																																				<th class="sort" data-sort="customer_name">Location</th>
																																																				<th class="sort" data-sort="customer_name">Is App Installed?</th>
																																																				<th class="sort" data-sort="customer_name">Remark</th>
                                                                                                                                                                                                                @hasanyrole("Sales Coordinators|Super-Admin|Staff")
																																																				<th class="sort" data-sort="date">Created By</th>
                                                                                                                                                                                                                @endhasanyrole
																																																				<th class="sort" data-sort="date">Created On</th>
																																																				<th class="sort" data-sort="action">Action</th>
																																																</tr>
																																												</thead>
																																												<tbody class="list form-check-all">
																																																@foreach ($data->items() as $item)
																																																				<tr>
																																																								<td class="customer_name">{{ $item->name }}</td>
																																																								<td class="customer_name">{{ $item->phone }}</td>
																																																								<td class="customer_name">{{ $item->location }}</td>
																																																								@if ($item->is_app_installed == 1)
																																																												<td class="status"><span
																																																																				class="badge badge-soft-success text-uppercase">Yes</span>
																																																												</td>
																																																								@else
																																																												<td class="status"><span
																																																																				class="badge badge-soft-danger text-uppercase">No</span>
																																																												</td>
																																																								@endif
                                                                                                                                                                                                                                <td class="customer_name">{{ $item->remarks ?? 'N/A' }}</td>
                                                                                                                                                                                                                                @hasanyrole("Sales Coordinators|Super-Admin|Staff")
                                                                                                                                                                                                                                <td class="customer_name">{{ $item->promoter->name ?? 'N/A' }}</td>
                                                                                                                                                                                                                                @endhasanyrole
																																																								<td class="date">{{ $item->created_at->format("d M Y h:i A") }}</td>
																																																								<td>
																																																												<div class="d-flex gap-2">
                                                                                                                                                                                                                                                                @hasanyrole("App Promoter")
																																																																<div class="edit">
																																																																				<a href="{{ route("promoter.report.update.get", $item->id) }}"
																																																																								class="btn btn-sm btn-primary edit-item-btn">Edit</a>
																																																																</div>
                                                                                                                                                                                                                                                                @endhasanyrole
																																																																<div class="remove">
																																																																				<button class="btn btn-sm btn-danger remove-item-btn"
																																																																								data-link="{{ route("promoter.report.delete.get", $item->id) }}">Delete</button>
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
