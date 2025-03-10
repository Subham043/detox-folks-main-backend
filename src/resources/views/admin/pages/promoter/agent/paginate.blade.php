@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="promoter.agent.paginate.get" page="Promoter" :list='["List"]' />
												<!-- end page title -->

												<div class="row">
																<div class="col-lg-12">
																				<div class="card">
																								<div class="card-header">
																												<h4 class="card-title mb-0">Promoters</h4>
																								</div><!-- end card header -->

																								<div class="card-body">
																												<div id="customerList">
																																<div class="row g-4 mb-3">
																																				<div class="col-sm-auto">
                                                                                                                                                                @if(auth()->user()->current_role=='Super-Admin')
																																								<div>
																																												<a href="{{ route("user.create.get") }}" type="button" target="_blank"
																																																class="btn btn-success add-btn" id="create-btn"><i
																																																				class="ri-add-line me-1 align-bottom"></i> Create Promoter</a>
																																								</div>
                                                                                                                                                                @endif
																																				</div>
																																				<div class="col-sm">
																																								<x-includes.search :search="$search"
																																												link="promoter.agent.paginate.get" />
																																				</div>
																																</div>
																																<div class="table-responsive table-card mb-1 mt-3">
																																				@if ($data->total() > 0)
																																								<table class="table-nowrap table align-middle" id="customerTable">
																																												<thead class="table-light">
																																																<tr>
																																																				<th class="sort" data-sort="customer_name">Name</th>
																																																				<th class="sort" data-sort="customer_name">Code</th>
																																																				<th class="sort" data-sort="customer_name">Email</th>
																																																				<th class="sort" data-sort="customer_name">Phone</th>
																																																				<th class="sort" data-sort="customer_name">Role</th>
																																																				<th class="sort" data-sort="customer_name">Total App Installed</th>
																																																				<th class="sort" data-sort="customer_name">Orders Count</th>
																																																				<th class="sort" data-sort="customer_name">Has Installer Completed 3 Order</th>
																																																				<th class="sort" data-sort="date">Created On</th>
																																																				<th class="sort" data-sort="action">Action</th>
																																																</tr>
																																												</thead>
																																												<tbody class="list form-check-all">
																																																@foreach ($data->items() as $item)
																																																				<tr>
																																																								<td class="customer_name">{{ $item->name }}</td>
																																																								<td class="customer_name"><code>{{ $item->app_promoter_code->code }}</code></td>
																																																								<td class="customer_name">{{ $item->email }}</td>
																																																								<td class="customer_name">{{ $item->phone }}</td>
                                                                                                                                                                                                                                <td class="customer_name">{{ $item->current_role }}</td>
																																																								<td class="customer_name">{{ $item->app_installer_count }}</td>
																																																								<td class="customer_name">{{ $item->no_of_orders }}</td>
                                                                                                                                                                                                                                @if ($item->no_of_orders >= 3)
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
                                                                                                                                                                                                                                                                @if(auth()->user()->current_role=='Super-Admin')
																																																																<div class="edit">
																																																																				<a href="{{ route("user.update.get", $item->id) }}"
																																																																								class="btn btn-sm btn-primary edit-item-btn">Edit</a>
																																																																</div>
                                                                                                                                                                                                                                                                @endif

																																																																<div class="edit">
																																																																				<a href="{{ route("promoter.agent.installer.get", $item->id) }}"
																																																																								class="btn btn-sm btn-warning edit-item-btn">App Installers</a>
																																																																</div>

                                                                                                                                                                                                                                                                @if(auth()->user()->current_role=='Super-Admin')
																																																																<div class="edit">
																																																																				<a href="{{ route("promoter.agent.installer_bank.get", $item->id) }}"
																																																																								class="btn btn-sm btn-secondary edit-item-btn">Bank Information</a>
																																																																</div>

																																																																<div class="remove">
																																																																				<button class="btn btn-sm btn-danger remove-item-btn"
																																																																								data-link="{{ route("user.delete.get", $item->id) }}">Delete</button>
																																																																</div>
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
