@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="activity_log.paginate.get" page="Activity Logs" :list='["Detail"]' />
												<!-- end page title -->

												<div class="row">
																<div class="col-lg-12">
																				<div class="card">

																								<div class="card-body">
																												<div id="customerList">
																																<x-includes.back-button link="activity_log.paginate.get" />

																																<div class="text-muted">
																																				<div
																																								class="border-top border-top-dashed border-bottom border-bottom-dashed mt-4 pb-3 pt-3">
																																								<div class="row">

																																												<div class="col-lg-3 col-sm-6">
																																																<div>
																																																				<p class="text-uppercase fw-medium fs-13 mb-2">Log Name :</p>
																																																				<h5 class="fs-15 text-capitalize mb-0">{{ $data->log_name }}</h5>
																																																</div>
																																												</div>
																																												<div class="col-lg-3 col-sm-6">
																																																<div>
																																																				<p class="text-uppercase fw-medium fs-13 mb-2">Log Event :</p>
																																																				<h5 class="fs-15 text-capitalize mb-0">{{ $data->event }}</h5>
																																																</div>
																																												</div>
																																												<div class="col-lg-3 col-sm-6">
																																																<div>
																																																				<p class="text-uppercase fw-medium fs-13 mb-2">Performed By :</p>
																																																				<h5 class="fs-15 text-capitalize mb-0">{{ $data->causer->name }}</h5>
																																																</div>
																																												</div>
																																												<div class="col-lg-3 col-sm-6">
																																																<div>
																																																				<p class="text-uppercase fw-medium fs-13 mb-2">Performed :</p>
																																																				<h5 class="fs-15 text-capitalize mb-0">
																																																								{{ $data->created_at->diffForHumans() }}</h5>
																																																</div>
																																												</div>

																																								</div>
																																				</div>

																																				<div class="border-bottom border-bottom-dashed mt-4 pb-3">
																																								<div class="row">

																																												<div class="col-lg-12 col-sm-12">
																																																<div>
																																																				<p class="text-uppercase fw-medium fs-13 mb-2">Log Description :</p>
																																																				<h5 class="fs-15 text-capitalize mb-0">{{ $data->description }}</h5>
																																																</div>
																																												</div>

																																								</div>
																																				</div>

																																				<div class="border-bottom border-bottom-dashed mt-4 pb-3">
																																								<div class="row">

																																												<div class="col-lg-12 col-sm-12">
																																																<div>
																																																				<p class="text-uppercase fw-medium fs-13 mb-2">Attributes Affected :</p>
																																																				<h5 class="fs-15 mb-0">
																																																								<br />
																																																								<ul>
																																																												@foreach ($data->properties as $k => $v)
																																																																<li>
																																																																				<span
																																																																								class="badge badge-soft-dark text-uppercase">{{ $k }}</span>
																																																																				<br />
																																																																				<br />
																																																																				@if (gettype($v) == "array")
																																																																								@foreach ($v as $key => $val)
																																																																												<div class="px-3">
																																																																																<span
																																																																																				class="badge badge-soft-primary text-uppercase">{{ $key }}</span>
																																																																																: {{ $val }}
																																																																																<br />
																																																																																<br />
																																																																												</div>
																																																																								@endforeach
																																																																				@endif
																																																																				<br />
																																																																				<br />
																																																																</li>
																																																												@endforeach
																																																								</ul>
																																																				</h5>
																																																</div>
																																												</div>

																																								</div>
																																				</div>

																																</div>
																												</div>
																								</div>
																				</div>
																</div>
												</div>

								</div>
				</div>

@stop
