@extends("admin.layouts.dashboard")

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<!-- start page title -->
												<x-includes.breadcrumb link="enquiry.contact_form.paginate.get" page="Contact Form Enquiry" :list='["List"]' />
												<!-- end page title -->

												<div class="row">
																<div class="col-lg-12">
																				<div class="card">
																								<div class="card-header">
																												<h4 class="card-title mb-0">Contact Form Enquiry</h4>
																								</div><!-- end card header -->

																								<div class="card-body">
																												<div id="customerList">
																																<div class="row g-4 mb-3">
																																				<div class="col-sm-auto">
																																								<a href="{{ route("enquiry.contact_form.excel.get") }}" download type="button"
																																												class="btn btn-info add-btn" id="create-btn"><i
																																																class="ri-file-excel-fill me-1 align-bottom"></i> Excel Download</a>
																																				</div>
																																				<div class="col-sm">
																																								<x-includes.search :search="$search" link="enquiry.contact_form.paginate.get" />
																																				</div>
																																</div>
																																<div class="table-responsive table-card mb-1 mt-3" id="image-container">
																																				@if ($data->total() > 0)
																																								<table class="table-nowrap table align-middle" id="customerTable">
																																												<thead class="table-light">
																																																<tr>
																																																				<th class="sort" data-sort="customer_name">Name</th>
																																																				<th class="sort" data-sort="customer_name">Email</th>
																																																				<th class="sort" data-sort="customer_name">Phone</th>
																																																				<th class="sort" data-sort="customer_name">Page Url</th>
																																																				<th class="sort" data-sort="customer_name">Message</th>
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
																																																								<td class="customer_name"> <a href="{{ $item->page_url }}"
																																																																target="_blank"
																																																																rel="noopener noreferrer">{{ $item->page_url }}</a></td>
																																																								<td class="customer_name">{{ $item->message }}</td>
																																																								<td class="date">{{ $item->created_at->diffForHumans() }}</td>
																																																								<td>
																																																												<div class="d-flex gap-2">

																																																																<div class="remove">
																																																																				<button class="btn btn-sm btn-danger remove-item-btn"
																																																																								data-link="{{ route("enquiry.contact_form.delete.get", $item->id) }}">Delete</button>
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

@section("javascript")
				<script type="text/javascript" nonce="{{ csp_nonce() }}">
								const myViewer = new ImgPreviewer('#image-container', {
												// aspect ratio of image
												fillRatio: 0.9,
												// attribute that holds the image
												dataUrlKey: 'src',
												// additional styles
												style: {
																modalOpacity: 0.6,
																headerOpacity: 0,
																zIndex: 99
												},
												// zoom options
												imageZoom: {
																min: 0.1,
																max: 5,
																step: 0.1
												},
												// detect whether the parent element of the image is hidden by the css style
												bubblingLevel: 0,
								});
				</script>
@stop
