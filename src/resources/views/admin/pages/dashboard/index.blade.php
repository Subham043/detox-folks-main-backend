@extends("admin.layouts.dashboard")

@section("css")

				<style nonce="{{ csp_nonce() }}">
								.no-box-shadow {
												box-shadow: none;
								}
				</style>

@stop

@section("content")

				<div class="page-content">
								<div class="container-fluid">

												<x-includes.breadcrumb link="dashboard.get" page="Dashboard" :list='["PARCEL COUNTER"]' />
												<div class="row project-wrapper">
																<div class="col-xxl-12">

																				<div class="row">

																								<div class="col-xl-12">
																												<div>

																																<div class="card-body p-0">
																																				<div class="p-3">
																																								<div class="row">
                                                                                                                                                                                @hasanyrole("Staff|Super-Admin|Inventory Manager")
																																												<a href="{{ route("order_admin.paginate.get") }}" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i class="ri-shopping-bag-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">{{ $total_orders }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Total Orders
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->

																																												<a href="{{ route("order_admin.paginate.get") }}?filter[has_status]=CONFIRMED" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i class="ri-shopping-bag-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">{{ $total_confirmed_orders }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Total Orders Confirmed
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->

																																												<a href="{{ route("order_admin.paginate.get") }}?filter[has_status]=PACKED" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">
																																																																												{{ $total_packed_orders }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Total Orders Packed
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->

																																												<a href="{{ route("order_admin.paginate.get") }}?filter[has_status]=OUT FOR DELIVERY" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i class="ri-shopping-bag-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">{{ $total_ofd_orders }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Total Orders Out For Delivery
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->

																																												<a href="{{ route("order_admin.paginate.get") }}?filter[has_status]=DELIVERED" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i class="ri-shopping-bag-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">{{ $total_delivered_orders }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Total Orders Delivered
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->

																																												<a href="{{ route("order_admin.paginate.get") }}?filter[has_status]=CANCELLED" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i class="ri-shopping-bag-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">{{ $total_cancelled_orders }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Total Orders Cancelled
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->
                                                                                                                                                                                @endhasanyrole

                                                                                                                                                                                @hasanyrole("Staff|Super-Admin")
																																												<a href="{{ route("order_admin.paginate.get") }}?filter[has_payment_status]=PENDING" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">&#8377;
																																																																												{{ $total_payment_pending }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Total Amount Pending
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->

																																												<a href="{{ route("order_admin.paginate.get") }}?filter[has_payment_status]=PAID" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i
																																																																								class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">&#8377;
																																																																												{{ $total_payment_paid }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Total Amount Paid
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->

																																												<a href="{{ route("order_admin.paginate.get") }}?filter[has_payment_status]=REFUND" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i
																																																																								class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">&#8377;
																																																																												{{ $total_payment_refund }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Total Amount Refund
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->
                                                                                                                                                                                @endhasanyrole

                                                                                                                                                                                @hasanyrole("Staff|Inventory Manager|Super-Admin")
																																												<a href="{{ route("product.paginate.get") }}" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i
																																																																								class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">
																																																																												{{ $total_products }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Total Products
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->
                                                                                                                                                                                @endhasanyrole

                                                                                                                                                                                @hasanyrole("Inventory Manager|Super-Admin")
                                                                                                                                                                                <a href="{{ route("category.paginate.get") }}" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i
																																																																								class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">
																																																																												{{ $categories }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Product Categories
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->

                                                                                                                                                                                <a href="{{ route("sub_category.paginate.get") }}" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i
																																																																								class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">
																																																																												{{ $sub_categories }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Product Sub-Categories
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->

                                                                                                                                                                                @endhasanyrole

                                                                                                                                                                                @hasanyrole("Super-Admin")
                                                                                                                                                                                <a href="{{ route("user.paginate.get") }}?filter[has_role]=Super-Admin" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i
																																																																								class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">
																																																																												{{ $admin_users }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Admins
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->

                                                                                                                                                                                <a href="{{ route("user.paginate.get") }}?filter[has_role]=Staff" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i
																																																																								class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">
																																																																												{{ $staff_users }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Staffs
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->

                                                                                                                                                                                <a href="{{ route("user.paginate.get") }}?filter[has_role]=Content Manager" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i
																																																																								class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">
																																																																												{{ $content_manager_users }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Content Managers
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->

                                                                                                                                                                                <a href="{{ route("user.paginate.get") }}?filter[has_role]=Inventory Manager" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i
																																																																								class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">
																																																																												{{ $inventory_manager_users }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Inventory Managers
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->

                                                                                                                                                                                <a href="{{ route("user.paginate.get") }}?filter[has_role]=Warehouse Manager" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i
																																																																								class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">
																																																																												{{ $warehouse_manager_users }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Warehouse Managers
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->

                                                                                                                                                                                <a href="{{ route("delivery_management.agent.paginate.get") }}" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i
																																																																								class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">
																																																																												{{ $delivery_agent_users }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Delivery Agents
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->

                                                                                                                                                                                <a href="{{ route("user.paginate.get") }}?filter[has_role]=User" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i
																																																																								class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">
																																																																												{{ $normal_users }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Customers
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->

                                                                                                                                                                                @endhasanyrole

                                                                                                                                                                                @hasanyrole("Super-Admin|Sales Coordinators")

                                                                                                                                                                                <a href="{{ route("promoter.agent.paginate.get") }}" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i
																																																																								class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">
																																																																												{{ $reward_rider_users }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Reward Riders
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->

                                                                                                                                                                                <a href="{{ route("promoter.agent.paginate.get") }}" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i
																																																																								class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">
																																																																												{{ $referral_rockstar_users }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Referral Rockstars
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->

                                                                                                                                                                                <a href="{{ route("promoter.agent.paginate.get") }}" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i
																																																																								class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">
																																																																												{{ $app_promoter_users }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				App Promoters
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->
                                                                                                                                                                                @endhasanyrole

                                                                                                                                                                                @hasanyrole("Staff|Super-Admin")
                                                                                                                                                                                <a href="{{ route("enquiry.contact_form.paginate.get") }}" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i
																																																																								class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">
																																																																												{{ $contact_enquiry }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Contact Form Enquiries
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->

                                                                                                                                                                                <a href="{{ route("enquiry.order_form.paginate.get") }}" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i
																																																																								class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">
																																																																												{{ $order_enquiry }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Order Form Enquiries
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->
                                                                                                                                                                                @endhasanyrole

                                                                                                                                                                                @hasanyrole("Super-Admin|Content Manager")
                                                                                                                                                                                <a href="{{ route("testimonial.paginate.get") }}" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i
																																																																								class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">
																																																																												{{ $testimonials }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Testimonials
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->

                                                                                                                                                                                <a href="{{ route("legal.paginate.get") }}" class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i
																																																																								class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">
																																																																												{{ $legal_pages }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Legal Pages
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</a><!-- end col -->
                                                                                                                                                                                @endhasanyrole

                                                                                                                                                                                @hasanyrole("App Promoter|Reward Riders|Referral Rockstars")
                                                                                                                                                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
																																																<div class="card card-animate no-box-shadow">
																																																				<div class="card-body">
																																																								<div class="d-flex align-items-center">
																																																												<div class="avatar-sm flex-shrink-0">
																																																																<span
																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																				<i
																																																																								class="ri-money-dollar-circle-line text-success"></i>
																																																																</span>
																																																												</div>
																																																												<div class="flex-grow-1 ms-3">
																																																																<div class="d-flex align-items-center">
																																																																				<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																												class="text-uppercase">&#8377;
																																																																												{{ $installer }}</span>
																																																																				</h4>
																																																																</div>
																																																																<p class="text-muted mb-0">
																																																																				Total Promotions
																																																																</p>
																																																												</div>
																																																								</div>
																																																				</div><!-- end card body -->
																																																</div>
																																												</div><!-- end col -->
                                                                                                                                                                                @endhasanyrole

																																								</div>
																																				</div>
																																</div>

																												</div>
																								</div>

																				</div>

																</div>

																<div class="col-xxl-12">
																				@hasanyrole("Staff|Super-Admin")
																								<div class="row">

																												@if (count($health?->storedCheckResults ?? []))
																																<div class="col-xl-12">
																																				<div class="card card-height-100">
																																								<div class="card-header align-items-center d-flex border-0">
																																												<h4 class="card-title flex-grow-1 mb-0">Application Health Analytics</h4>
																																												<div class="flex-shrink-0">
																																																<ul class="nav justify-content-end nav-tabs-custom card-header-tabs border-bottom-0 rounded"
																																																				role="tablist">
																																																				<li class="nav-item" role="presentation">
																																																								<a type="button" href="{{ route("dashboard.get") }}?fresh"
																																																												class="btn btn-success btn-label"><i
																																																																class="ri-restart-line label-icon fs-16 me-2 align-middle"></i>
																																																												Refresh</a>
																																																				</li>
																																																</ul><!-- end ul -->
																																												</div>
																																								</div>

																																								<div class="card-body p-0">
																																												@if ($lastRanAt)
																																																<div
																																																				class="{{ $lastRanAt->diffInMinutes() > 5 ? "bg-soft-danger" : "bg-soft-success" }} p-3">
																																																				<div class="float-end ms-2">
																																																								<h6
																																																												class="{{ $lastRanAt->diffInMinutes() > 5 ? "text-danger" : "text-success" }} mb-0">
																																																												<span class="text-dark">Last Updated :
																																																												</span>{{ $lastRanAt->format("d M Y h:i A") }}
																																																								</h6>
																																																				</div>
																																																				<h6
																																																								class="{{ $lastRanAt->diffInMinutes() > 5 ? "text-danger" : "text-success" }} mb-0">
																																																								Application Status</h6>
																																																</div>
																																												@endif
																																												<div class="p-3">
																																																<div class="row">
																																																				@foreach ($health->storedCheckResults as $result)
																																																								<div class="col-xl-4">
																																																												<div class="card card-animate no-box-shadow">
																																																																<div class="card-body">
																																																																				<div class="d-flex align-items-center">
																																																																								<div class="avatar-sm flex-shrink-0">
																																																																												@if ($result->status == "ok")
																																																																																<span
																																																																																				class="avatar-title bg-soft-success text-success rounded-2 fs-2">
																																																																																				<i
																																																																																								class="ri-check-double-line text-success"></i>
																																																																																</span>
																																																																												@elseif($result->status == "warning")
																																																																																<span
																																																																																				class="avatar-title bg-soft-warning text-warning rounded-2 fs-2">
																																																																																				<i
																																																																																								class="ri-error-warning-line text-warning"></i>
																																																																																</span>
																																																																												@elseif($result->status == "crashed")
																																																																																<span
																																																																																				class="avatar-title bg-soft-primary text-primary rounded-2 fs-2">
																																																																																				<i class="ri-group-line text-primary"></i>
																																																																																</span>
																																																																												@elseif($result->status == "failed")
																																																																																<span
																																																																																				class="avatar-title bg-soft-danger text-danger rounded-2 fs-2">
																																																																																				<i class="ri-close-line text-danger"></i>
																																																																																</span>
																																																																												@else
																																																																																<!-- Question mark icon -->
																																																																																<span
																																																																																				class="avatar-title bg-soft-dark text-dark rounded-2 fs-2">
																																																																																				<i class="ri-bug-line text-dark"></i>
																																																																																</span>
																																																																												@endif
																																																																								</div>
																																																																								<div class="flex-grow-1 ms-3">
																																																																												<div class="d-flex align-items-center">
																																																																																<h4 class="fs-4 flex-grow-1 mb-0"><span
																																																																																								class="text-uppercase">{{ $result->label }}</span>
																																																																																</h4>
																																																																												</div>
																																																																												<p class="text-muted mb-0">
																																																																																@if (!empty($result->notificationMessage))
																																																																																				{{ $result->notificationMessage }}
																																																																																@else
																																																																																				{{ $result->shortSummary }}
																																																																																@endif
																																																																												</p>
																																																																								</div>
																																																																				</div>
																																																																</div><!-- end card body -->
																																																												</div>
																																																								</div><!-- end col -->
																																																				@endforeach
																																																</div>
																																												</div>
																																								</div>
																																				</div>
																																</div>
																												@endif

																								</div>
																				@endhasanyrole
																</div>
												</div>
								</div>
								<!-- container-fluid -->
				</div><!-- End Page-content -->

@stop
