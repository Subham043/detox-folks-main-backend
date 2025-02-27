@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="promoter.report.list.get" page="Promoter Report" :list='["List"]' />
												<!-- end page title -->

												<div class="row">
																<div class="col-lg-12">
																				<div class="card">
																								<div class="card-header">
																												<h4 class="card-title mb-0">Promoter Report</h4>
																								</div><!-- end card header -->

																								<div class="card-body">
																												<div id="customerList">
																																<div class="row g-4 mb-3">
																																				<div class="col-sm-auto">
																																								<div>
                                                                                                                                                                                <a href="{{ route("promoter.report.paginate.get") }}" type="button" class="btn btn-dark add-btn" id="create-btn"><i
																				                                                                                                        class="ri-arrow-go-back-line me-1 align-bottom"></i> Go Back</a>
                                                                                                                                                                                <a href="{{ route("promoter.report.list.excel") }}?{{ request()->getQueryString() }}" download type="button"
																																												class="btn btn-info add-btn" id="create-btn"><i
																																																class="ri-file-excel-fill me-1 align-bottom"></i> Excel Download</a>
																																								</div>
																																				</div>
																																</div>
																																<div class="table-responsive table-card mb-1 mt-3">
																																				@if ($data->total() > 0)
																																								<table class="table-nowrap table align-middle" id="customerTable">
																																												<thead class="table-light">
																																																<tr>
																																																				<th class="sort" data-sort="customer_name">Sl No.</th>
																																																				<th class="sort" data-sort="customer_name">Date</th>
																																																				<th class="sort" data-sort="customer_name">No. of Visits</th>
																																																				<th class="sort" data-sort="customer_name">App Installed</th>
																																																				<th class="sort" data-sort="customer_name">App Not Installed</th>
																																																</tr>
																																												</thead>
																																												<tbody class="list form-check-all">
																																																@foreach ($data->items() as $item)
																																																				<tr>
																																																								<td class="customer_name">{{ $item->SL_NO }}</td>
																																																								<td class="customer_name">{{ $item->DATE }}</td>
																																																								<td class="customer_name">{{ $item->NO_OF_VISITS }}</td>
																																																								<td class="customer_name">{{ $item->APP_INSTALLED }}</td>
																																																								<td class="customer_name">{{ $item->APP_NOT_INSTALLED }}</td>
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
