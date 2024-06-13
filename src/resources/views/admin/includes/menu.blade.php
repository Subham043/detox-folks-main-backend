<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
				<!-- LOGO -->
				<div class="navbar-brand-box">
								<!-- Dark Logo-->
								<a href="{{ route("dashboard.get") }}" class="logo logo-dark">
												<span class="logo-sm">
																<img src="{{ asset("admin/images/logo-sm.png") }}" alt="" height="22">
												</span>
												<span class="logo-lg">
																<img src="{{ asset("admin/images/logo.png") }}" alt="" height="17">
												</span>
								</a>
								<!-- Light Logo-->
								<a href="{{ route("dashboard.get") }}" class="logo logo-light">
												<span class="logo-sm">
																<img src="{{ asset("admin/images/logo-sm.png") }}" alt="" height="30">
												</span>
												<span class="logo-lg">
																<img src="{{ asset("admin/images/logo.png") }}" alt="" height="60">
												</span>
								</a>
								<button type="button" class="btn btn-sm fs-20 header-item float-end btn-vertical-sm-hover p-0"
												id="vertical-hover">
												<i class="ri-record-circle-line"></i>
								</button>
				</div>

				<div id="scrollbar">
								<div class="container-fluid">

												<div id="two-column-menu">
												</div>
												<ul class="navbar-nav" id="navbar-nav">
																<li class="menu-title"><span data-key="t-menu">Menu</span></li>

																<li class="nav-item">
																				<a class="nav-link menu-link {{ strpos(url()->current(), route("dashboard.get")) !== false ? "active" : "" }}"
																								href="{{ route("dashboard.get") }}">
																								<i class="ri-dashboard-fill"></i> <span data-key="t-widgets">Dashboard</span>
																				</a>
																</li>

																<li class="nav-item">
																				<a class="nav-link menu-link {{ strpos(url()->current(), route("enquiry.contact_form.paginate.get")) !== false ? "active" : "" }}"
																								href="{{ route("enquiry.contact_form.paginate.get") }}">
																								<i class="ri-survey-line"></i> <span data-key="t-widgets">Contact Form Enquiries</span>
																				</a>
																</li>

																<li class="nav-item">
																				<a class="nav-link menu-link {{ strpos(url()->current(), "user-management") !== false ? "active" : "" }}"
																								href="#sidebarDashboards1" data-bs-toggle="collapse" role="button"
																								aria-expanded="{{ strpos(url()->current(), "user-management") !== false ? "true" : "false" }}"
																								aria-controls="sidebarDashboards1">
																								<i class="ri-user-add-fill"></i> <span data-key="t-dashboards">User Management</span>
																				</a>
																				<div class="menu-dropdown {{ strpos(url()->current(), "user-management") !== false ? "show" : "" }} collapse"
																								id="sidebarDashboards1">
																								<ul class="nav nav-sm flex-column">
																												@can("list roles")
																																<li class="nav-item">
																																				<a href="{{ route("role.paginate.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("role.paginate.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Roles </a>
																																</li>
																												@endcan

																												@can("list users")
																																<li class="nav-item">
																																				<a href="{{ route("user.paginate.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("user.paginate.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Users </a>
																																</li>
																												@endcan

																								</ul>
																				</div>
																</li>

																<li class="nav-item">
																				<a class="nav-link menu-link {{ strpos(url()->current(), "content-management") !== false ? "active" : "" }}"
																								href="#sidebarDashboards2" data-bs-toggle="collapse" role="button"
																								aria-expanded="{{ strpos(url()->current(), "content-management") !== false ? "true" : "false" }}"
																								aria-controls="sidebarDashboards2">
																								<i class="ri-slideshow-line"></i> <span data-key="t-dashboards">Content Managment</span>
																				</a>
																				<div class="menu-dropdown {{ strpos(url()->current(), "content-management") !== false ? "show" : "" }} collapse"
																								id="sidebarDashboards2">
																								<ul class="nav nav-sm flex-column">
																												@can("list testimonials")
																																<li class="nav-item">
																																				<a href="{{ route("testimonial.paginate.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("testimonial.paginate.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Testimonials </a>
																																</li>
																												@endcan

																												@can("list blogs")
																																<li class="nav-item">
																																				<a href="{{ route("blog.paginate.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("blog.paginate.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Blogs </a>
																																</li>
																												@endcan

																												@can("list legal pages")
																																<li class="nav-item">
																																				<a href="{{ route("legal.paginate.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("legal.paginate.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Legal Pages </a>
																																</li>
																												@endcan

																												@can("list features")
																																<li class="nav-item">
																																				<a href="{{ route("feature.paginate.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("feature.paginate.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Features </a>
																																</li>
																												@endcan

																												@can("edit about page content")
																																<li class="nav-item">
																																				<a href="{{ route("about.main.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("about.main.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> About Page </a>
																																</li>
																												@endcan

																								</ul>
																				</div>
																</li>

																<li class="nav-item">
																				<a class="nav-link menu-link {{ strpos(url()->current(), "product-management") !== false ? "active" : "" }}"
																								href="#sidebarDashboards3" data-bs-toggle="collapse" role="button"
																								aria-expanded="{{ strpos(url()->current(), "product-management") !== false ? "true" : "false" }}"
																								aria-controls="sidebarDashboards3">
																								<i class="ri-dropbox-line"></i> <span data-key="t-dashboards">Product Management</span>
																				</a>
																				<div class="menu-dropdown {{ strpos(url()->current(), "product-management") !== false ? "show" : "" }} collapse"
																								id="sidebarDashboards3">
																								<ul class="nav nav-sm flex-column">
																												@can("list categories")
																																<li class="nav-item">
																																				<a href="{{ route("category.paginate.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("category.paginate.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Categories </a>
																																</li>
																												@endcan

																												@can("list categories")
																																<li class="nav-item">
																																				<a href="{{ route("sub_category.paginate.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("sub_category.paginate.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Sub-Categories </a>
																																</li>
																												@endcan

																												@can("list products")
																																<li class="nav-item">
																																				<a href="{{ route("product.paginate.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("product.paginate.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Products </a>
																																</li>
																												@endcan

																								</ul>
																				</div>
																</li>

																@can("list charges")
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), route("charge.paginate.get")) !== false ? "active" : "" }}"
																												href="{{ route("charge.paginate.get") }}">
																												<i class="ri-money-dollar-circle-line"></i> <span data-key="t-widgets">Cart Charges</span>
																								</a>
																				</li>
																@endcan

																@can("list orders")
																				<li class="nav-item">
																								<a class="nav-link menu-link {{ strpos(url()->current(), route("order_admin.paginate.get")) !== false ? "active" : "" }}"
																												href="{{ route("order_admin.paginate.get") }}">
																												<i class="bx bx-shopping-bag"></i> <span data-key="t-widgets">Orders</span>
																								</a>
																				</li>
																@endcan

																<li class="nav-item">
																				<a class="nav-link menu-link {{ strpos(url()->current(), "logs") !== false ? "active" : "" }}"
																								href="#sidebarDashboards4" data-bs-toggle="collapse" role="button"
																								aria-expanded="{{ strpos(url()->current(), "logs") !== false ? "true" : "false" }}"
																								aria-controls="sidebarDashboards4">
																								<i class="ri-alarm-warning-line"></i> <span data-key="t-dashboards">Application Logs</span>
																				</a>
																				<div class="menu-dropdown {{ strpos(url()->current(), "logs") !== false ? "show" : "" }} collapse"
																								id="sidebarDashboards4">
																								<ul class="nav nav-sm flex-column">
																												@can("list activity logs")
																																<li class="nav-item">
																																				<a href="{{ route("activity_log.paginate.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("activity_log.paginate.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Activity Logs </a>
																																</li>
																												@endcan

																												@can("view application error logs")
																																<li class="nav-item">
																																				<a href="{{ route("error_log.get") }}"
																																								class="nav-link {{ strpos(url()->current(), route("error_log.get")) !== false ? "active" : "" }}"
																																								data-key="t-analytics"> Error Logs </a>
																																</li>
																												@endcan

																								</ul>
																				</div>
																</li>

												</ul>
								</div>
								<!-- Sidebar -->
				</div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
